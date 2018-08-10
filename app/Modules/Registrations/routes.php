<?php
$prefixes = ['registration', 'registrations'];
foreach ($prefixes as $prefix) {
  $router->group(['namespace' => 'App\Modules\Registrations\Controllers', 'prefix' => $prefix], function ($router) {
    $router->get('/', 'RegistrationsController@index');
    $router->post('/', 'RegistrationsController@index');
    $router->get('/{action:join|register|signup|subscribe|insert|create|add}', 'RegistrationsController@add');
    $router->post('/{action:join|register|signup|subscribe|insert|create|add}', 'RegistrationsController@add');
    $router->get('/{action:delete|remove|del|cancel}', 'RegistrationsController@delete');
    $router->post('/{action:delete|remove|del|cancel}', 'RegistrationsController@delete');
    $router->delete('/{action:delete|remove|del|cancel}', 'RegistrationsController@delete');
    $router->get('/{action:select|list|view|search}', 'RegistrationsController@view');
    $router->post('/{action:select|list|view|search}', 'RegistrationsController@view');
  });
}