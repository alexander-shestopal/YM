<?php

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
       //
});
$router->get('/key', function() {
    return \Illuminate\Support\Str::random(32);
});

$router->group(['prefix' => '/api/user/'], function () use ($router) {
    $router->post('register', '\App\Http\Controllers\API\ApiController@register');
    $router->post('sign-in', '\App\Http\Controllers\API\ApiController@login');
    
    $router->group(['middleware' => 'auth'], function () use ($router) { 
        $router->get('companies/{user_id}', '\App\Http\Controllers\API\ApiController@showUserCompanies');
        $router->post('companies', '\App\Http\Controllers\API\ApiController@storeCompany');        
        $router->post('recover-password', '\App\Http\Controllers\API\ApiController@recoverPassword');
    });  
});
