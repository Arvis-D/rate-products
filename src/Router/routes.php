<?php

$router->get('/about', function($c) {
    return $c['HomeController']->about();
});

/**
 * Auth routes
 */

$router->group('/auth', function($router) {
    $router->get('/login', function($c) {
        return $c['AuthController']->loginForm($c['view']);
    });

    $router->get('/signup', function($c) {
        return $c['AuthController']->signupForm($c['view']);
    });

    $router->post('/login', function($c) {
        return $c['AuthController']->login($c['request']);
    });

    $router->post('/signup', function($c) {
        return $c['AuthController']->signup($c['request']);
    });
    
    $router->post('/logout', function($c) {
        return $c['AuthController']->logout();
    });
});


$router->get('/', function($c) {
    return $c['ProductController']->index($c['view']);
});
$router->group('/product', function($router) {
    $router->get('/create', function($c) {
        return $c['ProductController']->create($c['view']);
    })->protected();

    $router->post('/store', function($c) {
        return $c['ProductController']->store($c['request']);
    })->protected();

    $router->get('/show/:id', function($id, $c) {
        return $c['ProductController']->show($c['view'], $id);
    });
});