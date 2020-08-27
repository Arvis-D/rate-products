<?php

namespace App\Service\Auth;

use Symfony\Component\HttpFoundation\Request;

interface AuthServiceInterface
{
    /**
     * @return array errors
     */

    public function login(Request $request): bool;

    public function signup(Request $request): bool;

    public function logout();

    public function getAuthErrors(): array;

    public function authenticated(): bool;

    public function roles(): array;
}