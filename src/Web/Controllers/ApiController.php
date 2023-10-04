<?php

namespace Test\Web\Controllers;

use Majframe\Web\Controllers\CoreController;
use Majframe\Web\Http\Response;
use Test\Web\Models\User;

class ApiController extends CoreController
{
    public function postsAction() : Response
    {

        print_d(User::get());

        return new Response(['message' => 'hello world'], null, 201, Response::JSON);
    }
}