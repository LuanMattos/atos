<?php
//
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use Ratchet\Server\IoServer;

use Ratchet\ConnectionInterface;
use Ratchet\Wamp\WampServerInterface;
use React\EventLoop\LoopInterface;
//
//require '../../../../vendor/autoload.php';
//require dirname(__DIR__) . '/msg_socket/Chat.php';
//
//$server = IoServer::factory(
//    new HttpServer(
//        new WsServer(
//            new \Chat\Chat()
//        )
//    ),
//    8088
//);
//
//$server->run();
require '../../../../vendor/autoload.php';
require dirname(__DIR__) . '/msg_socket/Chat.php';
$loop = React\EventLoop\Factory::create();
$pusher = new \Chat\Chat();

// Listen for the web server to make a ZeroMQ push after an ajax request
$context = new React\ZMQ\Context($loop);
$pull = $context->getSocket(ZMQ::SOCKET_PULL);

$pull->bind('tcp://127.0.0.1:8090'); // Binding to 127.0.0.1 means the only client that can connect is itself
//$pull->on('onMessage', [$pusher, 'onUpdate']);

// Set up our WebSocket server for clients wanting real-time updates
$webSock = new React\Socket\Server('0.0.0.0:8443', $loop);
$webSock = new React\Socket\SecureServer($webSock, $loop, [
//    'local_cert'        => 'C:/xampp/apache/conf/ssl.crt/server.crt', // path to your cert
    'local_cert'        => '/etc/letsencrypt/live/www.atos.click/fullchain.pem', // path to your cert
//    'local_pk'          => 'C:/xampp/apache/conf/ssl.key/server.key', // path to your server private key
    'local_pk'          => '/etc/letsencrypt/live/www.atos.click/privkey.pem', // path to yo ur server private key
    'allow_self_signed' => TRUE, // Allow self signed certs (should be false in production)
    'verify_peer' => FALSE
]);
//$webSock->listen(8443, '0.0.0.0'); // Binding to 0.0.0.0 means remotes can connect
$webServer = new Ratchet\Server\IoServer(
    new Ratchet\Http\HttpServer(
        new Ratchet\WebSocket\WsServer(
            new Ratchet\Wamp\WampServer(
                $pusher
            )
        )
    ),
    $webSock
);

$loop->run();