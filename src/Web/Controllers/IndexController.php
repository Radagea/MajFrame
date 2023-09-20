<?php

namespace Test\Web\Controllers;

use Majframe\Web\Controllers\Controller;

class IndexController extends Controller
{
    public function indexAction()
    {
        echo '<h1>Index Action</h1>';

        print_d($this->request->getHeaders());

        print_d($this->request->getRoute());
    }

}