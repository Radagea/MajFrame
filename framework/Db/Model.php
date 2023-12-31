<?php

namespace Majframe\Db;

use Majframe\Libs\Exception\MajException;

abstract class Model
{
    /**
     * Notice: This will load the FIRST occurrence
     *
     * @param String $field give the field name you need to assign value for the instance where you want to call it
     * @return bool
     * @throws MajException
     */
    final public function getByField(String $field) : bool
    {
        if (!isset($this->$field)) {
            throw new MajException('Field: ' . $field . ' does not exist in the model or doesn\'t have value.');
        }

        $row = Connector::getConnector()->executeS(static::getTableName(), [
                [
                    'field' => $field,
                    'value' => $this->$field,
                    'operator' => '='
                ]
            ],
            null,
            1
        );

        if (count($row) < 1) {
            return false;
        }

        $model_fields = static::dbFieldAssignment();

        foreach ($model_fields as $key => $mfield) {
            $var = $mfield['model'];
            $this->$var = $row[0][$key];
        }

        return true;
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
                if ((isset($dbField['required']) && $dbField['required'] === true) || isset($this->$model_var)) {
                    $field_arr[$key] =  $this->$model_var;
                }
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

    /**
     * @param array|null $wheres
     * @param array|null $order_by
     * @param array|null $limit
     * @return Array|false return array if there is result for the search, and return false if there is no result for the search
     * The array contains elements which ones object of the called Model class.
     * @throws \Exception
     */
    final public static function get(Array $wheres = null, Array $order_by = null, Array $limit = null) : Array|Model|false
    {
        $connector = Connector::getConnector();
        $rows = $connector->executeS(static::getTableName(), $wheres, $order_by, $limit);

        $results = [];

        if (count($rows) < 1) {
            return false;
        }

        $fields = static::dbFieldAssignment();
        $model = static::class;

        foreach ($rows as $row) {
            $model = new $model();


            foreach ($fields as $key => $field) {
                $var = $field['model'];
                $model->$var = $row[$key];
            }

            $results[] = $model;
        }

        if (count($results) < 2) {
            $results = $results[0];
        }

        return $results;
    }

    final public static function count(Array $wheres = null) : int|false
    {
        return Connector::getConnector()->executeCount(static::getTableName(), $wheres);
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