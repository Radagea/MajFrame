<?php

namespace Majframe\Web\Controllers;

use Majframe\Web\Http\Request;
use Majframe\Web\Http\Response;

class CoreController
{
    protected Request $request;
    protected Response $response;

    final public function setRequest(Request $request)
    {
            $this->request = $request;
    }

    public function methodNotEnabled() : Response
    {
        return new Response(['err' => 'Error', 'message' => 'Method is not enabled'], null, 405, Response::JSON);
    }

}
