<?php

namespace Test\Web\Controllers;

use Majframe\Web\Controllers\Controller;
use Majframe\Web\Router\Router;

class TestController extends Controller
{
    public function indexAction()
    {
        echo '<h1>TestController indexAction </h1>' . Router::getCurrentUri();

        print_d($this->request->getHeaders());

        print_d($this->request->getRoute());

    }
}