<?php

namespace App\Service\Auth;

use App\Repository\UserRepositoryInterface;
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

        return $validator->isValid();
    }

    public function validateLogin(array $params): bool
    {
        $validator = $this->getValidator()->setParams($params);
        $validator->string(true, 'password')->length(6);
        $validator->string(true, 'username');

        return $validator->isValid();
    }

    public function validateUpdate(array $params, string $currentUsername, string $currentEmail): bool
    {
        $this->translation['new-password.required'] = $this->translation['password.required'];
        $this->translation['new-password.length'] = $this->translation['password.length'];

        $validator = $this->getValidator()->setParams($params);
        $validator->file(false, 'image')->maxSize(2048)->type(['jpg', 'jpeg', 'png']);
        $validator->string(false, 'new-password')->length(7);

        if ($params['username'] !== $currentUsername) {
            $validator->string(true, 'username')->unique('user.name');
        }

        if ($params['email'] !== $currentEmail) {
            $validator->string(true, 'email')->email()->unique('user.email');
        }

        return $validator->isValid();
    }

    private function getValidator(): Validator
    {
        return ValidatorFactory::create()
            ->setSession($this->session)
            ->setValidationResource($this->resource)
            ->setTranslation($this->translation);
    }
}
