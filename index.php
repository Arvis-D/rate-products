<?php
session_start();

//$memStart = memory_get_usage();

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/app/routes.php';

//$memEnd = memory_get_usage();
//$mem = $memEnd - $memStart;

//echo $mem;