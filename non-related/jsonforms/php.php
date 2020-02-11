<?php
$start = microtime(true);
$a = json_decode($_POST['jsonData']);
$time_elapsed_secs = microtime(true) - $start;

echo $a->name . " " . $time_elapsed_secs;