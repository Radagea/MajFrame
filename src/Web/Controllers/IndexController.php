<?php

namespace Test\Web\Controllers;

use Majframe\Web\Controllers\CoreController;
use Majframe\Web\Http\Response;

class IndexController extends CoreController
{
    public function indexAction() : Response
    {
        echo '<h1>Index Action</h1>';

        print_d($this->request->getHeaders());

        print_d($this->request->getRoute());

        return new Response();
    }

}