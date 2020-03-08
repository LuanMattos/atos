<?php

use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use Ratchet\Server\IoServer;

require dirname(__DIR__) . '/../vendor/autoload.php';
require dirname(__DIR__) . '/msg_socket/Chat.php';

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new \Chat\Chat()
        )
    ),
    8050
);

$server->run();