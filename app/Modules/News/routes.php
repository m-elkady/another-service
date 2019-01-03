<?php

$router->group(['namespace' => 'App\Modules\News\Controllers','prefix'=>'news'], function ($router) {
    $router->any('/', 'NewsController@index');
    $router->any('/{action:add|create|insert}', 'NewsController@add');
    $router->any('/{action:update|change|rename|modify}', 'NewsController@edit');
    $router->any('/{action:delete|remove|del|destroy}', 'NewsController@delete');
    $router->any('/{action:select|list|view|search}', 'NewsController@view');
});
