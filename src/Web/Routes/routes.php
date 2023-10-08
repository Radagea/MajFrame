<?php

use Majframe\Web\Router\Router;

Router::getRouteByName('404')->setController('errorController@action404');

Router::addApiRoute('/api/posts', 'ApiController', 'PostsApi', ['GET' => 'postsAction']);
