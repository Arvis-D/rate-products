<?php

namespace App\Utilities;

class Redirect
{
    public static function to($uri)
    {
        header("Location: {$uri}");
    }
}