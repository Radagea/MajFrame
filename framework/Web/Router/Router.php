<?php

namespace Majframe\Web\Router;

final class Router
{
    public String $currentPath;
    protected Array $routes;
    private static Router|null $instance = null;
    private Route $currentRoute;
    private String $currentUri;

    private function __construct() {}

    public static function getInstance()
    {
        if (static::$instance == null) {
            static::$instance = new Router();

            static::$instance->routes['index'] = new Route('/', 'indexController', 'index');
            static::$instance->routes['404'] = new Route(Route::NO_ROUTE, 'errorController', '404');
        }

        return static::$instance;
    }

    public static function addRoute(String $path, String $controller, String $name)
    {
        (static::getInstance())->routes[$name] = new Route($path, $controller, $name);
    }

    public static function getRouteByName(String $name) : Route
    {
        return (static::getInstance())->routes[$name];
    }

    public function findRouteByUri(String $uri) : Route
    {
        $this->currentUri = $uri;
        $this->currentRoute = Router::getRouteByName('404');
        /** @var Route $route */
        foreach ($this->routes as $route) {
            if ($route->name == '404') {
                continue;
            }
            if ($route->compareUri($uri)) {
                $this->currentRoute = $route;
                break;
            }
        }

        return $this->currentRoute;
    }

    public static function getCurrentRoute() : Route
    {
        return (self::getInstance())->currentRoute;
    }

    public static function getCurrentUri() : String
    {
        return (self::getInstance())->currentUri;
    }
}