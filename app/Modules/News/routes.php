<?php

$router->group(['namespace' => 'App\Modules\News\Controllers','prefix'=>'news'], function ($router) {
    $router->get('/', 'NewsController@index');
    $router->post('/', 'NewsController@index');
    $router->get('/{action:add|create|insert}', 'NewsController@add');
    $router->post('/{action:add|create|insert}', 'NewsController@add');
    $router->get('/{action:update|change|rename|modify}', 'NewsController@edit');
    $router->post('/{action:update|change|rename|modify}', 'NewsController@edit');
    $router->get('/{action:delete|remove|del|destroy}', 'NewsController@delete');
    $router->post('/{action:delete|remove|del|destroy}', 'NewsController@delete');
    $router->delete('/{action:delete|remove|del|destroy}', 'NewsController@delete');
    $router->get('/{action:select|list|view|search}', 'NewsController@view');
    $router->post('/{action:select|list|view|search}', 'NewsController@view');
});
