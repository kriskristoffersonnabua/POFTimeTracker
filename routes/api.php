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

Route::middleware('auth:api')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::group(['prefix' => '/projects'], function () {
        Route::get('/', 'Api\Projects\ProjectsController@index');
        Route::get('/count', 'Api\Projects\ProjectsController@count');
        Route::post('/', 'Api\Projects\ProjectsController@store');
        Route::group(['prefix' => '/{id}'], function () {
            Route::get('/', 'Api\Projects\ProjectsController@show');
            Route::patch('/', 'Api\Projects\ProjectsController@update');
            Route::delete('/', 'Api\Projects\ProjectsController@destroy');
        });
    });

    Route::group(['prefix' => '/subprojects'], function () {
        Route::get('/', 'Api\Projects\SubProjectsController@index');
        Route::post('/', 'Api\Projects\SubProjectsController@store');
        Route::group(['prefix' => '/{id}'], function () {
            Route::get('/', 'Api\Projects\SubProjectsController@show');
            Route::patch('/', 'Api\Projects\SubProjectsController@update');
            Route::delete('/', 'Api\Projects\SubProjectsController@delete');
        });
    });

    Route::group(['prefix' => '/activity'], function () {
        Route::get('/', 'Api\Activity\ActivityController@index');
        Route::post('/', 'Api\Activity\ActivityController@store');
        Route::group(['prefix' => '/{id}'], function () {
            Route::get('/', 'Api\Activity\ActivityController@show');
            Route::patch('/', 'Api\Activity\ActivityController@update');
            Route::delete('/', 'Api\Activity\ActivityController@delete');

            Route::post('/add-tba', 'Api\Activity\ActivityTBASController@store');
            Route::get('/get-tba', 'Api\Activity\ActivityTBASController@index');

            Route::post('/add-comment', 'Api\Activity\ActivityCommentsController@store');
            Route::get('/get-comments', 'Api\Activity\ActivityCommentsController@index');
        });

        Route::delete('/remove-tba/{atba_id}', 'Api\Activity\ActivityTBASController@delete');
        Route::patch('/update-tba/{atba_id}', 'Api\Activity\ActivityTBASController@update');

        Route::delete('/remove-comment/{comment_id}', 'Api\Activity\ActivityCommentsController@delete');
        Route::patch('/update-comment/{comment_id}', 'Api\Activity\ActivityCommentsController@update');
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
        Route::post('/assign-employee', 'API\Employees\SubprojectEmployeesController@assignBatchEmployees');
        Route::post('/unassign-employee', 'API\Employees\SubprojectEmployeesController@unassignSubprojectEmployee');
        Route::get('/employees', 'API\Employees\SubprojectEmployeesController@index');
        Route::get('/employees/count', 'API\Employees\SubprojectEmployeesController@count');
        Route::group(['prefix' => '/employees/{id}'], function () {
            Route::get('/', 'API\Employees\SubprojectEmployeesController@show');
            Route::patch('/', 'API\Employees\SubprojectEmployeesController@update');
        });
    });

});

Route::post('/login', 'Auth\APILoginController@login');
