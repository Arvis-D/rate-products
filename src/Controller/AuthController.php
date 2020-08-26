<?php

namespace App\Controller;

use App\Service\Auth\JwtAuthService;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class AuthController
{
    private $authService;

    public function __construct(JwtAuthService $auth)
    {
        $this->authService = $auth;
    }

    public function login(Request $request)
    {
        if (!$this->authService->login($request)) {
            return new RedirectResponse('/login');
        } else {
            return new RedirectResponse('/');
        }
    }

    public function signup(Request $request)
    {   
        if (!$this->authService->signup($request)) {
            return new RedirectResponse('/signup');
        } else {
            return new RedirectResponse('/');
        }
    }

    public function logout()
    {
        $this->authService->logout();
        return new RedirectResponse('/');
    }

    public function loginForm(Environment $twig)
    {
        return new Response($twig->render('pages/login.twig', [
            'errors' => $this->authService->getAuthErrors()
        ]));
    }

    public function signupForm(Environment $twig)
    {
        return new Response($twig->render('pages/signup.twig', [
            'errors' => $this->authService->getAuthErrors()
        ]));
    }
}