<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('api/tasks/','TasksController@index');
$router->post('api/tasks/store','TasksController@store');
$router->delete('api/tasks/destroy/{id}','TasksController@destroy');
$router->put('api/tasks/update/{id}','TasksController@update');
$router->get('api/tasks/testing/{id}','TasksController@testing');
