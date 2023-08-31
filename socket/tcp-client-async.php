<?php

include __DIR__ . '/../vendor/autoload.php';

use React\EventLoop\Loop;
use React\Socket\Connector;
use React\Promise\Promise;

$loop = Loop::get();
$connector = new Connector($loop);
$promises = [];
$requests = ['ACCESS', 'PHP', 'Konf'];

$promises = array_map(function ($request) use ($loop) {
    $connector = new Connector($loop);
    $promise = $connector->connect('127.0.0.1:6666');
    
    return $promise->then(function (React\Socket\ConnectionInterface $connection) use ($request) {
        $connection->write($request . "\n");
        
        return new Promise(function ($resolve) use ($connection) {
            $buffer = '';
            $connection->on('data', function ($data) use (&$buffer) {
                $buffer .= $data;
            });
            $connection->on('close', function () use (&$buffer, $resolve, $connection) {
                $resolve($buffer);
                $connection->end();
            });
        });        
    });
}, $requests);

\React\Promise\all($promises)->then(function ($responses) {
    foreach ($responses as $response) {
        echo "Response: " . $response . PHP_EOL;
    }
});

$loop->run();




