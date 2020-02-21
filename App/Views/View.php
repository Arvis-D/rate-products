<?php

namespace App\Views;

use App\Factory;

/**
 * Each view will inherit this class
 */

abstract class View
{
    protected $parent = '';
    public $child = false;
    public $extendAs = '';
    public $children = [];
    public static $instances = [];

    /**
     * gets an instance of the view
     *
     * @param string $viewname
     * 
     * @return object $view
     */

    public static function get($viewname)
    {
        return Factory::make($viewname, self::class, function () use ($viewname) {
            $viewname = "\App\Views\\{$viewname}";
            return new $viewname();
        });
    }

    /**
     * Used to get an extended child view from parent's perspective
     *
     * @param string $childName
     * 
     * @return object $child
     */

    public function child($childName)
    {
        $child = $this->children[$childName];
        $child->child = true;
        return $child;
    }

    /**
     * Will render a view with its parent and its parent's parent's .... parent, if it has a parent.
     * 
     * @method render is defined within child class, it renders html
     */

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
}

