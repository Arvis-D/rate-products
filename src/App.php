<?php

namespace App;

use App\Factory\Provider;
use App\Router\Router;
use Pimple\Container;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class App
{
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function handle(): Response
    {
        $request = $this->container['request'];
        $router = new Router($request->getPathInfo(), $request->getRealMethod());
        $router->setContainer($this->container);
        require __DIR__ . '/Router/routes.php';
        
        $response = $router->getResponse();
        if ($response === null) {
            $response = new Response('Resource not found', 404);
        };

        return $response;
    }
}