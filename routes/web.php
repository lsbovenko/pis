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

// all
Route::get('/', 'IndexController@index')->name('main');
Route::get('/add-idea', 'IndexController@addIdea')->name('add-idea');
Route::post('/add-idea', 'IndexController@createIdea');
Route::get('/success', 'IndexController@success')->name('add-idea-success');


//superadmin and admin
Route::get('/review-idea/{id}', 'ReviewIdeaController@index')->where('id', '[0-9]+')->name('review-idea');


Route::post('/pin-priority/{id}', 'ReviewIdeaController@pinToPriority')->where('id', '[0-9]+')->name('pin-priority');
Route::post('/unpin-priority/{id}', 'ReviewIdeaController@unpinToPriority')->where('id', '[0-9]+')->name('unpin-priority');
Route::post('/change-priority-reason/{id}', 'ReviewIdeaController@changePriorityReason')->where('id', '[0-9]+')->name('change-priority-reason');
Route::post('/change-status/{id}', 'EditIdeaController@changeStatus')->where('id', '[0-9]+')->name('change-status');
Route::get('/edit-idea/{id}', 'EditIdeaController@edit')->where('id', '[0-9]+')->name('edit-idea');
Route::post('/edit-idea/{id}', 'EditIdeaController@postEdit')->where('id', '[0-9]+');

//superadmin
Route::post('/review-idea/{id}', 'ReviewIdeaController@approve')->where('id', '[0-9]+');


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