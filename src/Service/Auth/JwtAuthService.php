<?php

namespace App\Service\Auth;

use App\Models\Database;
use Firebase\JWT\JWT;
use Symfony\Component\HttpFoundation\Request;

class JwtAuthService implements AuthServiceInterface
{

    public function __construct()
    {
        
    }

    public function login(string $username, string $password)
    {
        
    }

    public function signup(string $username, string $password, string $email = null)
    {

    }

    public function logout()
    {
        setcookie('JWT', "", 0, "", "", false, true);
    }

    public function authenticated(): bool
    {

    }

    public function hasRole(string $role): bool
    {

    }

    private function setJwtCookie(string $cookie)
    {
        setcookie('JWT', $cookie, 0, "", "", false, true);
    }
}