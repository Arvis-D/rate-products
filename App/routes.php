<?php

use App\Router;

$router = new Router($_SERVER['REQUEST_URI']);

$router->get('/', 'index', 'ProductController');
$router->get('/product/add', 'create', 'ProductController');
$router->post('/product/delete', 'delete', 'ProductController');
$router->post('/product/store', 'store', 'ProductController');
$router->get('/add/shekel', function () {
    die('šhekel/added');
});

$router->notFound(function () {
    //die('šadasd');
    require __DIR__ . '/Views/Other/404.html';
});