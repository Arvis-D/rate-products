<?php

namespace App\Helper;

use App\Mediator\Event\BeforeRenderEvent;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Twig\Environment;

class View
{
    private $defaultParams = [];
    private $defaultExtension = '.twig';
    private $dispatcher;

    public function __construct(Environment $twig, EventDispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
        $this->twig = $twig;       
    }

    public function render(string $path, array $params = []): string
    {
        $this->dispatcher->dispatch(new BeforeRenderEvent($this), 'beforeRender');
        return $this->twig->render($path . $this->defaultExtension, array_merge($params, $this->defaultParams));
    }

    public function addDefaultParams(array $params)
    {
        $this->defaultParams = array_merge($this->defaultParams, $params);
    }
}