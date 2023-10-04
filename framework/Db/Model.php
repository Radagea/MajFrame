<?php

namespace Majframe\Db;

abstract class Model
{

    /**
     * @param array|null $wheres
     * @param array|null $order_by
     * @param array|null $limit
     * @return Array|false return array if there is result for the search, and return false if there is no result for the search
     * The array contains elements which ones object of the called Model class.
     * @throws \Exception
     */
    final public static function get(Array $wheres = null, Array $order_by = null, Array $limit = null) : Array|false
    {
        $connector = Connector::getConnector();
        $rows = $connector->fetchQuery($connector->buildModelSelect(static::getTableName(), $wheres, $order_by, $limit));

        $results = [];

        foreach ($rows as $row) {
            $fields = static::dbFieldAssignment();
            $model = static::class;
            $model = new $model();


            foreach ($fields as $key => $field) {
                $var = $field['model'];
                $model->$var = $row[$key];
            }

            $results[] = $model;
        }

        return $results;
    }

    private static function getTableName() : string
    {
        if (!isset(static::$table_name)) {
            $class = explode('\\',get_called_class());
            return end($class);
        }

        return static::$table_name;
    }

    abstract protected static function dbFieldAssignment() : array;
}