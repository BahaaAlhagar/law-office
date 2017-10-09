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

route::get('contract/{type?}', 'ContractController@index');

route::get('/contracts/{contract}/restore', 'ContractController@restore');

route::resource('contracts', 'ContractController', ['except' => ['create', 'edit']]);

route::get('issue/{type?}', 'IssueController@index');

route::get('/issues/{issue}/restore', 'IssueController@restore');

route::resource('issues', 'IssueController', ['except' => ['create', 'edit']]);

route::get('todo/{completed?}', 'TodoController@index');

route::resource('todos', 'TodoController', ['except' => ['create', 'edit', 'show']]);

route::resource('files', 'FileController', ['only' => ['update', 'delete']]);

route::get('personfiles/{person}', 'PersonController@filesIndex');

route::post('personfiles//{person}', 'PersonController@storeFile');