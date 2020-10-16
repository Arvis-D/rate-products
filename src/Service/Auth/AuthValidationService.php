<?php

namespace App\Service\Auth;

use App\Service\Picture\PictureValidationService;
use App\Service\Validate\ValidatorFactory;

class AuthValidationService
{
    public $validator;
    private $avatarValidator;
    public $errors = [];
    private $translation = [
        'email.email' => 'Email has to be valid',
        'username.unique' => 'Username is already taken',
        'password.length' => 'Password has to be at least 7 characters long',
        'email.unique' => 'Email has to be unique',
        'password.required' => 'Password is required',
        'username.required' => 'Username is required',
        'email.required' => 'Email is required'
    ];

    public function __construct(ValidatorFactory $validatorFactory, PictureValidationService $avatarValidator)
    {
        $this->avatarValidator = $avatarValidator;
        $this->validator = $validatorFactory->create($this->translation);
    }

    public function validateSignup(array $params): bool
    {
        $validator = $this->validator->setParams($params);
        $this->validatePassword();
        $this->validateUsername();
        $this->validateEmail();

        return ($validator->isValid() && $this->avatarValidator->validateImage(false));
    }

    public function validateUpdate(array $params, string $currentUsername, string $currentEmail): bool
    {
        $validator = $this->validator->setParams(array_merge(['password' => $params['new-password']], $params));
        $this->validatePassword();

        if ($params['username'] !== $currentUsername) {
            $this->validateUsername();
        }

        if ($params['email'] !== $currentEmail) {
            $this->validateEmail();
        }

        return ($validator->isValid() && $this->avatarValidator->validateImage(false));
    }

    private function validateEmail()
    {
        $this->validator->string(true, 'email')->email()->unique('user.email');
    }

    private function validateUsername()
    {   
        $this->validator->string(true, 'username')->unique('user.name');
    }

    private function validatePassword()
    {
        $this->validator->string(true, 'password')->length(7);
    }
}
