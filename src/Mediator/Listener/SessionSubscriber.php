<?php

namespace App\Mediator\Listener;

use App\Mediator\Event\BeforeRenderEvent;
use App\Mediator\Event\BeforeRouterEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\Session;

class SessionSubscriber implements EventSubscriberInterface
{
    private $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function onBeforeRender(BeforeRenderEvent $event)
    {
        $event->getView()->addDefaultParams([
            'old' => $this->session->getFlashBag()->get('old'),
            'errors' => $this->session->getFlashBag()->get('errors')
        ]);

        $asd  = 2+2;
    }

    public function onBeforeRouter(BeforeRouterEvent $event)
    {
        if ($event->getRequest()->getRealMethod() === 'POST') {
            $this->session->getFlashBag()->set('old', $event->getRequest()->request->all());
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
