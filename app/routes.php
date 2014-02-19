<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('layouts.master');
});

Route::post('users/index', 'UserController@postIndex');
Route::get('logout', 'UserController@getLogout');
Route::get('login', 'UserController@getLogout');

Route::group(array('before' => 'administrador'), function(){
    Route::get('users/listado', 'UserController@getListado');
    Route::get('users/editar', 'UserController@getEditar');
    Route::post('users/editar', 'UserController@postEditar');
});

Route::group(array('before' => 'auth'), function() {
    Route::controller('users', 'UserController');
});
