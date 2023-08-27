<?php

include __DIR__ . '/vendor/autoload.php';

$socket = new React\Socket\SocketServer('0.0.0.0:6666');
$server = new React\Socket\LimitingServer($socket, 1);
$socket->on('connection', function (React\Socket\ConnectionInterface $connection) {
    $connection->write("Merhaba " . $connection->getRemoteAddress() . "!\n");
    $connection->write("PHPKonf2023'e Hoşgeldiniz !\n");

    $connection->on('data', function ($data) use ($connection) {
        $data = trim(preg_replace('/[^\w\d \.\,\-\!\?]/u', '', $data));
        
        if ($data == 'ACCESS') {
            $connection->write('TRUE' . PHP_EOL);
        } else {
            $connection->write('FALSE' . PHP_EOL);
        }
        $connection->end($data . PHP_EOL);
        // $connection->close();
    });

    $connection->on('close', function () use ($connection) {
        echo '[' . $connection->getRemoteAddress() . ' güle güle]' . PHP_EOL;
    });
});

$socket->on('error', function (Exception $e) {
    echo 'Error: ' . $e->getMessage() . PHP_EOL;
});