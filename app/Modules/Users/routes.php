<?php

$prefixes = ['users', 'user'];
foreach ($prefixes as $prefix) {
    $router->group(['namespace' => 'App\Modules\Users\Controllers', 'prefix' => $prefix], function ($router) {
        $router->get('/', 'UsersController@index');
        $router->post('/', 'UsersController@index');
        $router->get('/{action:add|create|insert}', 'UsersController@add');
        $router->post('/{action:add|create|insert}', 'UsersController@add');
        $router->get('/{action:update|change|modify}', 'UsersController@edit');
        $router->post('/{action:update|change|modify}', 'UsersController@edit');
        $router->get('/{action:delete|remove|del|destroy}', 'UsersController@delete');
        $router->post('/{action:delete|remove|del|destroy}', 'UsersController@delete');
        $router->delete('/{action:delete|remove|del|destroy}', 'UsersController@delete');
        $router->get('/{action:select|list|view|search}', 'UsersController@view');
        $router->post('/{action:select|list|view|search}', 'UsersController@view');
        $router->post('/{action:bcompute}', 'UsersController@bcompute');
        $router->get('/{action:bcompute}', 'UsersController@bcompute');
    });
}
