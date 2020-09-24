<?php

namespace App\Service\Auth;

use Firebase\JWT\JWT;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\UserRepositoryInterface;

class JwtAuthService implements AuthServiceInterface
{
    private $userRepository;
    private $validation;
    private $jwtParams;
    private $allowedAlgs = ['HS256'];

    public function __construct(UserRepositoryInterface $userRepository, AuthValidationService $validation)
    {
        $this->userRepository = $userRepository;
        $this->validation = $validation;
    }

    public function login(Request $request): bool
    {
        if (!$this->validation->validateLogin($request->request->all())) {
            return false;
        }

        $results = $this->userRepository->getIdAndPassword($request->get('username'));
        if ($results !== null && password_verify($request->get('password'), $results['password'])) {
            $this->setJwtCookie($request, $results['id']);
            return true;
        }

        $this->validation->session->getFlashBag()->set('errors', ['login' => 'Incorrect username or password!']);

        return false;
    }

    public function signup(Request $request): bool
    {
        if (!$this->validation->validateSignup($request->request->all())) {
            return false;
        }

        $userId = $this->userRepository->addUser(
            $request->get('username'),
            $request->get('email'),
            password_hash($request->get('password'), PASSWORD_DEFAULT)
        );

        $this->setJwtCookie($request, $userId);

        return true;
    }

    private function setJwtCookie(Request $request, $userId)
    {
        $ttl = time() + ($request->get('remember-me') !== null ? (60 * 60 * 24 * 14) : (60 * 60));
        $this->setHttpOnlyCookie(JWT::encode([
            'usr' => $request->get('username'),
            'id' => $userId,
            'exp' => $ttl,
            'roles' => ['user']
        ], $_ENV['SECRET']));
    }

    public function logout()
    {
        setcookie('JWT', " ", 0, "/", "", false, true);
    }

    public function authenticated(): bool
    {
        $params = $this->authParams();
        if (empty($params)) {
            return false;
        }

        if (time() > $params['exp']) {
            $this->logout();
            return false;
        }

        return true;
    }

    public function authParams(): array
    {
        if (isset($this->jwtParams)) {
            return $this->jwtParams;
        } else if (!isset($_COOKIE['JWT'])) {
            return [];
        }

        try {
            $this->jwtParams = (array) JWT::decode($_COOKIE['JWT'], $_ENV['SECRET'], $this->allowedAlgs);
            return $this->jwtParams;
        } catch (\Exception $e) {
            return [];
        }
    }

    public function roles(): array
    {
        if (!empty($roles = $this->authParams()['roles'])) {
            return $roles;
        }

        return [];
    }

    public function getAuthErrors(): array
    {
        return $this->validation->errors;
    }

    private function setHttpOnlyCookie(string $cookie)
    {
        setcookie('JWT', $cookie, 0, "/", "", false, true);
    }
}