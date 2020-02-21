<?php

namespace App;

use App\Utilities\Csrf;
use App\Utilities\SessionMessage;

class Router
{
    private $found = false;
    private $uri;

    public function __construct($uri)
    {
        $this->uri = $this->removeGetParams($uri);
        SessionMessage::reset();
        Csrf::set();
    }
    
    public function get($uri, $method, $controller = null)
    {
        if (!$this->found) {
            if ($this->urisMatch($this->uri, $uri)) {
                $this->match($uri, $method, $controller);
            }
        }
    }

    /**
     * Unlike get method, post also checks if the csrf token is valid.
     * All post forms must have a csrf token.
     *
     * @param string $uri
     * @param callback $method
     * @param string $controller
     * 
     * @return void
     */

    public function post($uri, $method, $controller = null)
    {
        if (!$this->found) {
            if ($this->urisMatch($this->uri, $uri)) {
                if (Csrf::match()) {
                    $this->match($uri, $method, $controller);
                } else {
                    die('csrf not valid!');
                }
            }
        }
    }

    /**
     * Calls the specified controller method or callback if controller is not provided.
     * Controller has to have a factory.
     * Wildcards ae passed as parameters for controller method
     * 
     * @param string $uri
     * @param string $method
     * @param string $cotroller
     * 
     * @return array $wildcards
     */

    private function match($uri, $method, $controller)
    {
        $this->found = true;
        if ($controller) {
            $controller = "App\Controllers\\{$controller}";
            $controller = $controller::getInst();
            $wildcards = $this->getWildcards($this->uri, $uri);
            if (!empty($wildcards)) {
                call_user_func_array(array($controller, $method), $wildcards);
            } else {
                $controller->$method();
            }
        } else {
            $method();
        }
    }

    /**
     * Although not necessary for this task, the router can take wildcards.
     * Wildcards are identified with ':' before a uri segment.
     * Route with a wildcard will look like this:
     * "/articles/:wildcard" or "/articles/:id/edit".
     * Route may have unlimited number of wildcards.
     * 
     * @param string $uri
     * @param string $wildcardUri
     * 
     * @return array $wildcards
     */

    private function getWildcards($uri, $wildcardUri)
    {
        $params = explode('/', $uri);
        $wildcardUri = explode('/', $wildcardUri);
        $wildcards = [];
        foreach ($wildcardUri as $key => $item) {
            if ($item) {
                if ($item[0] === ':') {
                    array_push($wildcards, $params[$key]);
                }
            }
        }
        return $wildcards;
    }

    /**
     * Checks if the provided route matches with request uri.
     *
     * @param string $uri
     * @param string $routeUri
     * 
     * @return bool
     */

    private function urisMatch($uri, $routeUri)
    {
        $uri = explode('/', $uri);
        $routeUri = explode('/', $routeUri);
        if (count($uri) === count($routeUri)) {
            foreach ($routeUri as $key => $item) {
                if ($item) {
                    if ($item[0] !== ':' && $item !== $uri[$key]) {
                        return false;
                    }
                } else {
                    if ($item !== $uri[$key]) {
                        return false;
                    }
                }
            }
            return true;
        }

        return false;
    }

    /**
     * Removes get paramaters like "?whatever=2142?date=1242"
     * from the request uri string
     *
     * @param string $uri
     * 
     * @return string $uri without get params
     */

    private function removeGetParams($uri)
    {
        $pos = strpos($uri, '?');
        return ($pos ? substr($uri, 0, $pos) : $uri);
    }

    public function notFound($func)
    {
        if (!$this->found) {
            $func();
        }
    }
}