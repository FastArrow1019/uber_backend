<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/auth/login', function () {
    return view('auth/login');
});

Route::any('logout', 'SearchController@logout')->name('logout');
Route::get('login', 'Auth\AuthController@auth')->name('login');
Route::post('reset', 'Auth\AuthController@password_request')->name('password.request');
Route::post('register', 'Auth\AuthController@show')->name('register.show');
Route::post('register/{id}', 'Auth\AuthController@create')->name('register.create');
Route::group(['middleware' => 'auth'], function() {
	Route::get('/', function () {
	    return view('auth.maindash');
	});
    Route::any('dashboard', 'SearchController@dashboard')->name('dashboard');
    Route::any('maindash', 'SearchController@maindash')->name('maindash');
    Route::any('adminmanager', 'SearchController@adminmanager')->name('adminmanager');
    Route::any('driversmanage', 'SearchController@driversmanage')->name('driversmanage');
    Route::any('ridersmanage', 'SearchController@ridersmanage')->name('ridersmanage');
    Route::get('/getUsers/{id}','SearchController@getUsers')->name('/getUsers/{id}');
    Route::get('/getUser_data/{id}','SearchController@getUser_data')->name('/getUser_data/{id}');
    Route::post('update','SearchController@update')->name('update');
    Route::post('userupdate','SearchController@userupdate')->name('userupdate');
    Route::any('/delete/{id}','SearchController@delete')->name('/delete/{id}');
	Route::get('/search', array('as' => '/search','uses' => 'SearchController@getdata'));
    Route::get('users', 'App\Http\Controllers\UsersManagementController@index')->name('users');
    Route::post('users', 'App\Http\Controllers\UsersManagementController@store')->name('users.store');
    Route::get('users/create', 'App\Http\Controllers\UsersManagementController@create')->name('users.create');
    Route::get('users/{user}', 'App\Http\Controllers\UsersManagementController@show')->name('users.show');
    Route::get('users/{destroy}', 'App\Http\Controllers\UsersManagementController@destroy')->name('users.destroy');
    Route::get('users/{update}', 'App\Http\Controllers\UsersManagementController@update')->name('users.update');
    Route::get('users/{user}/edit', 'App\Http\Controllers\UsersManagementController@edit')->name('users.edit');
    
    Route::get('/getDrivers/{id}','SearchController@getDrivers')->name('/getDrivers/{id}');
    Route::post('admindriverupdate','SearchController@admindriverupdate')->name('admindriverupdate');
    Route::get('/getRiders/{id}','SearchController@getRiders')->name('/getRiders/{id}');
    Route::post('adminriderupdate','SearchController@adminriderupdate')->name('adminriderupdate');
});

Route::any('signup', 'Auth\AuthController@signup')->name('signup');
Route::any('signin', 'Auth\AuthController@signin')->name('signin');
Route::any('signupcontrol', 'Auth\AuthController@signupcontrol')->name('signupcontrol');
Route::any('signincontrol', 'Auth\AuthController@signincontrol')->name('signincontrol');






//API

Route::any('driversignup', 'IonicapiController@driverregister')->name('driversignup');
Route::any('driversignin', 'IonicapiController@driversignin')->name('driversignin');
Route::any('driveruploadprofile', 'IonicapiController@driveruploadprofile')->name('driveruploadprofile');
Route::any('driverlogout', 'IonicapiController@driverlogout')->name('driverlogout');
Route::any('driverupdate', 'IonicapiController@driverupdate')->name('driverupdate');

//  RIDER API
Route::any('ridersignup', 'IonicapiController@riderregister')->name('ridersignup');

Route::any('ridersignin', 'IonicapiController@ridersignin')->name('ridersignin');
Route::any('rideruploadprofile', 'IonicapiController@rideruploadprofile')->name('rideruploadprofile');
Route::any('riderlogout', 'IonicapiController@riderlogout')->name('riderlogout');
Route::any('riderupdate', 'IonicapiController@riderupdate')->name('riderupdate');

Route::any('getriderLocation', 'IonicapiController@getriderLocation')->name('getriderLocation');
Route::any('getdriver', 'IonicapiController@getdriver')->name('getdriver');

Route::any('stripe', 'IonicapiController@payWithStripe')->name('stripe');
Route::post('stripe_pay', 'IonicapiController@postPaymentWithStripe')->name('stripe_pay');

Route::any('createstripe', 'IonicapiController@createstripe')->name('createstripe');
Route::any('chargestripe', 'IonicapiController@chargestripe')->name('chargestripe');
Route::post('cancelbooking', 'IonicapiController@cancelbooking')->name('cancelbooking');
Route::any('payoutstripe', 'IonicapiController@payoutstripe')->name('payoutstripe');
Route::any('createstripeaccount', 'IonicapiController@createstripeaccount')->name('createstripeaccount');
Route::any('checkstatus', 'IonicapiController@checkstatus')->name('checkstatus');

//Driver API
Route::any('authstatuschang', 'IonicapiController@authstatuschang')->name('authstatuschang');
Route::any('acceptrequest', 'IonicapiController@acceptrequest')->name('acceptrequest');
Route::any('getorderdata', 'IonicapiController@getorderdata')->name('getorderdata');
Route::any('stripepaydriver', 'IonicapiController@stripepaydriver')->name('stripepaydriver');
Route::any('completeride', 'IonicapiController@completeride')->name('completeride');
