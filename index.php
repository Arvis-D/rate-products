<?php
session_start();

// $timeStart = microtime(true);
// $memStart = memory_get_usage();

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/App/routes.php';

// $memEnd = memory_get_usage();
// $timeEnd = microtime(true);
// $time = $timeEnd - $timeStart;
// $mem = $memEnd - $memStart;

// echo $time;

// foreach (\App\Factory::$instances as $key1 => $class) {
//     echo $key1 . '<br>';
//     foreach ($class as $key2 => $instance) {
//         echo $key2.'<br>';
//     }
// }