<?php

namespace Test\Web\Controllers;

use Majframe\Web\Controllers\CoreController;
use Majframe\Web\Http\Response;
use Test\Web\Models\User;

class ApiController extends CoreController
{
    public function postsAction() : Response
    {
        User::count([
            [
                'field' => 'id',
                'value' => 0
            ]
        ]);

        return new Response(['message' => 'hello world', 'user' => $user], null, 201, Response::JSON);
    }
}