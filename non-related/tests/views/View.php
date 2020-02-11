<?php

class View
{
    public static function show($viewname)
    {
        $view = $viewname.'View';
        $view = new $view;
        $view->render();
    }

    public function child($childName)
    {
        foreach($this->children as $child){
            if($child->extendAs === $childName){
                return $child;
            }
        }
    }

    public function data($data)
    {
        $this->data = $data;
        return $this;
    }
}