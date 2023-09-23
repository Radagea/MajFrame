<?php

namespace Test\Web\Controllers;

use Majframe\Web\Controllers\CoreController;
use Majframe\Web\Http\Response;

class ApiController extends CoreController
{
    public function postsAction() : Response
    {
        $this->response->setContentType(Response::JSON);
        $this->response->setResponseCode(200);
        $this->response->vars = ['message' => 'There is no posts in there'];

        return $this->response;
    }
}