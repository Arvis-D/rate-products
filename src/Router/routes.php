<?php

$router = new \App\Router\Router($_SERVER['REQUEST_URI']);

$router
->get('/', function($id) {
    echo $id;
})
->get('/:asd', '\TestController::test');