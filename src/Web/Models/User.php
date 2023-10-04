<?php

namespace Test\Web\Models;

use Majframe\Db\Model;

class User extends Model
{
    protected static String $table_name = 'Users';

    public int $id;
    public String $username;
    public String $email;
    public String $password;
    protected static function dbFieldAssignment(): array
    {
        return [
            'id' => [
                'model' => 'id',
                'type' => 'int',
                'key' => true,
            ],
            'username' => [
                'model' => 'username',
                'type' => 'varchar',
                'required' => true,
            ],
            'email' => [
                'model' => 'email',
                'type' => 'varchar',
                'required' => true,
            ],
            'password' => [
                'model' => 'password',
                'type' => 'varchar',
                'required' => true
            ]
        ];
    }
}