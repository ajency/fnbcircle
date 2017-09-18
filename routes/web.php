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




Route::get('admin-dashboard/config/categories','AdminConfigurationController@categoriesView');
Route::post('/list-categories','AdminConfigurationController@categConfigList');
Route::post('/save-category','AdminConfigurationController@saveCategory');
Route::post('/get-branches','AdminConfigurationController@getBranches');
Route::post('/check-category-status','AdminConfigurationController@checkCategStatus');

Route::post('/check-location-status','AdminConfigurationController@checkLocStatus');

Route::post('/listing','ListingController@store');
Route::post('/duplicates','ListingController@findDuplicates');
Route::post('/contact_save','ListingController@saveContact');
Route::post('/create_OTP','ListingController@createOTP');
Route::post('/validate_OTP','ListingController@validateOTP');
Route::post('/get_areas','ListingController@getAreas');
Route::post('/get_categories','ListingController@getCategories');
Route::get('/get_brands','ListingController@getBrands');

Route::get('admin-dashboard/config/locations','AdminConfigurationController@locationView');
Route::post('/has_listing','AdminConfigurationController@hasListing');
Route::post('/get-cities','AdminConfigurationController@getCities');
Route::post('/associated_listing','AdminConfigurationController@getAssociatedListings');
Route::post('/save-location','AdminConfigurationController@saveLocationData');
Route::post('/view-location','AdminConfigurationController@listLocationConfig');
Route::post('/has_areas','AdminConfigurationController@hasPublishedAreas');

Route::get('/business-premium', function(){
    return view('premium');
});

Route::post('/get-map-key', 'CommonController@mapKey');
Route::post('/slugify', 'CommonController@slugifyCitiesAreas');


Route::get('admin-dashboard/moderation/listing-approval','AdminModerationController@listingApproval');
Route::post('admin/moderation/set-bulk-status','AdminModerationController@setStatus');


Route::post('/all-listing','AdminModerationController@displayListingsDum');







Route::group( ['middleware' => ['auth']], function() { 
	/**Jobs**/
	Route::resource( 'jobs', 'JobController' );
	Route::get('/jobs/{reference_id}/submit-for-review','JobController@submitForReview');
	Route::get('/jobs/{reference_id}/{step?}','JobController@edit');
	
	Route::get('/get-keywords','JobController@getKeywords');
	

	/**Users**/

	Route::post('/user/verify-contact-details','UserController@verifyContactDetails');
	Route::post('/user/delete-contact-details','UserController@deleteContactDetails');
});
