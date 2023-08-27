<?php

include __DIR__ . '/../vendor/autoload.php';

use React\EventLoop\Loop;

Loop::addTimer(0.5, React\Async\async(function () {
    echo 'Merhaba' . PHP_EOL;
    React\Async\await(React\Promise\Timer\sleep(1.0));
    // sleep(1);
    echo 'Dünya' . PHP_EOL;
}));

Loop::addTimer(1.0, function () {
    echo 'Yeni' . PHP_EOL;
});

// t=0,5s'de "Merhaba" yazdırır 
// t=1,0s'de "Yeni" yazdırır 
// t=1,5s'de "Dünya" yazdırır
