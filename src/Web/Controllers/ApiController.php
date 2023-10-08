<?php

namespace Test\Web\Controllers;

use Majframe\Web\Controllers\CoreController;
use Majframe\Web\Http\Response;
use Test\Web\Models\User;

class ApiController extends CoreController
{
    public function postsAction() : Response
    {

        return new Response(['user' => User::get([['field' => 'id', 'value' => 1]])], null, 201, Response::JSON);
    }
}