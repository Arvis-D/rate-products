<?php

namespace App\Router;

use App\Utilities\Csrf;
use App\Utilities\SessionMessage;
use App\Factory\Provider;

class Router
{
    private $found = false;
    private $uri;

    public function __construct($uri)
    {
        $this->uri = $this->removeGetParams($uri);
        SessionMessage::reset();
        Csrf::setIfEmpty();
    }
    
    public function get($uri, $method)
    {
        if (!$this->found) {
            if ($this->urisMatch($this->uri, $uri)) {
                $this->match($uri, $method);
            }
        }

        return $this;
    }

    /**
     * Unlike get method, post also checks if the csrf token is valid.
     * All post forms must have a csrf token.
     *
     * @param string $uri
     * @param callback|string $method
     * 
     * @return void
     */

    public function post(string $uri, $method): Router
    {
        if (!$this->found) {
            if ($this->urisMatch($this->uri, $uri)) {
                if (Csrf::match()) {
                    $this->match($uri, $method);
                } else {
                    die('csrf not valid!');
                }
            }
        }

        return $this;
    }

    /**
     * Calls the specified controller method or callback if controller is not provided.
     * Controller has to have a factory.
     * Wildcards ae passed as parameters for controller method
     * 
     * @param string $uri
     * @param string $method
     * 
     * @return array $wildcards
     */

    private function match(string $uri, $method)
    {
        if (strpos($method, '::')) {
            [$controller, $method] = explode('::', $method);
        } else {
            $controller = null;
        }

        $wildcards = $this->getWildcards($this->uri, $uri);
        if ($controller) {
            $controller = Provider::get("App\Controller{$controller}");
            if (!empty($wildcards)) {
                call_user_func_array(array($controller, $method), $wildcards);
            } else {
                $controller->$method();
            }
        } else if(is_callable($method)) {
            call_user_func_array($method, $wildcards);
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
                } else if($item !== $uri[$key]) {
                    return false;
                }
            }
            $this->found = true;

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