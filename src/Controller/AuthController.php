<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Helper\View;
use App\Repository\UserRepositoryInterface;
use App\Service\Auth\AuthServiceInterface;
use App\Service\UserService;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;
use Symfony\Component\HttpFoundation\Session\Session;

class AuthController
{
    public function login(Request $request, UserService $user)
    {
        if (!$user->login(
            $request->get('username'), 
            $request->get('password'),
            (null !== $request->get('remember-me'))
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

    public function profile(int $id, View $view, UserRepositoryInterface $userRepo)
    {
        if (null !== $user = $userRepo->getData($id)) {
            return new Response($view->render('pages/profile', [
                'user' => $user
            ]));
        }

        return null;
    }

    public function update(Request $request, UserService $user)
    {
        $user->update($request);

        return new RedirectResponse("/auth/profile/show/{$user->auth->authParams('id')}");
    }
}