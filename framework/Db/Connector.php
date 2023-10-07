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

    public function fetchQuery(String $query) : Array
    {
        return $this->conn->query($query)->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function executeI(String $table, Array $fields) : bool|int
    {
        $sql = 'INSERT INTO ' . $table . ' ';
        $field_names = '(';
        $fields_value = '(';

        foreach ($fields as $key => $field) {
            if ($key != array_key_last($fields)) {
                $field_names .= $key . ', ';
                $fields_value .= ':' . $key . ', ';
            } else {
                $field_names .= $key . ')';
                $fields_value .= ':' . $key . ')';
            }
        }

        $sql .= $field_names . ' VALUES ' . $fields_value;

        $return = $this->conn->prepare($sql)->execute($fields);

        if ($return) {
            return $this->conn->lastInsertId();
        }

        return false;
    }
    public function executeU(String $table, Array $fields, Array $wheres = null) : bool
    {
        $sql = 'UPDATE ' . $table. ' SET';

        foreach ($fields as $key => $field) {
            $sql .= ' ' . $key . '=:' . $key;

            if ($key != array_key_last($fields)) {
                $sql .= ', ';
            } else {
                $sql .= ' ';
            }
        }

        if ($wheres != null) {
            $sql .= $this->buildWhere($wheres);
        }

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute($fields);
    }

    public function buildModelSelect(String $table, Array $wheres = null, Array $orderBy = null, Array|int $limit = null) : String
    {
        $query = 'SELECT * FROM ' . $table;

        if ($wheres != null) {
            $query .= $this->buildWhere($wheres);
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

    /**
     * Dev comment:
     * $wheres = [
     *      [
     *          'field'    => 'username',
     *          'operator' => '=',
     *          'value'    => 'MajFrame'
     *      ],
     *      [
     *          'field'    => 'email'
     *          'operator' => '='
     *          'value'    => 'majframe@majframe.com'
     *          'prev_rel' => 'AND'
     *      ]
     * ]
     */
    private function buildWhere(Array $wheres) : String
    {
        $query = '';
        foreach ($wheres as $key => $where) {
            if ($key != 0 && !array_key_exists('prev_rel', $where)) {
                throw new \Exception('The prev_rel (previous relationship) operator missing!');
            }

            if (!array_key_exists('operator', $where)) {
                $where['operator'] = '=';
            }

            if ($key == 0) {
                $where['prev_rel'] = 'WHERE';
            }

            $query .= ' ' . $where['prev_rel'] . ' ' . $where['field'] . $where['operator'] . $where['value'];
        }

        return $query;
    }
}