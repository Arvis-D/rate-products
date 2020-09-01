<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use App\Helper\View;

class HomeController
{
    private $view;

    public function __construct(View $view)
    {
        $this->view = $view;
    }

    public function index()
    {
        return new Response($this->view->render('pages/products'));
    }

    public function about()
    {
        return new Response($this->view->render('pages/about'));
    }
}