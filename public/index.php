<?php

// $timeStart = microtime(true);
// $memStart = memory_get_usage();

use App\App;

//session_start();

// $response  = new Response('sadsa');
// $response->headers->setCookie(Cookie::create('sadasd', 'asdasdsad'));
// $response->send();

require __DIR__ . '/../vendor/autoload.php';

//require __DIR__ . '/../'

setcookie('test2', 'test', 0, "", "", false, true);

//phpinfo();

$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();
$container = require __DIR__ . '/../src/Config/container.php';

$app = new App($container['request'], $container, $container['dispatcher']);
$response = $app->handle();
setcookie('test3', 'test', 0, "", "", false, true);
$response->send();

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