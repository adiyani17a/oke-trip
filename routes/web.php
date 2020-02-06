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
Route::get('tes','apiController@tes');

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
  Route::get('archive', 'HomeController@index');
  Route::get('tour-leader', 'HomeController@index');

  Route::get('{path}', 'HomeController@index')->where('all', '^(?!api).*$');
  Route::get('/home', 'HomeController@index')->name('home');
  Route::get('itinerary/{path}', 'HomeController@index')->where('all', '^(?!api).*$');
  Route::get('itinerary/{path}/{id}', 'HomeController@index')->where('all', '^(?!api).*$');
  Route::get('itinerary/{path}/{id}/{dt}', 'HomeController@index')->where('all', '^(?!api).*$');
  Route::get('booking-list/{path}/{id}', 'HomeController@index')->where('all', '^(?!api).*$');
  Route::get('payment-list/{id}', 'HomeController@index')->where('all', '^(?!api).*$');
  Route::get('group-menu', 'HomeController@index');

    Route::get('api/get-token', [
      'uses' => "ApiTokenController@getToken",
      'as' => "getToken"
    ]);

    
});

Route::group(['middleware' => 'auth'], function () {
  Route::group(["prefix" => "report/income-report"], function(){
    Route::get('/', [
      'uses' => "ReportController@incomeReport",
      'as' => "incomeReport"
    ]);

    Route::get('/datatable-agen', [
      'uses' => "ReportController@datatableAgen",
      'as' => "datatableAgen"
    ]);

    Route::get('/get-data-destination', [
      'uses' => "ReportController@getDataDestination",
      'as' => "getDataDestination"
    ]);
  });
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

      Route::post('/delete', [
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

      Route::post('/delete', [
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

      Route::post('/delete', [
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

      Route::post('/delete', [
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

      Route::post('/delete', [
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

      Route::post('/delete', [
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

      Route::post('/delete', [
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

      Route::post('/delete', [
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

      Route::post('/delete', [
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

      Route::post('/delete', [
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

    Route::group(["prefix" => "archive"], function(){
      Route::get('/datatable', [
        'uses' => "apiController@datatableArchive",
        'as' => "datatableArchive"
      ]);

      Route::post('/delete', [
        'uses' => "apiController@deleteArchive",
        'as' => "deleteArchive"
      ]);
    });

    Route::group(["prefix" => "report/income-report"], function(){
      Route::get('/', [
        'uses' => "ReportController@incomeReport",
        'as' => "incomeReport"
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

    Route::group(["prefix" => "payment-list"], function(){

      Route::get('datatable/{id}', [
        'uses' => "apiController@paymentListDatatable",
        'as' => "paymentListDatatable"
      ]);

      Route::post('/update', [
        'uses' => "apiController@updatePaymentList",
        'as' => "updatePaymentList"
      ]);
    });

    Route::group(["prefix" => "blog"], function(){

      Route::get('datatable', [
        'uses' => "apiController@blogDatatable",
        'as' => "blogDatatable"
      ]);

      Route::post('/save', [
        'uses' => "apiController@saveBlog",
        'as' => "saveBlog"
      ]);

      Route::post('/delete', [
        'uses' => "apiController@deleteBlog",
        'as' => "deleteBlog"
      ]);
    });

    Route::group(["prefix" => "term-condition"], function(){
      Route::get('/', [
        'uses' => "apiController@termCondition",
        'as' => "termCondition"
      ]);

      Route::post('/save', [
        'uses' => "apiController@saveTermCondition",
        'as' => "saveTermCondition"
      ]);
    });

    Route::group(["prefix" => "about"], function(){
      Route::get('/', [
        'uses' => "apiController@about",
        'as' => "about"
      ]);

      Route::post('/save', [
        'uses' => "apiController@saveAbout",
        'as' => "saveAbout"
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

      Route::get('/get-booking-list/pdf/room/{id}', [
        'uses' => "apiV1Controller@bookingListPdfRoom",
        'as' => "bookingListPdfRoom"
      ]);

      Route::get('/get-booking-list/pdf/passport/{id}', [
        'uses' => "apiV1Controller@bookingListPdfPassport",
        'as' => "bookingListPdfPassport"
      ]);

      Route::get('/get-booking-list/pdf/invoice/{id}', [
        'uses' => "apiV1Controller@bookingListPdfInvoice",
        'as' => "bookingListPdfInvoice"
      ]);

      Route::post('/payment/{id}', [
        'uses' => "apiV1Controller@payment",
        'as' => "payment"
      ]);

      Route::post('/payment-itinerary', [
        'uses' => "apiV1Controller@paymentItinerary",
        'as' => "paymentItinerary"
      ]);

      Route::post('/pay/save', [
        'uses' => "apiV1Controller@paymentSave",
        'as' => "paymentSave"
      ]);

      Route::get('/getData', [
        'uses' => "apiV1Controller@getData",
        'as' => "getData"
      ]);

      Route::post('/get-data-itinerary', [
        'uses' => "apiV1Controller@getDataItinerary",
        'as' => "getDataItinerary"
      ]);

      Route::post('/partner', [
        'uses' => "apiV1Controller@getPartner",
        'as' => "getPartner"
      ]);

      Route::post('/get-blog', [
        'uses' => "apiV1Controller@getBlog",
        'as' => "getBlog"
      ]);

      Route::post('/get-blog-data/{id}', [
        'uses' => "apiV1Controller@getBlogData",
        'as' => "getBlogData"
      ]);

      Route::post('/get-about', [
        'uses' => "apiV1Controller@getAbout",
        'as' => "getAbout"
      ]);
      Route::post('/get-term-condition', [
        'uses' => "apiV1Controller@getTermCondition",
        'as' => "getTermCondition"
      ]);
    });
  });
});

  


// Route::get('/api/destination/datatable', 'apiController@datatableDestination');
