<?php

namespace App\Factory;

class Recipe
{
    public $name;
    public $class;
    public $dependencies = [];

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function val($value)
    {
        array_push($this->dependencies, ['value' => $value, 'inst' => false]);
        return $this;
    }

    public function inst($class)
    {
        array_push($this->dependencies, ['value' => $class, 'inst' => true]);
        return $this;
    }

    public static function create(string $name = 'basic')
    {
        return new Recipe($name);
    }
}