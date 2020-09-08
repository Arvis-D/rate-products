<?php

namespace App;

use App\Mediator\Event\BeforeRouterEvent;
use App\Router\Router;
use Pimple\Container;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
use App\Helper\View;
use App\Router\Exception\RouterException;

class App
{
    private $dispatcher;
    private $request;
    private $container;

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
            return new Response($this->errorPage($this->container['view'], '403', $e->getMessage()));
        } catch (RouterException $e) {
            return new Response($this->errorPage($this->container['view'], $e->getCode(), $e->getMessage()));
        }
    }

    private function resolveRoutes(): Response
    {
        $this->dispatcher->dispatch(new BeforeRouterEvent($this->request), 'beforeRouter');
        $router = $this->container['router'];
        require __DIR__ . '/Router/routes.php';
        return $router->getResponse();
    }

    private function errorPage(View $view, $code, $message = ''): string
    {
        return $view->render('pages/error', [
            'code' => $code,
            'msg' => $message
        ]);
    }
}