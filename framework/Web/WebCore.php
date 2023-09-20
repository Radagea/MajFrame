<?php

namespace Majframe\Web;

use Majframe\Core\Core;
use Majframe\Libs\Exception\MajException;
use Majframe\Web\Controllers\Controller;
use Majframe\Web\Router\Route;
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

    public static function startWeb() : void
    {
        include_once __DIR__ . '/../Libs/Functions/Function.php';

        try {
            self::getInstance();
            self::$instance->controllerInjector(self::$instance->router->findRouteByUri($_SERVER['REQUEST_URI']));
        } catch (MajException $e) {
            echo $e->getMessage();
            echo $e->getCode();
        }
    }

    private function loadRoutes()
    {
        $path = __DIR__ . '/../../src/Web/Routes';
        $files = array_diff(scandir($path), ['..', '.']);

        foreach ($files as $file) {
            include_once $path . '/' . $file;
        }
    }

    private function controllerInjector(Route $route) : void
    {
        $controller = $route->getControllerNamespace();
        $action = $route->getControllerAction();
        $controller = new $controller();
        if (!($controller instanceof Controller)) {
            throw new MajException('The controller named: ' . $controller::class . ' not instance of the Controller class');
        }
        $controller->$action();
    }

}