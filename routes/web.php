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


Auth::routes();



Route::get('/home', 'HomeController@index')->name('home');
Route::redirect('/welcome', '/');


// group for application controllers
route::group(['middleware' => ['auth', 'admin']], function(){

// change password
Route::view('change_password', 'user.changePassword');
Route::post('change_password', 'Auth\UpdatePasswordController@update');


// office services starts here

Route::get('meetings/list/{start?}/{end?}', 'MeetingController@listMeetings')->name('meetings.list');

route::get('records', 'OfficeController@records')->name('office.records');

route::get('meetings/late', 'OfficeController@lateMeetings')->name('office.late');

route::get('missingdata', 'OfficeController@missingData')->name('office.missingData');

route::get('expiration', 'OfficeController@expiration')->name('office.expiration');

Route::get('/', 'OfficeController@main');

route::get('search', 'OfficeController@search');

route::get('backup', 'OfficeController@databaseBackup')->name('office.backup');

// office services end




// person routes
route::get('/filtered-ppl/{filter?}', 'PersonController@index');

route::get('/people/{person}/restore', 'PersonController@restore');

route::post('people/{person}/files', 'PersonController@storeFile');

route::get('people/{person}/files', 'PersonController@filesIndex');

route::get('people/{person}/issues', 'PersonController@issues')->name('person.issues');

route::resource('people', 'PersonController', ['except' => ['create', 'edit']]);
// people routes end


// contract routes
route::get('contract/{type?}', 'ContractController@index');

route::get('/contracts/{contract}/restore', 'ContractController@restore');

route::resource('contracts', 'ContractController', ['except' => ['create', 'edit']]);
// end of contract routes



// issues routes



route::post('/issues/{issue}/openents', 'IssueController@attachOpenent');

route::patch('/issues/{issue}/openents', 'IssueController@updateOpenent');

route::delete('/issues/{issue}/openents/{openent}', 'IssueController@deleteOpenent');



route::post('issues/{issue}', 'issueController@storeFile');

route::get('issues/{issue}/files', 'issueController@filesIndex');

route::resource('files', 'FileController', ['only' => ['update', 'destroy']]);



route::get('issue/{type?}', 'IssueController@index');

route::get('/issues/{issue}/restore', 'IssueController@restore');



route::post('meetings/{meeting}/judgements', 'JudgementController@store');

route::resource('judgements', 'JudgementController', ['only' => ['update', 'destroy']]);



route::resource('issues/{issue}/meetings', 'MeetingController', ['only' => ['index', 'store']]);

route::resource('meetings', 'MeetingController', ['only' => ['update', 'destroy']]);


route::resource('issues', 'IssueController', ['except' => ['create', 'edit']]);
// end of issues routes


// todos routes
route::get('todo/{completed?}', 'TodoController@index');

route::resource('todos', 'TodoController', ['except' => ['create', 'edit', 'show']]);
// end of todos

});