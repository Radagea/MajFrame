<?php

namespace Majframe\Web\Http;

use Majframe\Web\Router\Router;

final class Request
{
    private Route $route;

    public function __construct()
    {
        $this->route = Router::getCurrentRoute();
    }

    public function getPost(String $name) : String|int|double|false
    {
        return $_POST[$name] ?? false;
    }

    public function getGet(String $name) : String|int|double|false
    {
        return $_GET[$name] ?? false;
    }
}