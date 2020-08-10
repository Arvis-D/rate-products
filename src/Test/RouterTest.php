<?php

namespace App\Test;

use App\Router\Router;
use PHPUnit\Framework\TestCase;
use Pimple\Container;
use Symfony\Component\HttpFoundation\Response;

class RouterTest extends TestCase
{
    public function testResolvesOneCorrectRouteOutOfMany()
    {
        $path = '/about';
        $router = new Router($path, 'GET');
        $router->get('/asd', function() {return new Response('no');});
        $router->get('/', function() {return new Response('no');});
        $router->get('/about', function() {return new Response('yes');});
        $router->get('/very/long/path', function() {return new Response('no');});
        $this->assertInstanceOf(Response::class, $router->getResponse());
        $this->assertSame('yes', $router->getResponse()->getContent());


        $path = '/very/long/path';
        $router = new Router($path, 'GET');
        $router->get('/asd', function() {return new Response('no');});
        $router->get('/very/long/path', function() {return new Response('yes');});
        $router->get('/', function() {return new Response('no');});
        $router->get('/about', function() {return new Response('no');});
        $this->assertInstanceOf(Response::class, $router->getResponse());
        $this->assertSame('yes', $router->getResponse()->getContent());

        $path = '/';
        $router = new Router($path, 'GET');
        $router->get('/asd', function() {return new Response('no');});
        $router->get('/very/long/path', function() {return new Response('no');});
        $router->get('/', function() {return new Response('yes');});
        $router->get('/about', function() {return new Response('no');});
        $this->assertInstanceOf(Response::class, $router->getResponse());
        $this->assertSame('yes', $router->getResponse()->getContent());


        $path = '/very/path';
        $router = new Router($path, 'GET');
        $router->get('/asd', function() {return new Response('no');});
        $router->get('/very/long/path', function() {return new Response('no');});
        $router->get('/', function() {return new Response('no');});
        $router->get('/about', function() {return new Response('no');});
        $this->assertSame(null, $router->getResponse());
    }

    public function testResolvesWildcards()
    {
        $path = '/user/12';
        $router = new Router($path, 'GET');
        $router->get('/user', function($id) {return new Response($id);});
        $router->get('/:id', function($id) {return new Response($id);});
        $router->get('/user/:id', function($id) {return new Response($id . '+');});
        $router->get('/', function($id) {return new Response($id);});
        $this->assertSame('12+', $router->getResponse()->getContent());


        $path = '/very/12/long/13';
        $router = new Router($path, 'GET');
        $router->get('/asd', function() {return new Response('no');});
        $router->get('/:id/long/:id2', function($id, $id2) {return new Response($id . $id2);});
        $router->get('/very/:id/long/:id2', function($id, $id2) {return new Response($id . $id2 . '+');});
        $router->get('/', function() {return new Response('no');});
        $router->get('/about', function() {return new Response('no');});
        $this->assertSame('1213+', $router->getResponse()->getContent());
    }

    public function testContainerAccessible()
    {
        $path = '/very/12/long/13';
        $router = new Router($path, 'GET');
        $container = new Container();
        $container['value'] = 'test';
        $router->setContainer($container);


        $router->get('/asd', function() {return new Response('no');});
        $router->get('/:id/long/:id2', function($id, $id2, $c) {return new Response($id . $id2);});
        $router->get('/very/:id/long/:id2', function($id, $id2, $c) {return new Response($c['value']);});
        $router->get('/', function() {return new Response('no');});
        $router->get('/about', function() {return new Response('no');});

        $this->assertSame('test', $router->getResponse()->getContent());
    }

    public function testRouteGroup()
    {
        $path = '/admin/setting/12';
        $router = new Router($path, 'GET');
        $router->group('/admin', function($router) {
            $router->get('/setting/:id', function($id) {
                return new Response($id);
            });
        });


        $this->assertSame('12', $router->getResponse()->getContent());
    }
}