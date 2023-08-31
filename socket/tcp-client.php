<?php

use React\EventLoop\Loop;

include __DIR__ . '/../vendor/autoload.php';

$connector = new React\Socket\Connector([
        'tcp' => true,
        'tls' => true,
        'unix' => true,
        'dns' => true,
        'timeout' => true,
        'happy_eyeballs' => true,
]);
$timeoutConnector = new React\Socket\TimeoutConnector($connector, 3.0);

$promise = $timeoutConnector->connect('127.0.0.1:6666')->then(function (React\Socket\ConnectionInterface $connection) {
    $connection->write('ACCESS');
    $connection->on('data', function ($data) {
        echo $data;
    });

    $connection->on('close', function () {
        echo 'Connection closed' . PHP_EOL;
    });
    
    Loop::addTimer(5, function () use ($connection) {
        $connection->end();
    });
    
}, function (Exception $e) {
    echo 'Error: ' . $e->getMessage() . PHP_EOL;
});




