<?php

class bubuInyourface
{
    protected $ss = "asd";

    public function shit()
    {
        echo "fgdfgdf";
    }
}


class bubu// extends bubuInyourface
{
    private static $instances;
    private $face;

    public function __construct()
    {
        //$this->face = false;
    }

    public function shit($a,  $b)
    {
        $this->face = $a+ $b;
    }
}

$a = new bubu;
//$a->shit();

$t1 = microtime(true);
for($i = 0; $i < 1000000; $i++){
    $a->shit(312, 124);
}
$t2 = microtime(true);


$elapsed = $t2 - $t1;

echo "<br>" . memory_get_usage()/1000 . "<br>";
echo "<br>" . $elapsed . "<br>";