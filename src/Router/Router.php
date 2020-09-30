<?php

namespace App\Router;

use Pimple\Container;
use Symfony\Component\HttpFoundation\Response;
use App\Router\Exception\NotFoundException;
use App\Router\Exception\InsufficientPrivilegeException;
use App\Service\Auth\AuthServiceInterface;

class Router
{
    private $path;
    private $groupPrefix = [];
    private $response = null;
    private $method = '';
    private $container = null;
    private $auth = null;
    private $protectedRoute = false;
    private $allowedRoles = [];

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

    public function setAuth(AuthServiceInterface $auth)
    {
        $this->auth = $auth;
    }

    /**
     * @param array<string> allowed roles
     */

    public function protected(array $roles = []): self
    {
        $this->protectedRoute = true;
        $this->allowedRoles = $roles;

        return $this;
    }

    private function checkAuth()
    {
        if ($this->auth === null) {
            throw new \Exception('Auth service not set!');
        }

        if (!$this->auth->authenticated()) {
            throw new InsufficientPrivilegeException();
        }

        if (!empty($this->allowedRoles)) {
            $authRoles = $this->auth->authParams()['roles'];
            foreach ($this->allowedRoles as $role) {
                if (in_array($role, $authRoles)) {
                    return $this;
                }
            }

            throw new InsufficientPrivilegeException();
        }

        return $this;
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
        $prefix = implode($this->groupPrefix);
        
        if (
            !$this->response && 
            $this->method === $method && 
            $this->urisMatch($this->path, $prefix . $uri)
        ) {
            $this->match($prefix . $uri, $cb);
        }

        $this->protectedRoute = false;
        $this->allowedRoles = [];

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
        $this->groupPrefix[] = $prefix;
        $cb($this);
        array_pop($this->groupPrefix);
    }

    private function match(string $uri, callable $cb)
    {
        if ($this->protectedRoute) {
            $this->checkAuth();
        }

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
            if (!empty($item) && $item[0] === ':' && !empty($params[$key])) {
                array_push($wildcards, $params[$key]);
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
                if ($path[$key] !== $item) {
                    if (!empty($item) && $item[0] === ':' && !empty($path[$key])) {
                        continue;
                    }

                    return false;
                }
            }

            return true;
        }

        return false;
    }
    
}