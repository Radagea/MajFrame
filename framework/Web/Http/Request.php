<?php

namespace Majframe\Web\Http;

use Majframe\Web\Router\Router;
use Majframe\Web\Router\Route;

final class Request
{
    private Route $route;
    private String $method;
    private Array|null $headers = null;

    public function __construct()
    {
        $this->route = Router::getCurrentRoute();
        $this->method = $_SERVER['REQUEST_METHOD'];

        $this->headers = getallheaders();
    }

    public function getPost(String $name) : String|int|float|false
    {
        return $_POST[$name] ?? false;
    }

    public function getGet(String $name) : String|int|float|false
    {
        return $_GET[$name] ?? false;
    }

    public function getRoute() : Route
    {
        return $this->route;
    }

    public function getMethod() : String
    {
        return $this->method;
    }

    public function getHeader($name) : String|false
    {
        if (isset($this->headers[$name])) {
            return $this->headers[$name];
        }

        return false;
    }

    public function getHeaders() : Array|false
    {
        if ($this->headers != null) {
            return $this->headers;
        }

        return false;
    }
}
