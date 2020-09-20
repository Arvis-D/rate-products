<?php

namespace App\Service\Auth;

use App\Service\Validate\ValidationResourceInterface;
use App\Service\Validate\ValidationService;
use App\Service\Validate\Validator;
use App\Service\Validate\ValidatorFactory;
use Symfony\Component\HttpFoundation\Session\Session;

class AuthValidationService
{
    public $session;
    public $errors = [];
    private $resource;
    private $translation = [
        'email.email' => 'Email has to be valid',
        'username.unique' => 'Username is already taken',
        'password.length' => 'Password has to be at least 7 characters long',
        'email.unique' => 'Email has to be unique',
        'password.required' => 'Password is required',
        'username.required' => 'Username is required',
        'email.required' => 'Email is required'
    ];

    public function __construct(ValidationResourceInterface $resource, Session $session)
    {
        $this->resource = $resource;
        $this->session = $session;
    }

    public function validateSignup(array $params): bool
    {
        $validator = $this->getValidator()->setParams($params);
        $validator->string(true, 'password')->length(7);
        $validator->string(true, 'username')->unique('user.name');
        $validator->string(true, 'email')->email()->unique('user.email');
        $this->errors = $validator->getErrors();

        return empty($this->errors);
    }

    public function validateLogin(array $params): bool
    {
        $validator = $this->getValidator()->setParams($params);
        $validator->string(true, 'password')->length(7);
        $validator->string(true, 'username');
        $this->errors = $validator->getErrors();

        return empty($this->errors);
    }

    private function getValidator(): Validator
    {
        return ValidatorFactory::create()
            ->setSession($this->session)
            ->setValidationResource($this->resource)
            ->setTranslation($this->translation);
    }
}
