<?php

namespace App\Service\Validate;

class FileValidatorDecorator
{
    private $validator;

    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }

    public function size()
    {

    }

    public function type()
    {

    }

    public function required()
    {

    }

    public function optional()
    {

    }
}
