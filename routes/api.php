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

    Route::group(['prefix' => '/projects'], function () {
        Route::get('/', 'API\Projects\ProjectsController@index');
        Route::get('/count', 'API\Projects\ProjectsController@count');
        Route::post('/', 'API\Projects\ProjectsController@store');
        Route::group(['prefix' => '/{id}'], function () {
            Route::get('/', 'API\Projects\ProjectsController@show');
            Route::patch('/', 'API\Projects\ProjectsController@update');
            Route::delete('/', 'API\Projects\ProjectsController@destroy');
        });
    });

    Route::group(['prefix' => '/subprojects'], function () {
        Route::get('/', 'API\Projects\SubProjectsController@index');
        Route::post('/', 'API\Projects\SubProjectsController@store');
        Route::group(['prefix' => '/{id}'], function () {
            Route::get('/', 'API\Projects\SubProjectsController@show');
            Route::patch('/', 'API\Projects\SubProjectsController@update');
            Route::delete('/', 'API\Projects\SubProjectsController@delete');
        });
    });
});

Route::post('/login', 'Auth\APILoginController@login');
