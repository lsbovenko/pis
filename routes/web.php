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



//Registration Routes...
Route::get('invite/{code}', 'Auth\RegisterController@showRegistrationForm')->name('invite');
Route::post('invite/{code}', 'Auth\RegisterController@register');

//login routes
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');


Route::group([
    'as' => 'users.',
    'prefix' => 'users'
    ], function () {
        Route::get('/', 'UsersController@index')->name('index');
        Route::get('/create', 'UsersController@create')->name('create');
        Route::post('/create', 'UsersController@saveNew');
        Route::get('/edit/{id}', 'UsersController@edit')->name('edit');
        Route::post('/update/{id}', 'UsersController@update')->name('update');
});

Route::group([
    'as' => 'profile.',
    'prefix' => 'profile'
], function () {
    Route::get('/', 'ProfileController@index')->name('index');
    Route::post('/update', 'ProfileController@update')->name('update');
    Route::post('/change-pass', 'ProfileController@changePass')->name('change-pass');
});