<?php
use React\EventLoop\Loop;
use React\MySQL\Factory;
use React\MySQL\QueryResult;
use function React\Async\await;

include __DIR__ . '/../vendor/autoload.php';

$loop = Loop::get();
$factory = new Factory($loop);
$connection = $factory->createLazyConnection('root:phpkonf@db/phpkonf');

$start = microtime(true);

foreach(range(1, 120000) as $i) {
    $json = addslashes(json_encode(["value" => rand(210,230), "measure" => "voltage"]));
    $connection->query('INSERT INTO raw_data (`data`, `device_id`, `created_at`) VALUES ("' . $json .'", 10, now())')
        ->then(function (QueryResult $command) {
        }, function (Exception $error) {
            echo 'Error: ' . $error->getMessage() . PHP_EOL;
        });

    $kmemReal = round((memory_get_usage() / 1024) / 1024);
    if ($kmemReal >= 32) {
        await(React\Promise\Timer\sleep(0.01));
    }
}
echo 'Time: ' . (microtime(true) - $start) . PHP_EOL;
$connection->quit();
