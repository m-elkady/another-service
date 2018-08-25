<?php
$prefixes = ['groups', 'group'];
foreach ($prefixes as $prefix) {
    $router->group(['namespace' => 'App\Modules\Groups\Controllers', 'prefix' => $prefix], function ($router) {
        $router->get('/', 'GroupsController@index');
        $router->post('/', 'GroupsController@index');
        $router->get('/{action:add|create|insert}', 'GroupsController@add');
        $router->post('/{action:add|create|insert}', 'GroupsController@add');
        $router->get('/{action:update|change|rename|modify}', 'GroupsController@edit');
        $router->post('/{action:update|change|rename|modify}', 'GroupsController@edit');
        $router->get('/{action:delete|remove|del|destroy}', 'GroupsController@delete');
        $router->post('/{action:delete|remove|del|destroy}', 'GroupsController@delete');
        $router->delete('/{action:delete|remove|del|destroy}', 'GroupsController@delete');
        $router->get('/{action:select|list|view|search}', 'GroupsController@view');
        $router->post('/{action:select|list|view|search}', 'GroupsController@view');

        // user groups
        $router->get('/{prefix:user|users|member|members}/{action:link|bind|enter|join|add}', 'UserGroupsController@add');
        $router->post('/{prefix:user|users|member|members}/{action:link|bind|enter|join|add}', 'UserGroupsController@add');
        $router->get('/{prefix:user|users|member|members}/{action:list|view|search|select}', 'UserGroupsController@view');
        $router->post('/{prefix:user|users|member|members}/{action:list|view|search|select}', 'UserGroupsController@view');
        $router->get('/{prefix:user|users|member|members}/{action:del|remove|leave|unbind|exit|unlink|quit}', 'UserGroupsController@delete');
        $router->post('/{prefix:user|users|member|members}/{action:del|remove|leave|unbind|exit|unlink|quit}', 'UserGroupsController@delete');
    });
}
