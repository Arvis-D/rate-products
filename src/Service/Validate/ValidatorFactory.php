<?php

namespace App\Service\Validate;

use App\Models\Database;
use App\Service\Validate\ValidationResourceInterface;
use PhpParser\Node\Expr\Instanceof_;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Session\Session;

class ValidatorFactory
{
    public static function create()
    {
        return new Validator;
    }
}