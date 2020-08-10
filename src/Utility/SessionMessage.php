<?php

namespace App\Utility;

/**
 * Sets and gets messages and makes sure that they are deleted after being shown
 */

class SessionMessage
{
    public static function set($name, $content)
    {
        $_SESSION['deleteMessages'] = false;
        $_SESSION['messages'][$name] = $content;
    }

    public static function get($name)
    {
        $_SESSION['deleteMessages'] = true;
        return $_SESSION['messages'][$name];
    }

    public static function reset()
    {
        if (array_key_exists('deleteMessages', $_SESSION)) {
            $_SESSION['messages'] = null;
        }
    }
}