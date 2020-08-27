<?php

namespace App\Router;

use Pimple\Container;
use Symfony\Component\HttpFoundation\Response;
use App\Router\Exception\NotFoundException;

class Router
{
    private $path;
    private $groupPrefix = '';
    private $response = null;
    private $method = '';
    private $container = null;

    public function __construct(string $path, string $method, Container $container = null)
    {
        $this->path = $path;
        $this->method = $method;
        $this->container = $container;
    }

    public function setContainer(Container $container): void
    {
        $this->container = $container;
    }

    public function get(string $uri, callable $cb): Router
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

    public function getResponse(): Response
    {
        if ($this->response === null) {
            throw new NotFoundException;
        }

        return $this->response;
    }

    public function group(string $prefix, callable $cb)
    {
        $this->groupPrefix = $prefix;
        $cb($this);
        $this->groupPrefix = '';
    }

    private function match(string $uri, callable $cb)
    {
        $params = $this->getWildcards($this->path, $uri);
        if ($this->container !== null) {
            $params[] = $this->container;
        }

        $this->response = call_user_func_array($cb, $params);
    }

    /**
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

    private function getWildcards(string $uri, string $wildcardUri)
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
     * Checks if the provided route matches with request path.
     *
     * @param string $path
     * @param string $routeUri
     * 
     * @return bool
     */

    private function urisMatch(string $path, string $routeUri)
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