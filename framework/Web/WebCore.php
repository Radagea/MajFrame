<?php

namespace Majframe\Web;

use Majframe\Core\Core;
use Majframe\Web\Router\Router;

class WebCore extends Core
{
    private Router $router;
    protected function __construct()
    {
        $this->router = Router::getInstance();
        $this->loadRoutes();
        parent::__construct();
    }

    public static function getInstance(): WebCore
    {
        if(self::$instance == null) {
            self::$instance = new WebCore();
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
        /** @var Bool $route */
        $route = $this->router->findRouteByUri($_SERVER['REQUEST_URI']);
        print_d($route);
    }

}