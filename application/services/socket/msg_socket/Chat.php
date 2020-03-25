<?php
namespace Chat;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Chat implements \Ratchet\WebSocket\MessageComponentInterface {
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
        echo json_encode($conn->resourceId);


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

                if (isset($this->subscriptions[$from->resourceId])) {
                    $target = $this->subscriptions[$from->resourceId];
                    foreach ($this->subscriptions as $id=>$channel) {
//                        && $id != $from->resourceId
                        if ($channel == $target ) {
                            $this->users[$channel]->send($msg);
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
