<?php

include __DIR__ . '/../vendor/autoload.php';

$socket = new React\Socket\SocketServer('0.0.0.0:6666');
$socket->on('connection', function (React\Socket\ConnectionInterface $connection) {
    $connection->write("Merhaba " . $connection->getRemoteAddress() . "!\n");
    $connection->write("PHPKonf2023'e Hoşgeldiniz !\n");

    $connection->on('data', function ($data) use ($connection) {
        $connection->close();
    });
});