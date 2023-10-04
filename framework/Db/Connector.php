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

    protected \PDO $conn;

    private function __construct($env)
    {
        $this->host = $env['DB_HOST'];
        $this->port = $env['DB_USER'];
        $this->password = $env['DB_PASSWORD'];
        $this->user = $env['DB_USER'];
        $this->database = $env['DB_NAME'];

        //Make connection
        $this->conn = new \PDO('mysql:host=' . $this->host . ';dbname=' . $this->database, $this->user, $this->password);
    }

    public static function getConnector()
    {
        if(self::$instance == null) {
            self::$instance = new Connector(Core::getExistingInstance()->getEnv());
        }

        return self::$instance;
    }

    public function fetchQuery($query) : Array
    {
        return $this->conn->query($query)->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function buildModelSelect(String $table, Array $wheres = null, Array $orderBy = null, Array|int $limit = null) : String
    {
        $query = 'SELECT * FROM ' . $table;

        if ($wheres != null) {
            foreach ($wheres as $key => $where) {
                if ($key != 0 && !array_key_exists('prev_rel', $where)) {
                    throw new \Exception('The prev_rel (previous relationship) operator missing!');
                }

                if ($key == 0) {
                    $where['prev_rel'] = 'WHERE';
                }

                $query .= ' ' . $where['prev_rel'] . ' ' . $where['field'] . $where['operator'] . $where['value'];
            }
        }

        if ($orderBy != null) {
            if (!array_key_exists('order', $orderBy)) {
                $orderBy['order'] = '';
            }

            $query .= ' ORDER BY ' . $orderBy['field'] . ' ' . $orderBy['order'];
        }

        if ($limit != null) {
            if (is_array($limit)) {
                $query .= ' LIMIT ' . $limit['offset'] . ', ' . $limit['row_num'];
            } else {
                $query .= ' LIMIT ' . $limit;
            }
        }

        return $query;
    }
}