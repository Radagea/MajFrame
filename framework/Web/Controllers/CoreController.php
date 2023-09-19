<?php

namespace Majframe\Web\Controllers;

use Majframe\Web\Http\Request;
use Majframe\Web\Router\Route;
use Majframe\Web\Router\Router;

class CoreController
{
    protected Request $request;
    public function __construct()
    {
        $this->request = new Request();
    }

}
