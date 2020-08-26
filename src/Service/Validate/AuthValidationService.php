<?php

namespace App\Service\Validate;

class AuthValidationService extends ValidationService
{
    public function __construct(ValidationResourceInterface $resource)
    {
        $this->setResource($resource);
    }

    private function getTranslations()
    {
        return [
            'email.email' => 'Email has to be valid',
            'username.unique' => 'Username is already taken',
            'password.length' => 'Password has to be at least 7 characters long',
            'email.unique' => 'Email has to be unique',
            'password.required' => 'Password is required',
            'username.required' => 'Username is required',
            'email.required' => 'Email is required'
        ];
    }

    public function validateSignup(array $params): array
    {
        return $this->setValues($params)
            ->key('password')->required()->len(7)
            ->key('username')->required()->unique('user.name')
            ->key('email')->required()->unique('user.email')->email()
            ->translateErrors($this->getTranslations())->getErrors();
    }

    public function validateLogin(array $params): array
    {
        return $this->setValues($params)
            ->key('password')->required()->len(7)
            ->key('username')->required()
            ->translateErrors($this->getTranslations())->getErrors();
    }
}
