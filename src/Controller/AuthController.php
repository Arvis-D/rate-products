<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Helper\View;
use App\Repository\UserRepositoryInterface;
use App\Service\Auth\AuthServiceInterface;
use App\Service\UserService;

class AuthController
{
    public function login(Request $request, UserService $user)
    {
        if (!$user->login(
            $request->get('username'), 
            $request->get('password'), 
            (null !== $request->get('remember'))
        )) {
            return new RedirectResponse('/auth/login');
        } else {
            return new RedirectResponse('/');
        }
    }

    public function signup(Request $request, UserService $user)
    {
        if ($user->signup($request)) {
            return new RedirectResponse('/');
        }

        return new RedirectResponse('/auth/signup');
    }

    public function logout(AuthServiceInterface $auth)
    {
        $auth->logout();

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
        return new Response($view->render('pages/profile', [
            'user' => $user->getData($id)
        ]));
    }

    public function update(View $view, UserRepositoryInterface $user)
    {
        return new Response($view->render('pages/profile'));
    }
}