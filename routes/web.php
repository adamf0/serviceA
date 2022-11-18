<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Router;

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
    // return $router->app->version();
    return Hash::make("251423");
});
// $router->get('/users', function () use ($router) {
//     $results = DB::select("SELECT * FROM users");
//     dd($results);
// });
// $router->group(['middleware' => 'auth'], function($router){
//     $router->get('/tes', function () use ($router) {
//         return response()->json([
//             'message' => 'Hello World!',
//         ]);
//     });
// });
$router->post('/auth/login', 'AuthController@doLogin');
$router->get('/auth/decode', function (Request $request) use ($router) {
    return response()->json(auth()->user());
});
$router->get('/users', 'UsersController@index');
$router->post('/users/store', 'UsersController@store');
