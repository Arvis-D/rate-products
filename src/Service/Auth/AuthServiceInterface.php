<?php

namespace App\Service\Auth;

use Symfony\Component\HttpFoundation\Request;

interface AuthServiceInterface
{
    public function login(Request $request): bool;

    public function signup(Request $request): bool;

    public function logout();

    /**
     * if @param $key is null all parameters will be returned as array
     * else only the specified key will be returned
     * 
     * @param $default value that is returned if $key doesnt exist
     * 
     * @return string|array|null
     */

    public function authParams(string $key = null, $default = null);

    public function getAuthErrors(): array;

    public function authenticated(): bool;

    public function roles(): array;
}