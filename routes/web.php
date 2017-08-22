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

// Route::get('/add_listing', function(){
//     return view('business-info');
// });
Route::post('/listing','ListingController@store');
Route::post('/duplicates','ListingController@findDuplicates');
Route::post('/contact_save','ListingController@saveContact');
Route::post('/create_OTP','ListingController@createOTP');
Route::post('/validate_OTP','ListingController@validateOTP');
Route::post('/get_areas','ListingController@getAreas');

Route::post('/get_categories','ListingController@getCategories');
Route::get('/get_brands','ListingController@getBrands');

// Route::get('/business-categories/{reference}/edit', 'ListingController@categories');

Route::get('/business-location', function(){
    return view('location');
});

Route::get('/business-details', function(){
    return view('business-details');
});

Route::get('/business-photos', function(){
    return view('photos');
});

Route::get('/business-premium', function(){
    return view('premium');
});

Route::post('/get-map-key', 'CommonController@mapKey');
Route::post('/slugify', 'CommonController@slugifyCitiesAreas');