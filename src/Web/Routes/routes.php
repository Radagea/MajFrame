<?php

use Majframe\Web\Router\Router;

Router::getRouteByName('404')->setController('errorController@action404');

Router::addRoute('/posts/{id}', 'TestController@indexAction', 'Posts');

Router::addRoute('/posts/list/{page}', 'TestController@listAction', 'PostsList');

Router::addRoute('/posts/{id}/{commentId}', 'TestController@commentAction', 'PostsComment');

Router::addRoute('/admin', 'Test\AdminController@adminAction', 'AdminController');

Router::addRoute('/api/posts', 'ApiController@postsAction', 'PostsApi');

Router::addApiRoute('/api/posts', 'ApiController', 'PostsApi', ['GET' => 'postsAction']);
