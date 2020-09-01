<?php

namespace App\Test;

use App\Repository\UserRepository;
use App\Service\Auth\JwtAuthService;
use App\Service\Validate\AuthValidationService;
use App\Service\Validate\ValidationResourceInterface;
use PHPUnit\Framework\TestCase;

class JwtAuthTest extends TestCase
{
    public function testLogin()
    {
        $userRepo = $this->createMock(UserRepository::class);
        $validationResource = $this->createMock(ValidationResourceInterface::class);
        $validation = new AuthValidationService($validationResource)
        $auth = new JwtAuthService($userRepo, $validationResource);
    }

    public function testSignup()
    {
        
    }

    public function testInvalidToken()
    {
        
    }

    public function testTimeToLive()
    {
        
    }

    public function testAuthenticated()
    {
        
    }
}
