<?php

namespace App\Factories;

class Factory
{
    protected static function exists($key, $class)
    {
        return array_key_exists($key, $class::$instances);
    }

    /**
     * If an instance with the specified name already exists in @var $instances of the child class
     * it will be returned,
     * otherwise, a new one will be created and returned
     * 
     * @var $instances holds all the created instances by child factory
     *
     * @param string $name
     * @param callback $createInst specifies how an instance should be created
     * 
     * @return object $instance
     */

    protected static function make($name, $createInst)
    {
        $class = get_called_class();
        $name = (!isset($name) ? $class : $name);
        if ($class::exists($name, $class)) {

            return $class::$instances[$name];
        } else {
            $inst = $createInst();
            $class::$instances[$name] = $inst;
            
            return $inst;
        }
    }
}