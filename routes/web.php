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
    $router->get('Admins',    
        ['uses'=> 'AdminController@showAllAdmins']
    );
    $router->get('Admins/{id}', 
        ['uses'=> 'AdminController@showOneAdmin']
    );
    $router->post('Admins', 
        ['uses'=> 'AdminController@createAdmin']
    );
    $router->delete('Admins/{id}', 
        ['uses'=> 'AdminController@deleteAdmin']
    );
    $router->put('Admins/{id}', 
        ['uses'=> 'AdminController@updateAdmin']
    );
    $router->post('login/', 
        ['uses'=> 'AdminController@login']    
    );
});
  
