<?php

namespace Chat;
use MongoDB\BSON\ObjectId;
use MongoDB\Collection;
use MongoDB\Driver\Manager;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;

require_once '../../../../application/config/database_chat.php';

class Chat  implements MessageComponentInterface {
    protected $clients;
    private $subscriptions;
    private $users;
    private $config;
    private $mongodb;
    private $mongobulkwrite;
    private $mongomanager;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
        $this->subscriptions = [];
        $this->users = [];
        $config         = new \database_chat();
        $this->config   = (object)$config->config_mongo(true);
        $this->mongodb        = new \MongoDB\Client("mongodb://".$this->config->hostname . ":" . $this->config->port,[],[]);
        $this->mongobulkwrite = new \MongoDB\Driver\BulkWrite();
        $this->mongomanager   = new Manager("mongodb://".$this->config->hostname . ":" . $this->config->port,[],[]);

    }


    public function onOpen( ConnectionInterface $conn ) {
        $id_usuario = $conn->httpRequest->getUri()->getQuery();
        $id = $conn->httpRequest->getHeader ('Cookie');

        $usuario     = $this->mongodb->{$this->config->database}->us_usuarios->find(["_id"=>$id_usuario],['limit'=>1])->toArray();
        $msg_usuario = $this->mongodb->{$this->config->database}->msg_usuarios->find(["codusuario"=>$id_usuario],['limit'=>1])->toArray();
        if(!empty( $usuario ) && !empty( $id ) ){

            $data = [
                "codusuario" => $usuario[0]->_id,
                "status"     => 1,
                "token"      => md5($id[0]),
                "resourceId" => $conn->resourceId
            ];

        if(count($msg_usuario)){
            $this->mongocollection("msg_usuarios",[])->updateOne(["_id"=>new \MongoDB\BSON\ObjectId($msg_usuario[0]['_id'])],['$set'=>$data]);
        }else{
            $this->mongodb->{$this->config->database}->msg_usuarios->insertOne( $data );
        }

            $this->users[$conn->resourceId] = $conn;
//          $this->clients->attach( $conn );

            echo "Nova conexão! ({$conn->resourceId})\n";
            echo json_encode($conn->resourceId);

        }

   }
    public function msgToUser($msg, $id) {
        $this->clients[$id]->send($msg);
    }

    public function onMessage( ConnectionInterface $from, $msg ) {

        $data = json_decode($msg);

        switch ($data->command) {
            case "subscribe":
                $this->subscriptions[$from->resourceId] = $data->channel;
                break;
            case "message":
//                        && $id != $from->resourceId
            echo "==========>>>".isset($data->channel)?$data->channel:'';
                        if(isset( $this->users[$data->channel] )){
                            $this->users[$data->channel]->send($msg);
                        }

        }
        $numRecv = count( $this->clients ) - 1;
        echo sprintf('Conexão %d enviou mensagem "%s" para %d outra conexão%s' . "\n"
            , $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');

        foreach ( $this->clients as $client ) {
            if ( $from !== $client ) {
                $client->send( $msg );
            }
        }
    }

    public function onClose( ConnectionInterface $conn ) {
//        $this->clients->detach( $conn );
//
        echo "Conexão {$conn->resourceId} foi desconectado\n";
        $this->clients->detach($conn);
        unset($this->users[$conn->resourceId]);
        unset($this->subscriptions[$conn->resourceId]);
    }

    public function onError( ConnectionInterface $conn, \Exception $e ) {
        echo "Um erro ocorreu: {$e->getMessage()}\n";

        $conn->close();
    }
    public function mongocollection($collection,$options){
        return  new Collection($this->mongomanager,$this->config->database,$collection,$options);
    }

}

