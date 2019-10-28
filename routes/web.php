<?php

use \App\Http\Requests\TransferRequest;

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

//$router->post('/transfer', [
//    'as' => 'transfer',
//    'uses' => 'AccountController@transfer',
//]);

$router->post('/transfer', [
    'as' => 'transfer',
    'uses' => 'AccountController@transfer',
    function (TransferRequest $request) {
        $this->validate($request->json()->all(), $request->rules());
    }
]);
