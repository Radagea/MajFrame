<?php

namespace Majframe\Core;

use Majframe\Libs\DotEnv\DotEnv;

class Core
{
    public string $app_env;
    private Array $env;
    protected function __construct()
    {
        foreach (DotEnv::getEnv() as $key => $env) {
            $this->env[$key] = trim($env);
        }

        $this->app_env = $this->env['APP_ENV'];
    }

    final public function getEnv() : Array
    {
        return $this->env;
    }
}