<?php

namespace Test\Web\Controllers;

use Majframe\Web\Controllers\CoreController;
use Majframe\Web\Http\Response;

class ApiController extends CoreController
{
    public function postsAction() : Response
    {
        return new Response(['message' => 'hello world', 'kaka' => ['again' => 'asd']], null, 201, Response::JSON);
    }
}