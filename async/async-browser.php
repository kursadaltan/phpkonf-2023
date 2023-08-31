<?php

include __DIR__ . '/../vendor/autoload.php';

use Psr\Http\Message\ResponseInterface;
use React\Http\Browser;

$browser = new Browser();

$start = microtime(true);
$promise = $browser->get('https://download.samplelib.com/mp4/sample-5s.mp4')
->then(function (ResponseInterface $response) use ($start) {
    echo 'SampleLib Time: ' . (microtime(true) - $start) . PHP_EOL;
    return "SampleLib size = " . $response->getBody()->getSize();
}, function (Exception $e) {
    echo 'Error: ' . $e->getMessage() . PHP_EOL;
});

$medianova = microtime(true);
$promise = $browser->get('https://sample-videos.mncdn.org/mp4/sample-5s.mp4')
->then(function (ResponseInterface $response) use ($medianova) {
    echo 'Medianova Time: ' . (microtime(true) - $medianova) . PHP_EOL;
    return "Medianova.com size = " . $response->getBody()->getSize();
}, function (Exception $e) {
    echo 'Error: ' . $e->getMessage() . PHP_EOL;
});
