<?php

namespace App\Controller;

use App\Service\Auth\JwtAuthService;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Helper\View;
use App\Repository\UserRepositoryInterface;

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
            return new RedirectResponse('/auth/login');
        } else {
            return new RedirectResponse('/');
        }
    }

    public function signup(Request $request)
    {   
        if (!$this->authService->signup($request)) {
            return new RedirectResponse('/auth/signup');
        } else {
            return new RedirectResponse('/');
        }
    }

    public function logout()
    {
        $this->authService->logout();
        return new RedirectResponse('/');
    }

    public function loginForm(View $view)
    {
        return new Response($view->render('pages/login'));
    }

    public function signupForm(View $view)
    {
        return new Response($view->render('pages/signup'));
    }

    public function profile(int $id, View $view, UserRepositoryInterface $user)
    {


        return new Response($view->render('pages/profile'));
    }

    public function update(Request $request, View $view, UserRepositoryInterface $user)
    {
        
    }
}