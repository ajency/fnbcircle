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

Route::resource('/add_listing', 'ListingController');

// Route::get('/add_listing', function(){
//     return view('business-info');
// });

Route::get('/business-categories', function(){
    return view('business-categories');
});

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
