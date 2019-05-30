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
 * only auth users
 */
//'auth', 'active_user'
Route::group(['middleware' => ['jwt']], function () {
    Route::group(['middleware' => ['auth', 'check_user', 'refresh_jwt']], function () {
        Route::get('/', 'BrowseIdeasController@index')->name('main');
        Route::get('/priority-board', 'BrowseIdeasController@index')->name('priority-board');
        Route::get('/my-ideas', 'BrowseIdeasController@index')->name('my-ideas');
        Route::get('/add-idea', 'IndexController@addIdea')->name('add-idea');
        Route::post('/add-idea', 'IndexController@createIdea');
        Route::get('/success', 'IndexController@success')->name('add-idea-success');
        Route::get('/review-idea/{id}', 'ReviewIdeaController@index')->where('id', '[0-9]+')->name('review-idea');
        Route::get('/about', 'AboutController@index')->name('about');
        Route::post('/add-like', 'LikesController@addLike')->name('add-like');
        Route::post('/remove-like', 'LikesController@removeLike')->name('remove-like');
        Route::post('/add-comment/{id}', 'ReviewIdeaController@addComment')->where('id', '[0-9]+')->name('add-comment');
        Route::get('/comments/{id}', 'ReviewIdeaController@getComments')->where('id', '[0-9]+')->name('comments');

        //VueJS
        Route::get('/get-idea/all', 'Get\IdeasController@index')->name('get-idea/all');
        Route::get('/get-idea/filter', 'Get\IdeasController@getFilter')->name('get-idea/filter');
        Route::get('/get-idea/change-filter', 'Get\IdeasController@getChangeFilter')->name('get-idea/change-filter');
        Route::get('/get-idea/priority-board', 'Get\IdeasController@priorityBoard')->name('/get-idea/priority-board');
        Route::get('/get-idea/my-ideas', 'Get\IdeasController@myIdeas')->name('/get-idea/my-ideas');
        Route::get('/get-active-status-id', 'Categories\StatusController@getActiveStatusId')->name('/get-active-status-id');

        //superadmin or admin
        Route::group(['middleware' => ['role:admin|superadmin']], function() {
            Route::post('/pin-priority/{id}', 'ReviewIdeaController@pinToPriority')->where('id', '[0-9]+')->name('pin-priority');
            Route::get('/unpin-priority/{id}', 'ReviewIdeaController@unpinToPriority')->where('id', '[0-9]+')->name('unpin-priority');
            Route::post('/change-priority-reason/{id}', 'ReviewIdeaController@changePriorityReason')->where('id', '[0-9]+')->name('change-priority-reason');
            Route::post('/change-status/{id}', 'EditIdeaController@changeStatus')->where('id', '[0-9]+')->name('change-status');
        });

        //superadmin
        Route::group(['middleware' => ['role:superadmin']], function() {
            Route::get('/edit-idea/{id}', 'EditIdeaController@edit')->where('id', '[0-9]+')->name('edit-idea');
            Route::post('/edit-idea/{id}', 'EditIdeaController@postEdit')->where('id', '[0-9]+');
            Route::post('/review-idea/{id}', 'ReviewIdeaController@approve')->where('id', '[0-9]+');
            Route::get('/pending-review', 'BrowseIdeasController@index')->name('pending-review');
            Route::get('/declined', 'BrowseIdeasController@index')->name('declined');

            //VueJS
            Route::get('/get-idea/pending-review', 'Get\IdeasController@pendingReview')->name('/get-idea/pending-review');
            Route::get('/get-idea/declined', 'Get\IdeasController@declined')->name('/get-idea/declined');

            Route::group([
                'as' => 'users.',
                'prefix' => 'users'
            ], function () {
                Route::get('/', 'UsersController@index')->name('index');
            });

            //categories
            Route::group([
                'as' => 'categories.',
                'prefix' => 'categories'
            ], function () {
                Route::get('/', 'Categories\IndexController@index')->name('index');

                //statuses
                Route::group([
                    'as' => 'statuses.',
                    'prefix' => 'statuses'
                ], function () {
                    Route::get('/', 'Categories\StatusController@index')->name('index');
                    Route::get('/edit/{id}', 'Categories\StatusController@edit')->where('id', '[0-9]+')->name('edit');
                    Route::post('/edit/{id}', 'Categories\StatusController@update')->where('id', '[0-9]+');
                    Route::get('/delete/{id}', 'Categories\StatusController@delete')->where('id', '[0-9]+')->name('delete');
                    Route::get('/create', 'Categories\StatusController@create')->name('create');
                    Route::post('/create', 'Categories\StatusController@saveNew');
                });

                //core-competency
                Route::group([
                    'as' => 'core-competency.',
                    'prefix' => 'core-competency'
                ], function () {
                    Route::get('/', 'Categories\CoreCompetencyController@index')->name('index');
                    Route::get('/edit/{id}', 'Categories\CoreCompetencyController@edit')->where('id', '[0-9]+')->name('edit');
                    Route::post('/edit/{id}', 'Categories\CoreCompetencyController@update')->where('id', '[0-9]+');
                    Route::get('/delete/{id}', 'Categories\CoreCompetencyController@delete')->where('id', '[0-9]+')->name('delete');
                    Route::get('/create', 'Categories\CoreCompetencyController@create')->name('create');
                    Route::post('/create', 'Categories\CoreCompetencyController@saveNew');
                });

                //operational-goal
                Route::group([
                    'as' => 'operational-goal.',
                    'prefix' => 'operational-goal'
                ], function () {
                    Route::get('/', 'Categories\OperationalGoalController@index')->name('index');
                    Route::get('/edit/{id}', 'Categories\OperationalGoalController@edit')->where('id', '[0-9]+')->name('edit');
                    Route::post('/edit/{id}', 'Categories\OperationalGoalController@update')->where('id', '[0-9]+');
                    Route::get('/delete/{id}', 'Categories\OperationalGoalController@delete')->where('id', '[0-9]+')->name('delete');
                    Route::get('/create', 'Categories\OperationalGoalController@create')->name('create');
                    Route::post('/create', 'Categories\OperationalGoalController@saveNew');
                });

                //strategic_objective
                Route::group([
                    'as' => 'strategic-objective.',
                    'prefix' => 'strategic-objective'
                ], function () {
                    Route::get('/', 'Categories\StrategicObjectiveController@index')->name('index');
                    Route::get('/edit/{id}', 'Categories\StrategicObjectiveController@edit')->where('id', '[0-9]+')->name('edit');
                    Route::post('/edit/{id}', 'Categories\StrategicObjectiveController@update')->where('id', '[0-9]+');
                    Route::get('/delete/{id}', 'Categories\StrategicObjectiveController@delete')->where('id', '[0-9]+')->name('delete');
                    Route::get('/create', 'Categories\StrategicObjectiveController@create')->name('create');
                    Route::post('/create', 'Categories\StrategicObjectiveController@saveNew');
                });

                //type
                Route::group([
                    'as' => 'type.',
                    'prefix' => 'type'
                ], function () {
                    Route::get('/', 'Categories\TypeController@index')->name('index');
                    Route::get('/edit/{id}', 'Categories\TypeController@edit')->where('id', '[0-9]+')->name('edit');
                    Route::post('/edit/{id}', 'Categories\TypeController@update')->where('id', '[0-9]+');
                    Route::get('/delete/{id}', 'Categories\TypeController@delete')->where('id', '[0-9]+')->name('delete');
                    Route::get('/create', 'Categories\TypeController@create')->name('create');
                    Route::post('/create', 'Categories\TypeController@saveNew');
                });

                //department
                Route::group([
                    'as' => 'department.',
                    'prefix' => 'department'
                ], function () {
                    Route::get('/', 'Categories\DepartmentController@index')->name('index');
                    Route::get('/edit/{id}', 'Categories\DepartmentController@edit')->where('id', '[0-9]+')->name('edit');
                    Route::post('/edit/{id}', 'Categories\DepartmentController@update')->where('id', '[0-9]+');
                    Route::get('/delete/{id}', 'Categories\DepartmentController@delete')->where('id', '[0-9]+')->name('delete');
                    Route::get('/create', 'Categories\DepartmentController@create')->name('create');
                    Route::post('/create', 'Categories\DepartmentController@saveNew');
                });

                //position
                Route::group([
                    'as' => 'position.',
                    'prefix' => 'position'
                ], function () {
                    Route::get('/', 'Categories\PositionController@index')->name('index');
                    Route::get('/edit/{id}', 'Categories\PositionController@edit')->where('id', '[0-9]+')->name('edit');
                    Route::post('/edit/{id}', 'Categories\PositionController@update')->where('id', '[0-9]+');
                    Route::get('/delete/{id}', 'Categories\PositionController@delete')->where('id', '[0-9]+')->name('delete');
                    Route::get('/create', 'Categories\PositionController@create')->name('create');
                    Route::post('/create', 'Categories\PositionController@saveNew');
                });
            });
        });
    });
});