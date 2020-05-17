<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Api Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Api routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "Api" middleware group. Enjoy building your API!
|
*/

Route::middleware('api')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::group(['prefix' => '/projects'], function () {
        Route::get('/', 'API\Projects\ProjectsController@index');
        Route::get('/count', 'API\Projects\ProjectsController@count');
        Route::get('/project_no', 'API\Projects\ProjectsController@getNextProjectNo');
        Route::post('/', 'API\Projects\ProjectsController@store');
        Route::group(['prefix' => '/{id}'], function () {
            Route::get('/', 'API\Projects\ProjectsController@show');
            Route::patch('/', 'API\Projects\ProjectsController@update');
            Route::delete('/', 'API\Projects\ProjectsController@destroy');
        });
    });

    Route::group(['prefix' => '/subprojects'], function () {
        Route::get('/', 'API\Projects\SubProjectsController@index');
        Route::get('/subproject_no', 'API\Projects\SubProjectsController@getNextSubProjectNo');
        Route::post('/', 'API\Projects\SubProjectsController@store');
        Route::group(['prefix' => '/{id}'], function () {
            Route::get('/', 'API\Projects\SubProjectsController@show');
            Route::patch('/', 'API\Projects\SubProjectsController@update');
            Route::delete('/', 'API\Projects\SubProjectsController@delete');
        });
    });

    Route::group(['prefix' => '/activity'], function () {
        Route::get('/', 'API\Activity\ActivityController@index');
        Route::post('/', 'API\Activity\ActivityController@store');
        Route::group(['prefix' => '/{id}'], function () {
            Route::get('/', 'API\Activity\ActivityController@show');
            Route::patch('/', 'API\Activity\ActivityController@update');
            Route::delete('/', 'API\Activity\ActivityController@delete');

            Route::post('/add-tba', 'API\Activity\ActivityTBASController@store');
            Route::get('/get-tba', 'API\Activity\ActivityTBASController@index');

            Route::post('/add-comment', 'API\Activity\ActivityCommentsController@store');
            Route::get('/get-comments', 'API\Activity\ActivityCommentsController@index');
        });

        Route::delete('/remove-tba/{atba_id}', 'API\Activity\ActivityTBASController@delete');
        Route::patch('/update-tba/{atba_id}', 'API\Activity\ActivityTBASController@update');

        Route::delete('/remove-comment/{comment_id}', 'API\Activity\ActivityCommentsController@delete');
        Route::patch('/update-comment/{comment_id}', 'API\Activity\ActivityCommentsController@update');
    });

    Route::group(['prefix' => '/time-history'], function () {
        Route::get('/', 'API\Reports\TimeHistoryController@index');
        Route::get('/count', 'API\Reports\TimeHistoryController@count');
        Route::post('/', 'API\Reports\TimeHistoryController@store');
        Route::group(['prefix' => '/{id}'], function () {
            Route::get('/', 'API\Reports\TimeHistoryController@show');
            Route::patch('/', 'API\Reports\TimeHistoryController@update');
            Route::delete('/', 'API\Reports\TimeHistoryController@destroy');

            Route::post('/add-screenshot', 'API\Reports\TimeHistoryScreenshotsController@store');
            Route::get('/get-screenshots', 'API\Reports\TimeHistoryScreenshotsController@index');
            Route::get('/show-screenshot', 'API\Reports\TimeHistoryScreenshotsController@show');
        });

        Route::patch('/update-screenshot/{id}', 'API\Reports\TimeHistoryScreenshotsController@update');
        Route::delete('/delete-screenshot/{id}', 'API\Reports\TimeHistoryScreenshotsController@destroy');
    });

    Route::group(['prefix' => '/activities'], function() {
        Route::group(['prefix' => '/activity-files'], function () {
            Route::get('/', 'API\Activities\ActivityFilesController@index');
            Route::post('/', 'API\Activities\ActivityFilesController@store');
            Route::group(['prefix' => '/{id}'], function () {
                Route::get('/', 'API\Activities\ActivityFilesController@show');
                Route::patch('/', 'API\Activities\ActivityFilesController@update');
                Route::delete('/', 'API\Activities\ActivityFilesController@delete');
            });
        });
    });        
    
    Route::group(['prefix' => '/subprojects'], function () {
        Route::post('/assign-employee', 'API\Projects\SubprojectEmployeesController@assignBatchEmployees');
        Route::post('/unassign-employee', 'API\Projects\SubprojectEmployeesController@unassignSubprojectEmployee');
        Route::get('/employees', 'API\Projects\SubprojectEmployeesController@index');
        Route::get('/employees/count', 'API\Projects\SubprojectEmployeesController@count');
        Route::group(['prefix' => '/employees/{id}'], function () {
            Route::get('/', 'API\Projects\SubprojectEmployeesController@show');
            Route::patch('/', 'API\Projects\SubprojectEmployeesController@update');
        });
    });

});

Route::post('/login', 'Auth\APILoginController@login');
