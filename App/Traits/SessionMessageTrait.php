<?php

namespace App\Traits;

trait SessionMessageTrait
{
    /**
     * Sets session mesages and number of times it will be displayed.
     * 
     * For example, if @var numberOfRequets is set to 4
     * and the same page is reloaded 4 times, then the message wont be shown anymore.
     * Default value is 1.
     */

    public function setMessage($name, $content, $numberOfRequests = 1)
    {
        $_SESSION[$name] = $content;
        $_SESSION["{$name}numberOfRequests"] = $numberOfRequests; 
    }

    public function getMessage($name)
    {
        $_SESSION["{$name}numberOfRequests"]--;
        if($_SESSION["{$name}numberOfRequests"] < 0)
            $_SESSION[$name] = null;
        
        return $_SESSION[$name];
    }
}