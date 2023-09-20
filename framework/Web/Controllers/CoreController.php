<?php

namespace Majframe\Web\Controllers;

use Majframe\Web\Http\Request;
use Majframe\Web\Http\Response;

class CoreController
{
    protected Request $request;
    protected Response $response;
    public function __construct()
    {
        $this->request = new Request();
        $this->response = new Response();
    }

}
