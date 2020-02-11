<?php

use App\Router;

$router = new Router($_SERVER['REQUEST_URI']);

$router->get('/', 'index', 'ProductController');
$router->get('/product/add', 'create', 'ProductController');
$router->post('/product/delete', 'delete', 'ProductController');
$router->post('/product/store', 'store', 'ProductController');

$router->notFound(function () {
    include 'App/Views/other/404.html';
});