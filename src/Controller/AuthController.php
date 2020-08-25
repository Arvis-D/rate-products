<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class AuthController
{
    public function login(Request $request)
    {

    }

    public function signup(Request $request)
    {   
        $request->getDefaultLocale();
    }

    public function loginForm(Environment $twig)
    {
        return new Response($twig->render('pages/login.twig'));
    }

    public function signupForm(Environment $twig)
    {
        return new Response($twig->render('pages/signup.twig'));
    }
}