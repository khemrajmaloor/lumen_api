<?php

use App\Http\Controllers\AdminController;

/** @var \Laravel\Lumen\Routing\Router $router */

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

//Admin register  group routes..
$router->group(['prefix' => 'api'], function () use ($router) {
    $router->get('admins',    
        ['uses'=> 'AdminController@showAllAdmins']
    );
    $router->get('admins/{id}', 
        ['uses'=> 'AdminController@showOneAdmin']
    );
    $router->post('admins', 
        ['uses'=> 'AdminController@createAdmin']
    );
    $router->delete('admins/{id}', 
        ['uses'=> 'AdminController@deleteAdmin']
    );
    $router->put('admins/{id}', 
        ['uses'=> 'AdminController@updateAdmin']
    );
});
  

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->post('login', ['uses' => 'AuthController@postLogin']);
    $router->post('create',['uses' => 'AuthController@createUser']);
});