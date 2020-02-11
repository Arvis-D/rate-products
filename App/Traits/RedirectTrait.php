<?php

namespace App\Traits;

trait RedirectTrait
{
    public function redirect($uri)
    {
        header("Location: {$uri}");
    }
}