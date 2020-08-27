<?php

// $timeStart = microtime(true);
// $memStart = memory_get_usage();

use App\App;

require __DIR__ . '/../vendor/autoload.php';

//require __DIR__ . '/../'

//phpinfo();

$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();
$container = require __DIR__ . '/../src/Config/container.php';

$app = new App($container['request'], $container, $container['dispatcher']);
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