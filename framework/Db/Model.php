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

    final public function getByKey()
    {

    }

    final public function save() : bool|int
    {
        $dbFields = static::dbFieldAssignment();
        $db_key = '';
        $field_arr = [];

        foreach ($dbFields as $key => $dbField) {
            if (isset($dbField['key']) && $dbField['key'] === true) {
                $db_key = $key;
            } else {
                $model_var = $dbField['model'];
                $field_arr[$key] =  $this->$model_var;
            }
        }

        if (isset($this->$db_key)) {
            return Connector::getConnector()->executeU(static::getTableName(), $field_arr, $wheres = [
                [
                    'field' => $db_key,
                    'value' => $this->$db_key,
                    'operator' => '='
                ]
            ]);
        }

        $return = (Connector::getConnector())->executeI(static::getTableName(), $field_arr);

        if ($return) {
            $this->$db_key = $return;

            return true;
        }


        return false;
    }

    private static function getTableName() : string
    {
        if (!isset(static::$table_name)) {
            $class = explode('\\', get_called_class());
            return end($class);
        }

        return static::$table_name;
    }

    private function getKey() : String|false
    {
        foreach (static::dbFieldAssignment() as $key => $field) {
            if (isset($field['key']) && $field['key'] === true) {
                return $key['model'];
            }
        }

        return false;
    }

    abstract protected static function dbFieldAssignment() : array;
}