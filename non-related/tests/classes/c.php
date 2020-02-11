<?php

$mem = memory_get_usage();

class F
{
    public static $instances = [];
}

class A extends F
{
    private $data;

    public function __construct()
    {
        array_push(self::$instances, $this);
    }
}

$a = new A;
$b = new A;

$c = A::$instances[1];

$mem -= memory_get_usage();

echo "<br>" . -$mem;