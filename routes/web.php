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
Route::get('{path}', 'HomeController@index')->where('all', '^(?!api).*$');

Route::post('/api/generate-token', 'ApiTokenController@generateToken');
Route::group(['middleware' => 'auth'], function () {
	Route::get('api/get-token', [
      'uses' => "ApiTokenController@getToken",
      'as' => "getToken"
    ]);

    Route::get('/logout', [
      'uses' => "ApiTokenController@logout",
      'as' => "logout"
    ]);
});

Route::group(['middleware' => 'check-token'], function () {
	Route::group(["prefix" => "api"], function(){
    Route::group(["prefix" => "destination"], function(){

      Route::get('/datatable', [
        'uses' => "apiController@datatableDestination",
        'as' => "datatableDestination"
      ]);

      Route::post('/save', [
        'uses' => "apiController@saveDestination",
        'as' => "saveDestination"
      ]);

      Route::delete('/delete', [
        'uses' => "apiController@deleteDestination",
        'as' => "deleteDestination"
      ]);

    });

    Route::group(["prefix" => "group-menu"], function(){

      Route::get('/datatable', [
        'uses' => "apiController@datatableGroupMenu",
        'as' => "datatableGroupMenu"
      ]);

      Route::post('/save', [
        'uses' => "apiController@saveGroupMenu",
        'as' => "saveGroupMenu"
      ]);

      Route::delete('/delete', [
        'uses' => "apiController@deleteGroupMenu",
        'as' => "deleteGroupMenu"
      ]);

    });

    Route::group(["prefix" => "menu-list"], function(){

      Route::get('/datatable', [
        'uses' => "apiController@datatableMenuList",
        'as' => "datatableMenuList"
      ]);

      Route::post('/save', [
        'uses' => "apiController@saveMenuList",
        'as' => "saveMenuList"
      ]);

      Route::delete('/delete', [
        'uses' => "apiController@deleteMenuList",
        'as' => "deleteMenuList"
      ]);

    });

    Route::group(["prefix" => "privilege"], function(){

      Route::get('/get-data', [
        'uses' => "apiController@getDataPrivilege",
        'as' => "getDataPrivilege"
      ]);

      Route::post('/save', [
        'uses' => "apiController@savePrivilege",
        'as' => "savePrivilege"
      ]);

      Route::delete('/delete', [
        'uses' => "apiController@deletePrivilege",
        'as' => "deletePrivilege"
      ]);

    });

    Route::group(["prefix" => "role"], function(){

      Route::get('/datatable', [
        'uses' => "apiController@datatableRole",
        'as' => "datatableRole"
      ]);

      Route::post('/change-status', [
        'uses' => "apiController@chageStatusRole",
        'as' => "chageStatusRole"
      ]);

      Route::post('/save', [
        'uses' => "apiController@saveRole",
        'as' => "saveRole"
      ]);

      Route::delete('/delete', [
        'uses' => "apiController@deleteRole",
        'as' => "deleteRole"
      ]);

    });
	});
});


// Route::get('/api/destination/datatable', 'apiController@datatableDestination');
