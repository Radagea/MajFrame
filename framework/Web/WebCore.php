<?php

namespace Majframe\Web;

use Majframe\Core\Core;
use Majframe\Web\Router\Router;

final class WebCore extends Core
{
    private static WebCore|null $instance = null;
    private Router $router;

    public static function getInstance(): WebCore
    {
        if(self::$instance == null) {
            self::$instance = new WebCore();

            self::$instance->router = Router::getInstance();
            self::$instance->loadRoutes();

        }

        return self::$instance;
    }

    private function loadRoutes()
    {
        $path = __DIR__ . '/../../src/Web/Routes';
        $files = array_diff(scandir($path), ['..', '.']);

        foreach ($files as $file) {
            include_once $path . '/' . $file;
        }
    }

    public function startWeb() : void
    {
        $route = $this->router->findRouteByUri($_SERVER['REQUEST_URI']);
        print_d($route);
    }

}