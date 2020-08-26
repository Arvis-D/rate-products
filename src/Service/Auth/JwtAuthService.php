<?php

namespace App\Service\Auth;

use Firebase\JWT\JWT;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\UserRepository;
use App\Service\Validate\AuthValidationService;
use Symfony\Component\HttpFoundation\Session\Session;

class JwtAuthService implements AuthServiceInterface
{
    private $userRepository;
    private $validation;
    private $session;
    private $jwtParams;

    public function __construct(UserRepository $userRepository, AuthValidationService $validation, Session $session)
    {
        $this->session = $session;
        $this->userRepository = $userRepository;
        $this->validation = $validation;
    }

    public function login(Request $request): bool
    {
        $errors = $this->validation->validateLogin($request->request->all());
        if (!empty($errors)) {
            $this->setSessionErrors($errors);
            return false;
        }

        $password = $this->userRepository->getPasswordByUsername($request->get('username'));
        if (password_verify($request->get('password'), $password)) {
            $this->setJwtCookie($request);
            return true;
        }

        $this->setSessionErrors(['login' => 'Incorrect username or password.']);
        return false;
    }

    public function signup(Request $request): bool
    {
        $errors = $this->validation->validateSignup($request->request->all());
        
        if (!empty($errors)) {
            $this->setSessionErrors($errors);
            return false;
        }

        $this->userRepository->createNewUser(
            $request->get('username'),
            $request->get('email'),
            password_hash($request->get('password'), PASSWORD_DEFAULT)
        );

        $this->setJwtCookie($request);

        return true;
    }

    private function setJwtCookie(Request $request)
    {
        $ttl = ($request->get('remember') ? (60 * 60 * 24 * 14) : (60 * 50));
        $this->setHttpOnlyCookie(JWT::encode([
            'usr' => $request->get('username'),
            'ttl' => $ttl,
            'role' => 'user'
        ], $_ENV['SECRET']));
    }

    public function logout()
    {
        setcookie('JWT', "", 0, "", "", false, true);
    }

    public function authenticated(): bool
    {
        if ($this->getJwtParams() === null) {
            return true;
        }

        return false;
    }

    public function getJwtParams(): ?object
    {
        if (isset($this->jwtParams)) {
            return $this->jwtParams;
        } else if (!isset($_COOKIE['JWT'])) {
            return null;
        }

        try {
            $this->jwtParams = JWT::decode($_COOKIE['JWT'], $_ENV['SECRET']);
            return $this->jwtParams;
        } catch (\Exception $e) {
            return null;
        }
    }

    public function hasRole(string $role): bool
    {
        $decoded = $this->getJwtParams();
        return ($decoded !== null && property_exists($decoded, 'role') && $decoded->role === $role);
    }

    public function getAuthErrors(): array
    {
        return $this->session->getFlashBag()->get('errors');
    }

    private function setSessionErrors(array $errors)
    {
        $this->session->getFlashBag()->set('errors', $errors);
    }

    private function setHttpOnlyCookie(string $cookie)
    {
        setcookie('JWT', $cookie, 0, "", "", false, true);
    }
}