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
Route::post('/api/generate-token', 'ApiTokenController@generateToken');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('{path}', 'HomeController@index')->where('all', '^(?!api).*$');

Route::group(['middleware' => 'check-token'], function () {
	Route::group(["prefix" => "api"], function(){
	    Route::get('/destination/datatable', [
	      'uses' => "apiController@datatableDestination",
	      'as' => "datatableDestination"
	    ]);

	    Route::get('/logout', [
	      'uses' => "ApiTokenController@logout",
	      'as' => "logout"
	    ]);
	});
});


// Route::get('/api/destination/datatable', 'apiController@datatableDestination');
