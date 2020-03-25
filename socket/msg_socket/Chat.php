<?php
namespace Chat;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Chat implements MessageComponentInterface {
    protected $clients;
    private $subscriptions;
    private $users;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
        $this->subscriptions = [];
        $this->users = [];
    }

    public function onOpen( ConnectionInterface $conn ) {
        $this->clients->attach( $conn );
        $this->users[$conn->resourceId] = $conn;
//        $this->clients->attach( $conn );

        echo "Nova conexão! ({$conn->resourceId})\n";


    }

    public function onMessage( ConnectionInterface $from, $msg ) {
        $data = json_decode($msg);
        var_dump($data);

        switch ($data->command) {
            case "subscribe":
                $this->subscriptions[$from->resourceId] = $data->channel;
                var_dump($this->subscriptions);
                break;
            case "message":
                var_dump($this->subscriptions);

                if (isset($this->subscriptions[$from->resourceId])) {
                    $target = $this->subscriptions[$from->resourceId];
                    var_dump($target);
                    foreach ($this->subscriptions as $id=>$channel) {
                        var_dump($channel);
                        var_dump($id);
                        var_dump($from->resourceId);

                        if ($channel == $target && $id != $from->resourceId) {
                            echo "Enviou";
                            $this->users[$id]->send($msg);
                        }
                    }
                }
        }
//        $numRecv = count( $this->clients ) - 1;
//        echo sprintf('Conexão %d enviou mensagem "%s" para %d outra conexão%s' . "\n"
//            , $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');
//
//        foreach ( $this->clients as $client ) {
//            if ( $from !== $client ) {
//                $client->send( $msg );
//            }
//        }
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
}