<?php

namespace App\Service\Validate;

use Symfony\Component\HttpFoundation\Session\Session;

class ValidatorFactory
{   
    private $session;
    private $resource;

    public function __construct(Session $session, ValidationResourceInterface $resource)
    {
        $this->session = $session;
        $this->resource = $resource;
    }


    public function create(array $translation = [])
    {
        return new Validator($this->session, $this->resource, $translation);
    }
}