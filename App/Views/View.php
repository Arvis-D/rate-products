<?php

namespace App\Views;

use App\Factories\Factory;

abstract class View extends Factory
{
    protected $data = [];
    protected $parent = '';
    public $child = false;
    public $extendAs = '';
    public $children = [];
    public static $instances = [];

    public static function get($viewname)
    {
        return self::make($viewname, function () use ($viewname) {
            $viewname = "\App\Views\\{$viewname}";
            return new $viewname();
        });
    }

    public function child($childName)
    {
        $child = $this->children[$childName];
        $child->child = true;
        return $child;
    }

    public function show()
    {   
        if (!empty($this->parent) && !$this->child) {
            $this->extended = true;
            $parent = self::get($this->parent);
            $parent->children[$this->extendAs] = $this;
            $parent->show();
        } else {
            $this->child = false;
            $this->render();
        }
    }

    public function data($data)
    {
        $this->data = $data;
        return $this;
    }
}

