<?php

namespace Majframe\Web\Router;

use Majframe\Web\WebCore;

class Route
{
    private String $name;
    private String $path;
    private Array $explodedPath;
    private Array $availableParams;
    private String $controllerNamespace;
    private String $controllerAction = 'indexAction';

    public function __construct(String $path, String $controller, String $name)
    {
        $this->name = $name;

        $nameSpace = (WebCore::getInstance())->getEnv()['DEFAULT_WEB_SRC_NAMESPACE'];

        if ($nameSpace[strlen($nameSpace)-1] != '\\') {
            $nameSpace[strlen($nameSpace)] = '\\';
        }

        $controller = explode('@', $controller);

        if (isset($controller[1])) {
            $this->controllerAction = $controller[1];
        }

        $this->controllerNamespace = $nameSpace . 'Web\\Controllers\\' . $controller[0];

        //WIP: work in progress path save
        $this->path = $path;
        $exploded_paths = explode('/', ltrim($path, $path[0]));
        foreach ($exploded_paths as $key => $pathElement) {
            if (str_contains($pathElement, '{') && str_contains($pathElement, '}')) {
                $paramName = str_replace(['{', '}'], '', $pathElement);
                $this->availableParams[] = [
                    'key' => $paramName,
                    'pos' => $key
                ];

                $pathElement = '{*!PARAM!*}';
            }

            $this->explodedPath[] = $pathElement;
        }

        echo $this->name;
        print_d($this->explodedPath);
    }

    public function getPath() : String
    {
        return $this->path;
    }

    public function getControllerNamespace() : String
    {
        return $this->controllerNamespace;
    }

    public function getControllerAction(): String
    {
        return $this->controllerAction;
    }
}