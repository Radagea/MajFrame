<?php

namespace Test\Web\Controllers\Test;

use Majframe\Web\Controllers\Controller;

class AdminController extends Controller
{
    public function __construct()
    {
    }

    public function adminAction()
    {
        echo '<h1>Admin Controller</h1>';
    }
}