<?php

namespace Majframe\Db;

use Majframe\Core\Core;

class Connector
{
    private static Connector|null $instance = null;
    protected string $host;
    protected string $port;
    protected string $user;
    protected string $password;
    protected string $database;

    private function __construct($env)
    {
        $this->host = $env['DB_HOST'];
        $this->port = $env['DB_USER'];
        $this->password = $env['DB_PASSWORD'];
        $this->user = $env['DB_USER'];
        $this->database = $env['DB_PORT'];
    }

    public static function getConnector()
    {
        if(self::$instance == null) {
            self::$instance = new Connector(Core::getInstance()->getEnv());
        }

        return self::$instance;
    }
}