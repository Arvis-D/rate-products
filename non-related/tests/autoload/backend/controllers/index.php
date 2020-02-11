<?php

namespace controllers;
use models\user as UserModel;

class index extends baseController{
    private $model;

    public function __construct(){
        echo get_class($this).  " For real <br>";
        $this->model = new UserModel;
    }
    public function succ(){
        echo $this->base;
    }
}