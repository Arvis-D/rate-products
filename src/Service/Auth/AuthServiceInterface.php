<?php

namespace App\Service\Auth;

use Symfony\Component\HttpFoundation\Request;

interface AuthServiceInterface
{
    public function authenticate(string $username, int $id, bool $rememberMe = false);

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

    public function authenticated(): bool;

    public function roles(): array;
}