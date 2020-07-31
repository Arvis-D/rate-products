<?php

namespace App\Factory;

class Factory
{
    public static $instances = [];

    public static function exists($key, $class)
    {
        if (!self::$instances) {
            return false;
        }
        return array_key_exists($key, self::$instances[$class]);
    }

    /**
     * If an instance with the specified name already exists in @var $instances
     * it will be returned,
     * otherwise, a new one will be created and returned
     * 
     * @var $instances holds all the created instances by factory
     *
     * @param string $name
     * @param string $class
     * @param callback $createInst specifies how an instance should be created
     * 
     * @return object $instance
     */

    public static function make($class, $createInst, $instName)
    {
        if (self::exists($instName, $class)) {

            return self::$instances[$class][$instName];
        } else {
            $inst = $createInst($class);
            self::$instances[$class][$instName] = $inst;
            
            return $inst;
        }
    }
}