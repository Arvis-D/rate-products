<?php

namespace App\Utility;

class Redirect
{
    public static function to($uri)
    {
        header("Location: {$uri}");
    }
}