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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

route::get('/filtered-ppl/{filter?}', 'PersonController@index');

route::get('/people/{person}/restore', 'PersonController@restore');

route::resource('people', 'PersonController', ['except' => ['create', 'edit']]);
