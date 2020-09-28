<?php

namespace App\Service\Validate;

class ValidatorFactory
{
    public static function create()
    {
        return new Validator;
    }
}