<?php

// $ composer require react/http react/socket # install example using Composer
// $ php example.php # run example on command line, requires no additional web server

require __DIR__ . '/vendor/autoload.php';

$http = new React\Http\HttpServer(function (Psr\Http\Message\ServerRequestInterface $request) {
    return React\Http\Message\Response::json([
        'method' => $request->getMethod(),
        'url' => (string)$request->getUri(),
        'headers' => $request->getHeaders(),
        'body' => (string)$request->getBody(),
    ]);
});

$socket = new React\Socket\SocketServer('0.0.0.0:8081');
$http->listen($socket);

echo "Server running at http://127.0.0.1:8081" . PHP_EOL;