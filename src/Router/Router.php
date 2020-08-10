<?php

namespace App\Router;

use App\Utilities\SessionMessage;
use Pimple\Container;
use Symfony\Component\HttpFoundation\Response;

class Router
{
    private $path;
    private $groupPrefix = '';
    private $response = null;
    private $method = '';
    private $container = null;

    public function __construct($path, $method)
    {
        $this->path = $path;
        $this->method = $method;
    }

    public function setContainer($container)
    {
        $this->container = $container;
    }

    public function get(string $uri, callable $cb)
    {
        return $this->route('GET', $uri, $cb);
    }

    public function post(string $uri, callable $cb): Router
    {
        return $this->route('POST', $uri, $cb);
    }

    private function route(string $method, string $uri, callable $cb)
    {
        if (
            !$this->response && 
            $this->method === $method && 
            $this->urisMatch($this->path, $this->groupPrefix . $uri)
        ) {
            $this->match($this->groupPrefix . $uri, $cb);
        }

        return $this;
    }

    public function getResponse(): ?Response
    {
        return $this->response;
    }

    public function group($prefix, $cb)
    {
        $this->groupPrefix = $prefix;
        $cb($this);
        $this->groupPrefix = '';
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

    private function match(string $uri, $cb)
    {
        $params = $this->getWildcards($this->path, $uri);
        if ($this->container !== null) {
            $params[] = $this->container;
        }

        $this->response = call_user_func_array($cb, $params);
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

    private function urisMatch($path, $routeUri)
    {
        $path = explode('/', $path);
        $routeUri = explode('/', $routeUri);
        if (count($path) === count($routeUri)) {
            foreach ($routeUri as $key => $item) {
                if ($item) {
                    if ($item[0] !== ':' && $item !== $path[$key]) {
                        return false;
                    }
                } else if($item !== $path[$key]) {
                    return false;
                }
            }
            return true;
        }

        return false;
    }
}