<?php

use Majframe\Web\Router\Router;
use Test\Web\Controllers\TestController;


Router::addRoute('/posts/{id}', 'TestController@indexAction', 'Posts');

Router::addRoute('/posts/list/{page}', 'TestController@listAction', 'PostsList');

Router::addRoute('/posts/{id}/{commentId}', 'TestController@commentAction', 'PostsComment');

Router::addRoute('/admin', 'Test\AdminController@adminAction', 'AdminController');