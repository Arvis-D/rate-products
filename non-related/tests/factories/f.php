<?php

$mem = memory_get_usage();

class A
{
    public $a;
}

class B
{
    public $b;

    public function __construct(A $a)
    {
        $this->b = $a;
    }
}

class Factory
{
    public static function exists($key, $class)
    {
        return array_key_exists($key, $class::$instances);
    }

    public static function make($name, $createInst)
    {
        $class = get_called_class();
        $name = (!isset($name) ? $class : $name);
        if($class::exists($name, $class)){
            return $class::$instances[$name];
        } else {
            $inst = $createInst();
            $class::$instances[$name] = $inst;
            return $inst;
        }
    }
}

class AFactory extends Factory
{
    public static $instances = [];

    public static function give($name = null)
    {
        return self::make($name, function () {
            return new A;
        });
    }
}

class BFactory extends Factory
{
    public static $instances = [];

    public static function give($name = null)
    {
        return self::make($name, function () {
            return new B(AFactory::give());
        });
    }
}

$a = AFactory::give('someObj');
$a->a = "asdasd";
echo AFactory::give('someObj')->a;



$mem = memory_get_usage() - $mem;
print_r(AFactory::$instances);
echo "<br>" . $mem;