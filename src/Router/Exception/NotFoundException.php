<?php

namespace App\Router\Exception;

class NotFoundException extends RouterException 
{
    public function __construct($message = 'Resource not found!', $code = 404)
    {
        $this->message = $message;
        $this->code = $code;
    }
}
