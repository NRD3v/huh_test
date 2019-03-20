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

Route::prefix('api')->group(function () {
    Route::get('/test', 'DevController@test');

    Route::prefix('users')->group(function () {
        Route::put('/{id}/permission', 'UsersController@updatePermission');
        Route::delete('/{id}', 'UsersController@delete');
        Route::put('/{id}', 'UsersController@update');
        Route::get('/{id}', 'UsersController@getById');
        Route::post('/', 'UsersController@store');
        Route::get('/', 'UsersController@list');
    });
});

Route::get('/', function () {
    return view('welcome');
});
