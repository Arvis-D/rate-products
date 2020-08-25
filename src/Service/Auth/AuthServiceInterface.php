<?php

namespace App\Service\Auth;

interface AuthServiceInterface
{
    public function login(string $username, string $password);

    public function signup(string $username, string $password, string $email = null);

    public function logout();

    public function authenticated(): bool;

    public function hasRole(string $role): bool;
}