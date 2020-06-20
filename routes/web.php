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

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => ['auth','can:user_higher']], function () {
    Route::get('task/create', 'TaskController@add');
    Route::post('task/create', 'TaskController@create');
    Route::get('task', 'TaskController@index');
    Route::get('task/edit','TaskController@edit');
    Route::post('task/edit','TaskController@update');
    
});

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
