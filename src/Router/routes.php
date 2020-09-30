<?php

use PHPUnit\TextUI\XmlConfiguration\Group;

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
    $router->protected()->get('/create', function($c) {
        return $c['ProductController']->create($c['view']);
    });

    $router->protected()->post('/store', function($c) {
        return $c['ProductController']->store($c['request']);
    });

    $router->get('/show/:id', function($id, $c) {
        return $c['ProductController']->show($c['view'], $id);
    });
});

$router->group('/api', function($router) {
    $router->group('/product', function($router){
        $router->group('/picture', function($router){
            $router->protected()->post('/store', function($c) {
                return $c['ProductPictureController']->store($c['request'], $c['view']);
            });

            $router->protected()->post('/like', function($c) {
                return $c['ProductPictureController']->like($c['request']);
            });

            $router->protected()->post('/dislike', function($c) {
                return $c['ProductPictureController']->dislike($c['request']);
            });

            $router->protected()->post('/delete', function($c) {
                return $c['ProductPictureController']->delete($c['request'], $c['view']);
            });

            $router->get('/show/:id', function($id, $c) {
                return $c['ProductPictureController']->show($id);
            });
        });
    });
});