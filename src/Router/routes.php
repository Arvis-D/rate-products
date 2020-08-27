<?php

$router->get('/', function($c) {
    return $c['HomeController']->index();
});
$router->get('/login', function($c) {
    return $c['AuthController']->loginForm($c['view']);
});
$router->get('/signup', function($c) {
    return $c['AuthController']->signupForm($c['view']);
});

$router->group('/auth', function($router) {
    $router->post('/login', function($c) {
        return $c['AuthController']->login($c['request']);
    });
    $router->post('/signup', function($c) {
        return $c['AuthController']->signup($c['request']);
    });
    $router->post('/logout', function($c) {
        printf('s');
        return $c['AuthController']->logout();
    });
});