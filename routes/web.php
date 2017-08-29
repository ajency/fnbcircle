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

// Route::resource('/listing', 'ListingController');
Route::get('/listing/{reference}/edit/{step?}','ListingController@edit');
Route::get('listing/create','ListingController@create');


Route::get('admin-dashboard/config/locations','AdminConfigurationController@locationView');

Route::post('/listing','ListingController@store');
Route::post('/duplicates','ListingController@findDuplicates');
Route::post('/contact_save','ListingController@saveContact');
Route::post('/create_OTP','ListingController@createOTP');
Route::post('/validate_OTP','ListingController@validateOTP');
Route::post('/get_areas','ListingController@getAreas');

Route::post('/get_categories','ListingController@getCategories');
Route::get('/get_brands','ListingController@getBrands');

Route::post('/save-location','AdminConfigurationController@saveLocationData');
Route::post('/view-location','AdminConfigurationController@listLocationConfig');

Route::get('/business-premium', function(){
    return view('premium');
});

Route::post('/get-map-key', 'CommonController@mapKey');
Route::post('/slugify', 'CommonController@slugifyCitiesAreas');