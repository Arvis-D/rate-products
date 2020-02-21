<?php

namespace App;

class Factory
{
    public static $instances = [];

    private static function exists($key, $class)
    {
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

    public static function make($name, $class, $createInst)
    {
        if (self::exists($name, $class)) {

            return self::$instances[$class][$name];
        } else {
            $inst = $createInst();
            self::$instances[$class][$name] = $inst;
            
            return $inst;
        }
    }
}