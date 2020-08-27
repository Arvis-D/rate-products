<?php

namespace App\Mediator\Event;

use App\Helper\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\EventDispatcher\Event;

class BeforeRenderEvent extends Event
{
    private $view;

    public function __construct(View $view)
    {
        $this->view = $view;
    }

    public function getView(): View
    {
        return $this->view;
    }
}
