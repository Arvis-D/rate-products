<?php

namespace App\Service\Auth;

use Firebase\JWT\JWT;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\UserRepositoryInterface;
use App\Service\ImageService;

class JwtAuthService implements AuthServiceInterface
{
    private $userRepository;
    private $validation;
    private $jwtParams = null;
    private $allowedAlgs = ['HS256'];

    public function authenticate(string $username, int $id, bool $rememberMe = false)
    {
        $ttl = time() + ($rememberMe ? (60 * 60 * 24 * 14) : (60 * 60));
        $this->setHttpOnlyCookie(JWT::encode([
            'usr' => $username,
            'id' => $id,
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
        if (null === $params = $this->authParams()) {
            return false;
        }

        if (time() > $params['exp']) {
            $this->logout();

            return false;
        }

        return true;
    }

    public function authParams(string $key = null, $default = null)
    {
        if (null === $params = $this->jwtParams ?? $this->tryDecode()) {
            return $default;
        }

        if ($key !== null) {
            if (array_key_exists($key, $params)) {
                return $params[$key];
            }

            return $default;
        }

        return $params;
    }

    private function tryDecode(): ?array
    {
        try {
            $this->jwtParams = (array) JWT::decode($_COOKIE['JWT'], $_ENV['SECRET'], $this->allowedAlgs);

            return $this->jwtParams;
        } catch (\Exception $e) {
            return null;
        }
    }

    public function checkPassword(string $password): bool
    {
        if (null === $id = $this->authParams('id')) {
           return false;
        }

        if (!null === $pwd = $this->userRepository->getPassword($id)) {
            return password_verify($password, $pwd);
        }

        return false;
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