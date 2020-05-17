<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


/**
 * Auth routes
 */
Route::group(['namespace' => 'Auth'], function () {

    // Authentication Routes...
    Route::get('login', 'LoginController@showLoginForm')->name('login');
    Route::post('login', 'LoginController@login');
    Route::get('logout', 'LoginController@logout')->name('logout');

    // Registration Routes...
    if (config('auth.users.registration')) {
        Route::get('register', 'RegisterController@showRegistrationForm')->name('register');
        Route::post('register', 'RegisterController@register');
    }

    // Password Reset Routes...
    Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'ResetPasswordController@reset');

    // Confirmation Routes...
    if (config('auth.users.confirm_email')) {
        Route::get('confirm/{user_by_code}', 'ConfirmController@confirm')->name('confirm');
        Route::get('confirm/resend/{user_by_email}', 'ConfirmController@sendEmail')->name('confirm.send');
    }

    // Social Authentication Routes...
    Route::get('social/redirect/{provider}', 'SocialLoginController@redirect')->name('social.redirect');
    Route::get('social/login/{provider}', 'SocialLoginController@login')->name('social.login');
});

/**
 * Backend routes
 */
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => 'admin'], function () {

    // Dashboard
    Route::get('/', 'DashboardController@index')->name('dashboard');
    Route::get('/projects', 'ProjectController@index')->name('projects');
    Route::get('/subprojects', 'SubProjectController@index')->name('subprojects');
    Route::get('/activities', 'ActivitiesController@index')->name('activities');
    Route::get('/employees', 'EmployeesController@index')->name('employees');
    Route::get('/reports', 'ReportsController@index')->name('reports');

    //projects
    Route::post('/projects', 'ProjectController@create')->name('projects.create');
    Route::patch('/projects/{id}', 'ProjectController@update')->name('projects.update');
    Route::delete('/projects/{id}', 'ProjectController@destroy')->name('projects.destroy');

    //subprojects
    Route::post('/subprojects', 'SubProjectController@create')->name('subprojects.create');
    Route::get('/subprojects/subproject_no', 'SubProjectController@getNextSubProjectNo')->name('subprojects.project_no');
    Route::get('/subprojects/employees', 'SubProjectController@getAssignedEmployees')->name('subprojects.employees');
    Route::post('/subprojects/{id}/assign', 'SubProjectController@assign')->name('subprojects.assign');
    Route::patch('/subprojects/{id}', 'SubProjectController@update')->name('subprojects.update');
    Route::delete('/subprojects/{id}', 'SubProjectController@destroy')->name('subprojects.destroy');

    //activity
    Route::get('/activities/activity_no', 'ActivitiesController@getNextActivityNo')->name('activities.activity_no');
    Route::post('/activities', 'ActivitiesController@create')->name('activities.create');
    Route::get('/activities/{id}', 'ActivitiesController@show')->name('activities.show');
    Route::patch('/activities/{id}', 'ActivitiesController@update')->name('activities.update');
    Route::delete('/activities/{id}', 'ActivitiesController@destroy')->name('activities.destroy');
    
    //Users
    Route::get('users', 'UserController@index')->name('users');
    Route::get('users/restore', 'UserController@restore')->name('users.restore');
    Route::get('users/{id}/restore', 'UserController@restoreUser')->name('users.restore-user');
    Route::get('users/{user}', 'UserController@show')->name('users.show');
    Route::get('users/{user}/edit', 'UserController@edit')->name('users.edit');
    Route::put('users/{user}', 'UserController@update')->name('users.update');
    Route::any('users/{id}/destroy', 'UserController@destroy')->name('users.destroy');
    Route::get('permissions', 'PermissionController@index')->name('permissions');
    Route::get('permissions/{user}/repeat', 'PermissionController@repeat')->name('permissions.repeat');
    Route::get('dashboard/log-chart', 'DashboardController@getLogChartData')->name('dashboard.log.chart');
    Route::get('dashboard/registration-chart', 'DashboardController@getRegistrationChartData')->name('dashboard.registration.chart');
});

// Demo Routes for Employees
Route::get('/', 'HomeController@index');
Route::get('/', 'Admin\DashboardController@index')->name('dashboard');
Route::get('/projects', 'Admin\ProjectController@index')->name('projects');
Route::get('/subprojects', 'Admin\SubProjectController@index')->name('subprojects');
Route::get('/activities', 'Admin\ActivitiesController@index')->name('activities');
Route::get('/employees', 'Admin\EmployeesController@index')->name('employees');
Route::get('/reports', 'Admin\ReportsController@index')->name('reports');

/**
 * Membership
 */
Route::group(['as' => 'protection.'], function () {
    Route::get('membership', 'MembershipController@index')->name('membership')->middleware('protection:' . config('protection.membership.product_module_number') . ',protection.membership.failed');
    Route::get('membership/access-denied', 'MembershipController@failed')->name('membership.failed');
    Route::get('membership/clear-cache/', 'MembershipController@clearValidationCache')->name('membership.clear_validation_cache');
});
