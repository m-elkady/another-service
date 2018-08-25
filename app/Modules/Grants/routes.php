<?php
$prefixes = ['grants', 'grant'];
foreach ($prefixes as $prefix) {
    $router->group(['namespace' => 'App\Modules\Grants\Controllers', 'prefix'=> $prefix], function ($router) {
        $router->get('/', 'GrantsController@index');
        $router->post('/', 'GrantsController@index');
        $router->get('/{action:add|create}', 'GrantsController@add');
        $router->post('/{action:add|create}', 'GrantsController@add');
        $router->get('/{action:modify|change|rename}', 'GrantsController@edit');
        $router->post('/{action:modify|change|rename}', 'GrantsController@edit');
        $router->get('/{action:del|remove|destroy}', 'GrantsController@delete');
        $router->post('/{action:del|remove|destroy}', 'GrantsController@delete');
        $router->delete('/{action:del|remove|destroy}', 'GrantsController@delete');
        $router->get('/{action:list|view|search}', 'GrantsController@view');
        $router->post('/{action:list|view|search}', 'GrantsController@view');

        // user grants
        $router->get('/{prefix:user|users}/{action:allow|accept|give|add|insert}', 'UserGrantsController@add');
        $router->post('/{prefix:user|users}/{action:allow|accept|give|add|insert}', 'UserGrantsController@add');
        $router->get('/{prefix:user|users}/{action:list|view|search|check|verify}', 'UserGrantsController@view');
        $router->post('/{prefix:user|users}/{action:list|view|search|check|verify}', 'UserGrantsController@view');
        $router->get('/{prefix:user|users}/{action:del|remove|reject|deny|revoke}', 'UserGrantsController@delete');
        $router->post('/{prefix:user|users}/{action:del|remove|reject|deny|revoke}', 'UserGrantsController@delete');
    });
}
