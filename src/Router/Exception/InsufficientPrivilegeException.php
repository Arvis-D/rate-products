<?php

namespace App\Router\Exception;

class InsufficientPrivilegeException extends RouterException
{
    public function __construct($msg = 'You are not allowed to access this route', $code = 403)
    {
        $this->message = $msg;
        $this->code = $code;
    }
}
