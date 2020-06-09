<?php

use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use Ratchet\Server\IoServer;

require '../../../../vendor/autoload.php';
require dirname(__DIR__) . '/msg_socket/Chat.php';

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new \Chat\Chat()
        )
    ),
    8090
);

$loop    = React\EventLoop\Factory::create();


$server = new React\Socket\TcpServer(8000, $loop);
$server = new React\Socket\SecureServer($server, $loop, array(
    'local_cert' => '/etc/letsencrypt/live/www.atos.click/fullchain.pem',
    'local_pk' => '/etc/letsencrypt/live/www.atos.click/privkey.pem',
    'allow_self_signed' => true,
    'verify_peer' => false
));



$server->run();