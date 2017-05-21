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

Route::get('/', 'IndexController@index');


//all auth routes
//var_dump($this);die();
Auth::routes();

// auth routes...
/*Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');*/

// register routes
/*Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');*/

Route::get('/home', 'HomeController@index')->name('home');


Route::group([
    'as' => 'users::',
    'prefix' => 'users'
    ], function () {

        Route::get('/', 'UsersController@index')->name('list');
        Route::get('/create', 'UsersController@create')->name('create');
        Route::get('/edit', 'UsersController@show')->name('edit');
        Route::post('/update/{id?}', 'UsersController@update');

});