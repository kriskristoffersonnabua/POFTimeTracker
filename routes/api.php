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

    Route::group(['prefix' => '/time-history'], function () {
        Route::get('/', 'API\Reports\TimeHistoryController@index');
        Route::get('/count', 'API\Reports\TimeHistoryController@count');
        Route::post('/', 'API\Reports\TimeHistoryController@store');
        Route::group(['prefix' => '/{id}'], function () {
            Route::get('/', 'API\Reports\TimeHistoryController@show');
            Route::patch('/', 'API\Reports\TimeHistoryController@update');
            Route::delete('/', 'API\Reports\TimeHistoryController@destroy');
        });
    });
});

Route::post('/login', 'Auth\APILoginController@login');
