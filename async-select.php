<?php

use React\EventLoop\Loop;
use React\MySQL\Factory;

include __DIR__ . '/vendor/autoload.php';

$loop = Loop::get();
$factory = new Factory($loop);
$connection = $factory->createLazyConnection('root:phpkonf@db/phpkonf');

$formatter = new \React\Stream\ThroughStream(function ($data) {
    return json_decode($data['data'], true)['value'] . ';' . strtotime($data['created_at']) . "\n";
});

$file = new \React\Stream\WritableResourceStream(fopen('data.txt', 'w'), $loop);

$start = microtime(true);

$connection->queryStream('SELECT * FROM raw_data')->pipe($formatter)->pipe($file);

echo 'Time: ' . (microtime(true) - $start) . PHP_EOL;

$connection->quit();
