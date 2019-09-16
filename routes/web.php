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


Route::get('/logout', [
      'uses' => "ApiTokenController@logout",
      'as' => "logout"
    ]);

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

  Route::get('{path}', 'HomeController@index')->where('all', '^(?!api).*$');
  Route::get('/home', 'HomeController@index')->name('home');
  Route::get('itinerary/{path}', 'HomeController@index')->where('all', '^(?!api).*$');
  Route::get('itinerary/{path}/{id}', 'HomeController@index')->where('all', '^(?!api).*$');
  Route::get('itinerary/{path}/{id}/{dt}', 'HomeController@index')->where('all', '^(?!api).*$');
  Route::get('booking-list/{path}/{id}', 'HomeController@index')->where('all', '^(?!api).*$');
  Route::get('group-menu', 'HomeController@index');

    Route::get('api/get-token', [
      'uses' => "ApiTokenController@getToken",
      'as' => "getToken"
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
        'uses' => "apiController@changeStatusRole",
        'as' => "changeStatusRole"
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
        'uses' => "apiController@changeStatusPrivilege",
        'as' => "changeStatusPrivilege"
      ]);
    });

    Route::group(["prefix" => "administrator-user"], function(){
      Route::get('/datatable', [
        'uses' => "apiController@datatableAdministratorUser",
        'as' => "datatableAdministratorUser"
      ]);

      

      Route::post('/change-status', [
        'uses' => "apiController@changeStatusAdministratorUser",
        'as' => "changeStatusAdministratorUser"
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
        'uses' => "apiController@changeStatusAgentUser",
        'as' => "changeStatusAgentUser"
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
        'uses' => "apiController@changeStatusAdditional",
        'as' => "changeStatusAdditional"
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
        'uses' => "apiController@changeStatusItinerary",
        'as' => "changeStatusItinerary"
      ]);

      Route::post('/change-status-hot-deal', [
        'uses' => "apiController@changeStatusHotDeal",
        'as' => "changeStatusHotDeal"
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

      Route::get('/detail', [
        'uses' => "apiController@detailItinerary",
        'as' => "detailItinerary"
      ]);

      Route::post('/save-detail', [
        'uses' => "apiController@saveDetailItinerary",
        'as' => "saveDetailItinerary"
      ]);

      Route::get('/edit/{id}', [
        'uses' => "apiController@editItinerary",
        'as' => "editItinerary"
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
        'uses' => "apiController@changeStatusTourLeader",
        'as' => "changeStatusTourLeader"
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

    Route::group(["prefix" => "company"], function(){
      Route::get('/datatable', [
        'uses' => "apiController@datatableCompany",
        'as' => "datatableCompany"
      ]);

      Route::get('/create', [
        'uses' => "apiController@createCompany",
        'as' => "createCompany"
      ]);

      Route::post('/change-status', [
        'uses' => "apiController@changeStatusCompany",
        'as' => "changeStatusCompany"
      ]);

      Route::get('/menu-list', [
        'uses' => "apiController@menuListCompany",
        'as' => "menuListCompany"
      ]);

      Route::post('/save', [
        'uses' => "apiController@saveCompany",
        'as' => "saveCompany"
      ]);

      Route::delete('/delete', [
        'uses' => "apiController@deleteCompany",
        'as' => "deleteCompany"
      ]);
    });

    Route::group(["prefix" => "carousel"], function(){
      Route::get('/', [
        'uses' => "apiController@carousel",
        'as' => "carousel"
      ]);

      Route::post('/save', [
        'uses' => "apiController@saveCarousel",
        'as' => "saveCarousel"
      ]);
    });


    Route::group(["prefix" => "booking-list"], function(){
      Route::get('/datatable', [
        'uses' => "apiController@datatableBookingList",
        'as' => "datatableBookingList"
      ]);

      Route::get('/edit', [
        'uses' => "apiController@editBookingList",
        'as' => "editBookingList"
      ]);

      Route::post('/update', [
        'uses' => "apiController@updateBookingList",
        'as' => "updateBookingList"
      ]);

      Route::post('/change-status', [
        'uses' => "apiController@changeStatusBookingList",
        'as' => "changeStatusBookingList"
      ]);
    });
	});
});

header('Access-Control-Allow-Origin:  *');
header('Access-Control-Allow-Methods:  POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers:  Content-Type, X-Auth-Token, Origin, Authorization, x-csrf-token,x-requested-with');



Route::group(['middleware' => 'cors'], function () {
  Route::group(["prefix" => "api"], function(){
    Route::group(["prefix" => "v1"], function(){
      Route::get('/get-data', [
        'uses' => "apiV1Controller@getDataHome",
        'as' => "getDataHome"
      ]);

      Route::get('/get-itinerary-detail/{id}', [
        'uses' => "apiV1Controller@getItineraryDetail",
        'as' => "getItineraryDetail"
      ]);

      Route::get('/get-booking/{id}/{dt}', [
        'uses' => "apiV1Controller@getBooking",
        'as' => "getBooking"
      ]);

      Route::post('/booking/save', [
        'uses' => "apiV1Controller@saveBooking",
        'as' => "saveBooking"
      ]);

      Route::post('/get-booking-list', [
        'uses' => "apiV1Controller@getBookingList",
        'as' => "getBookingList"
      ]);

      Route::post('/get-booking-list/{id}', [
        'uses' => "apiV1Controller@getBookingListDetail",
        'as' => "getBookingListDetail"
      ]);

      Route::get('/get-booking-list/pdf/pax/{id}', [
        'uses' => "apiV1Controller@bookingListPdfPax",
        'as' => "bookingListPdfPax"
      ]);

      Route::get('/get-booking-list/pdf/invoice/{id}', [
        'uses' => "apiV1Controller@bookingListPdfInvoice",
        'as' => "bookingListPdfInvoice"
      ]);

      Route::post('/payment/{id}', [
        'uses' => "apiV1Controller@payment",
        'as' => "payment"
      ]);

      Route::post('/payment/save', [
        'uses' => "apiV1Controller@paymentSave",
        'as' => "paymentSave"
      ]);
    });
  });
});

  


// Route::get('/api/destination/datatable', 'apiController@datatableDestination');
