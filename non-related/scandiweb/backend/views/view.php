<?php


class View{
    private $viewName;
    public $data = "";

    public function __construct($viewName){
        $this->viewName = $viewName .".phtml";
    }
    public function render($data = "", $subviews = []){
        include $this->viewName;
    }
    public function set($data){
        $this->data = $data;
    }
}