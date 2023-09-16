<?php

namespace Majframe\Web\Router;

class Router
{
    public String $currentPath;
    protected Array $routes;
    private static Router|null $instance = null;
    private Route $currentRoute;
    private String $currentUri;

    private function __construct()
    {

    }

    public static function getInstance()
    {
        if (static::$instance == null) {
            static::$instance = new Router();
        }

        return static::$instance;
    }

    public static function addRoute(String $path, String $controller, String $name)
    {
        (static::getInstance())->routes[] = new Route($path, $controller, $name);
    }

    public function findRouteByUri(String $uri) : Route|false
    {
        /** @var Route $route */
        foreach ($this->routes as $route) {
            if ($route->compareUri($uri)) {
                return $route;
            }
        }
        echo 'false';
        return false;
    }

}