<?php

$router = new \App\Router\Router($_SERVER['REQUEST_URI']);

$router
->get('/asd', function($id) {
    echo $id;
})
->get('/', '\TestController::test');