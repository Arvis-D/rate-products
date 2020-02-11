<?php

$timeStart = microtime(true);

ob_start();
include 'e.phtml';
$string = ob_get_clean();
echo $string;

$timeEnd = microtime(true) - $timeStart;
//$timeEnd / 1000;

echo "<br> {$timeEnd}"; 