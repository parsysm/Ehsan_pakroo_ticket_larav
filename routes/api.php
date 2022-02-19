<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group([
    'prefix' => 'user',
    'namespace' => 'App\Http\Controllers\User',
], function() {
    Route::post('/auth/register', 'AuthController@register');
    Route::post('/auth/login', 'AuthController@login');

    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::get('/me', 'UserController@me');

        Route::get('/auth/logout', 'AuthController@logout');
    });

    Route::group([
        'prefix' => 'tickets'
    ], function() {
        Route::post('', 'TicketController@create');
        Route::get('{ticket}/view', 'TicketController@show');
        Route::post('{ticket}/reply', 'ReplyController@create');
        Route::post('search', 'TicketController@search');

    });

});



