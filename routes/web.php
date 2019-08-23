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
Route::group(['middleware' => 'auth'], function () {
  Route::get('group-menu', 'HomeController@index');
  Route::get('privilege', 'HomeController@index');
  Route::get('role', 'HomeController@index');
  Route::get('menu-list', 'HomeController@index');
  Route::get('administrator-user', 'HomeController@index');
  Route::get('agent-user', 'HomeController@index');
  Route::get('destination', 'HomeController@index');
  Route::get('additional', 'HomeController@index');
  Route::get('itinerary', 'HomeController@index');
  Route::get('tour-leader', 'HomeController@index');

  Route::get('/home', 'HomeController@index')->name('home');
  Route::get('itinerary/{path}', 'HomeController@index')->where('all', '^(?!api).*$');
  Route::get('itinerary/{path}/{id}/{dt}', 'HomeController@index')->where('all', '^(?!api).*$');
  Route::get('group-menu', 'HomeController@index');

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
    Route::get('/convert-image-base-64', [
      'uses' => "apiController@convertImageBase64",
      'as' => "convertImageBase64"
    ]);

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

    Route::group(["prefix" => "privilege"], function(){
      Route::get('/datatable', [
        'uses' => "apiController@datatablePrivilege",
        'as' => "datatablePrivilege"
      ]);

      Route::post('/change-status', [
        'uses' => "apiController@chageStatusPrivilege",
        'as' => "chageStatusPrivilege"
      ]);
    });

    Route::group(["prefix" => "administrator-user"], function(){
      Route::get('/datatable', [
        'uses' => "apiController@datatableAdministratorUser",
        'as' => "datatableAdministratorUser"
      ]);

      

      Route::post('/change-status', [
        'uses' => "apiController@chageStatusAdministratorUser",
        'as' => "chageStatusAdministratorUser"
      ]);

      Route::post('/save', [
        'uses' => "apiController@saveAdministratorUser",
        'as' => "saveAdministratorUser"
      ]);

      Route::delete('/delete', [
        'uses' => "apiController@deleteAdministratorUser",
        'as' => "deleteAdministratorUser"
      ]);
    });

    Route::group(["prefix" => "agent-user"], function(){
      Route::get('/datatable', [
        'uses' => "apiController@datatableAgentUser",
        'as' => "datatableAgentUser"
      ]);

      Route::post('/change-status', [
        'uses' => "apiController@chageStatusAgentUser",
        'as' => "chageStatusAgentUser"
      ]);

      Route::post('/save', [
        'uses' => "apiController@saveAgentUser",
        'as' => "saveAgentUser"
      ]);

      Route::delete('/delete', [
        'uses' => "apiController@deleteAgentUser",
        'as' => "deleteAgentUser"
      ]);
    });

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

    Route::group(["prefix" => "additional"], function(){
      Route::get('/datatable', [
        'uses' => "apiController@datatableAdditional",
        'as' => "datatableAdditional"
      ]);

      Route::post('/change-status', [
        'uses' => "apiController@chageStatusAdditional",
        'as' => "chageStatusAdditional"
      ]);

      Route::post('/save', [
        'uses' => "apiController@saveAdditional",
        'as' => "saveAdditional"
      ]);

      Route::delete('/delete', [
        'uses' => "apiController@deleteAdditional",
        'as' => "deleteAdditional"
      ]);
    });

    Route::group(["prefix" => "itinerary"], function(){
      Route::get('/datatable', [
        'uses' => "apiController@datatableItinerary",
        'as' => "datatableItinerary"
      ]);

      Route::get('/create', [
        'uses' => "apiController@createItinerary",
        'as' => "createItinerary"
      ]);

      Route::post('/change-status', [
        'uses' => "apiController@chageStatusItinerary",
        'as' => "chageStatusItinerary"
      ]);

      Route::get('/menu-list', [
        'uses' => "apiController@menuListItinerary",
        'as' => "menuListItinerary"
      ]);

      Route::post('/save', [
        'uses' => "apiController@saveItinerary",
        'as' => "saveItinerary"
      ]);

      Route::delete('/delete', [
        'uses' => "apiController@deleteItinerary",
        'as' => "deleteItinerary"
      ]);
    });

    Route::group(["prefix" => "tour-leader"], function(){
      Route::get('/datatable', [
        'uses' => "apiController@datatableTourLeader",
        'as' => "datatableTourLeader"
      ]);

      Route::get('/create', [
        'uses' => "apiController@createTourLeader",
        'as' => "createTourLeader"
      ]);

      Route::post('/change-status', [
        'uses' => "apiController@chageStatusTourLeader",
        'as' => "chageStatusTourLeader"
      ]);

      Route::get('/menu-list', [
        'uses' => "apiController@menuListTourLeader",
        'as' => "menuListTourLeader"
      ]);

      Route::post('/save', [
        'uses' => "apiController@saveTourLeader",
        'as' => "saveTourLeader"
      ]);

      Route::delete('/delete', [
        'uses' => "apiController@deleteTourLeader",
        'as' => "deleteTourLeader"
      ]);
    });
	});
});


// Route::get('/api/destination/datatable', 'apiController@datatableDestination');
