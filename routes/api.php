<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::group(['prefix' => '/projects'], function ($route) {
        Route::get('/', 'API\Projects\ProjectsController@index');
        Route::post('/', 'API\Projects\ProjectsController@store');
        Route::group(['prefix' => '/{projectsID:[0-9]+}'], function ($route) {
            Route::PUT('/', 'API\Projects\ProjectsController@update');
            Route::DELETE('/', 'API\Projects\ProjectsController@delete');
        });
    });
});

Route::post('/login', 'Auth\APILoginController@login');
