<?php
use PHPKonfApp\Server\Server;
use React\EventLoop\Loop;
use React\MySQL\Factory;

include __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
$loop = Loop::get();
$factory = new Factory($loop);
$db = $factory->createLazyConnection(
    getenv('DB_USER') . ':' . getenv('DB_PASSWORD') . '@' . getenv('DB_HOST') . '/' . getenv('DB_NAME'));


$server = new Server();
$server
    ->host(getenv('SOCKET_HOST') . ':' . getenv('SOCKET_PORT'))
    ->loop($loop)
    ->db($db)
    ->serve();
