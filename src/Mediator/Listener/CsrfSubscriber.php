<?php

namespace App\Mediator\Listener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use App\Mediator\Event\BeforeRenderEvent;
use App\Mediator\Event\BeforeRouterEvent;
use App\Helper\Csrf;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;

class CsrfSubscriber implements EventSubscriberInterface
{
    private $csrf;

    public function __construct(Csrf $csrf)
    {
        $this->csrf = $csrf;
    }

    public function onBeforeRender(BeforeRenderEvent $event)
    {
        $event->getView()->addDefaultParams(['csrf' => $this->csrf->getTokenStr()]);
    }

    public function onBeforeRouter(BeforeRouterEvent $event)
    {
        $request = $event->getRequest();
        if ($request->getRealMethod() === 'POST') {
            if (!$this->csrf->check($request->get('csrf'))) {
                throw new InvalidCsrfTokenException();
            }
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            'beforeRender' => ['onBeforeRender'],
            'beforeRouter' => ['onBeforeRouter']
        ];
    }
}
