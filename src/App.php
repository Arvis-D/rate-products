<?php

namespace App;

use App\Factory\Provider;
use App\Mediator\Event\BeforeRouterEvent;
use App\Router\Router;
use Pimple\Container;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use App\Router\Exception\NotFoundException;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;

class App
{
    private $dispatcher;
    private $router = null;
    private $request;

    public function __construct(Request $request, Container $container, EventDispatcher $dispatcher)
    {
        $this->container = $container;
        $this->request = $request;
        $this->dispatcher = $dispatcher;
    }

    public function handle(): Response
    {
        try {
            return $this->resolveRoutes();
        } catch (InvalidCsrfTokenException $e) {
            return new Response('Csrf token invalid', 403);
        } catch (NotFoundException $th) {
            return new Response('Resource not found', 404);
        }
    }

    private function resolveRoutes(): Response
    {
        $this->dispatcher->dispatch(new BeforeRouterEvent($this->request), 'beforeRouter');
        $this->router = new Router($this->request->getPathInfo(), $this->request->getRealMethod(), $this->container);
        $router = $this->router;
        require __DIR__ . '/Router/routes.php';

        return $router->getResponse();
    }
}