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

Route::get('/', 'IndexController@index')->name('main');




// auth routes...
//Auth::routes();
//Registration Routes...
Route::get('invite/{code}', 'Auth\RegisterController@showRegistrationForm');
Route::post('invite/{code}', 'Auth\RegisterController@register');


Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');


Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');




Route::get('/home', 'HomeController@index')->name('home');


Route::group([
    'as' => 'users.',
    'prefix' => 'users'
    ], function () {

        Route::get('/', 'UsersController@index')->name('index');
        Route::get('/create', 'UsersController@create')->name('create');
        Route::post('/create', 'UsersController@saveNew');
        Route::get('/edit', 'UsersController@show');
        Route::post('/update/{id}', 'UsersController@update');

});