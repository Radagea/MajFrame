<?php

namespace Test\Web\Controllers;

use Majframe\Web\Controllers\CoreController;
use Majframe\Web\Http\Response;
use Test\Web\Models\User;

class ApiController extends CoreController
{
    public function postsAction() : Response
    {
        $user = new User();
        $user->username = 'Makapaka';
        $user->password = 'Password';
        $user->email = 'test@test.com';
        $user->save();

        print_r($user);

        return new Response(['message' => 'hello world'], null, 201, Response::JSON);
    }
}