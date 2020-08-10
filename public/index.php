<?php

// $timeStart = microtime(true);
// $memStart = memory_get_usage();

use App\App;

require __DIR__ . '/../vendor/autoload.php';

$app = new App(require __DIR__ . '/../src/Config/container.php');
$response = $app->handle();
$response->send();

// $app = new App\App();
// $app->start();

// $memEnd = memory_get_usage();
// $timeEnd = microtime(true);
// $time = $timeEnd - $timeStart;
// $mem = $memEnd - $memStart;

// foreach (\App\Factory::$instances as $key1 => $class) {
//     echo $key1 . '<br>';
//     foreach ($class as $key2 => $instance) {
//         echo $key2.'<br>';
//     }
// }