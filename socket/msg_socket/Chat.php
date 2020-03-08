<?php
namespace Chat;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Chat implements MessageComponentInterface {
    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen( ConnectionInterface $conn ) {
        $this->clients->attach( $conn );

        echo "Nova conexão! ({$conn->resourceId})\n";
    }

    public function onMessage( ConnectionInterface $from, $msg ) {
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
        $this->clients->detach( $conn );

        echo "Conexão {$conn->resourceId} foi desconectado\n";
    }

    public function onError( ConnectionInterface $conn, \Exception $e ) {
        echo "Um erro ocorreu: {$e->getMessage()}\n";

        $conn->close();
    }
}