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
	$header_type = "home-header";
    return view('welcome', compact('header_type'));
});
 
 
// Route::get('/test','TestController@index');
// Forgot Password
Route::post('/forgot-password', 'Auth\ForgotPasswordController@validatingEmail');
 

/****
api
****/
Route::group(['prefix' => 'api'], function() {
	Route::post('/get-view-data', 'ListViewController@getListData');
	Route::post('/search-category', 'ListViewController@searchCategory');
	Route::post('/search-business', 'ListViewController@searchBusiness');
});

// Route::get('/test','TestController@index');
// Forgot Password
Route::post('/forgot-password', 'Auth\ForgotPasswordController@validatingEmail');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/get-updates','UpdatesController@getUpdates');


/*/*/
Route::get('/test-code', function () {
    return view('errors.error');
});

/*/*/ 
// 
/******
listing
*******/

Route::post('/get_categories','ListingController@getCategories');
Route::get('/{type}/get-category-types','CommonController@getCategories');
Route::get('/get_brands','ListingController@getBrands');
Route::get('/get-single-post','UpdatesController@getPost');
//view listings
Route::post('/duplicates','ListingController@findDuplicates');
Route::post('/get_areas','CommonController@getAreas');
Route::post('/get-map-key', 'CommonController@mapKey');
Route::post('/slugify', 'CommonController@slugifyCitiesAreas');


Route::group( ['middleware' => ['auth','fnbpermission']], function() { 
	//add listing
	Route::get('listing/create','ListingController@create');
	//edit listing
	Route::get('/listing/{reference}/edit/{step?}','ListingController@edit');


	//manage categories 
	Route::post('/list-categories','AdminConfigurationController@categConfigList');
	Route::post('/save-category','AdminConfigurationController@saveCategory');
	Route::post('/get-branches','AdminConfigurationController@getBranches');
	Route::post('/check-category-status','AdminConfigurationController@checkCategStatus');

	//manage locations
	Route::post('/check-location-status','AdminConfigurationController@checkLocStatus');
	Route::post('/has_listing','AdminConfigurationController@hasListing');//manage-categories manage-locations
	Route::post('/get-cities','AdminConfigurationController@getCities');
	Route::post('/associated_listing','AdminConfigurationController@getAssociatedListings');//manage-categories manage-locations
	Route::post('/save-location','AdminConfigurationController@saveLocationData');// manage-locations
	Route::post('/view-location','AdminConfigurationController@listLocationConfig');//manage-locations
	Route::post('/has_areas','AdminConfigurationController@hasPublishedAreas');//mmanage-locations

	//managelistings
	
	Route::post('admin/moderation/set-bulk-status','AdminModerationController@setStatus');
	Route::post('/all-listing','AdminModerationController@displayListingsDum');


});


Route::post('/change-notification-recipients','AdminModerationController@setNotificationDefault');

Route::group( ['middleware' => ['auth']], function() { 
	Route::post('/create_OTP','ListingController@createOTP');
	Route::post('/validate_OTP','ListingController@validateOTP');
	Route::post('/listing/review','ListingController@submitForReview');
	Route::post('/listing/archive','ListingController@archive');
	Route::post('/listing/publish','ListingController@publish');
	Route::post('/listing','ListingController@store');
	Route::post('/contact_save','ListingController@saveContact');
	Route::post('/subscribe-to-premium', 'CommonController@premium' );//edit jobs
	Route::get('/premium/{type}/{reference_id}/cancle-request', 'CommonController@canclePremiumRequest' );//edit jobs
	
	Route::post('/post-update', 'UpdatesController@postUpdate');
	Route::post('/upload-update-photos', 'UpdatesController@uploadPhotos');
	Route::post('/delete-post','UpdatesController@deletePost');

});


/******
JOBS/USERS
*******/

//job single view
Route::get('/job/{slug}','JobController@show');
Route::get('/get-keywords','JobController@getKeywords');
Route::get('/get-job-titles','JobController@getJobTitles');
Route::get('/get-company','JobController@getCompanies');
Route::get('user-confirmation/{token}', 'Auth\RegisterController@userConfirmation');
Route::get('send-confirmation-link', 'Auth\RegisterController@sendConfirmationLink');
Route::get('/job-cron/{type}','JobController@runCron');


/**
logged in users group
permission group
*/
Route::group( ['middleware' => ['auth','fnbpermission']], function() { 
 
	/**Jobs**/
	Route::resource( 'jobs', 'JobController' );
	Route::get('/jobs/{reference_id}/submit-for-review','JobController@submitForReview');
	Route::get('/jobs/{reference_id}/{step?}','JobController@edit');
	Route::get('/jobs/{reference_id}/update-status/{status}','JobController@changeJobStatus');

});

/**
logged in users group
*/
Route::group( ['middleware' => ['auth']], function() { 
	Route::post('/jobs/{reference_id}/applyjob','JobController@applyJob');
	Route::post('/job/{reference_id}/get-job-application','JobController@getJobApplications');
 	Route::post('/user/verify-contact-details','UserController@verifyContactDetails'); // Generate OTP
	Route::post('/user/verify-contact-otp','UserController@verifyContactOtp'); // Validate OTP
	Route::post('/user/delete-contact-details','UserController@deleteContactDetails');


	Route::get('/user/send-job-alerts','JobController@changeSendJobAlertsFlag');
	Route::get('/users/send-alert-for-job/{reference_id}','JobController@sendJobsToUser');
	Route::get('/user/{resume_id}/download-resume','UserController@downloadResume');
 
	Route::post('/user/remove-resume','UserController@removeResume');
 
	Route::get('/profile/{step}/{email?}', 'ProfileController@displayProfile' );
	Route::post('/profile/password-change', 'ProfileController@changePassword');
	Route::post('/profile/number-change', 'ProfileController@changePhone');
 
});





/*************/
  
/* Custom Auth Routes */

Route::get('/logout', 'Auth\LoginController@logout');

Route::group(['namespace' => 'Ajency'], function() {
	Route::get('/redirect/{provider}', 'User\SocialAuthController@urlSocialAuthRedirect');
	Route::get('/callback/{provider}', 'User\SocialAuthController@urlSocialAuthCallback');

	Route::group(['prefix' => 'api'], function () {
		Route::get('/login/{provider}', 'User\SocialAuthController@apiSocialAuth');
		//Route::get('/logout/{provider}', 'User\SocialAuthController@logout');


	});
});


Route::group(['prefix' => 'api'], function() {
	Route::post('/get-listview-data', 'ListViewController@getListViewData');
	Route::post('/search-city', 'ListViewController@searchCity');
	Route::post('/search-category', 'ListViewController@searchCategory');
	Route::post('/search-business', 'ListViewController@searchBusiness');
});







/* Admin dashboard routes */


Route::group(['middleware' => ['auth','fnbpermission'], 'prefix' => 'admin-dashboard'], function () {
	Route::group(['prefix' => 'config'], function() {
		Route::get('categories','AdminConfigurationController@categoriesView');
		Route::get('locations','AdminConfigurationController@locationView');
	});

	Route::get('email-notification', 'AdminModerationController@emailNotification');

	Route::group(['prefix' => 'moderation'], function() {
		Route::get('listing-approval','AdminModerationController@listingApproval');
	});
	
	Route::group(['prefix' => 'users'], function() {
		/* Get Users */
		Route::get('internal-users', 'AdminConfigurationController@internalUserView'); // Get Internal Users
		Route::get('registered-users', 'AdminConfigurationController@registeredUserView');
		Route::post('get-registered-users', 'AdminConfigurationController@getRegisteredUsers');  // Get Registered / External Users
		Route::post('set-user-status', 'AdminConfigurationController@userAccountStatus');  // Get Registered / External Users

		Route::post('get-users', 'AdminConfigurationController@getUserData'); // Get all the User Data

		/* Add / Edit users */
		Route::post('add', 'AdminConfigurationController@addNewUser'); // Add new Users - Internal / External
		Route::post('{username}', 'AdminConfigurationController@editCurrentUser'); // Edit current Users - Internal / External
	});

	//manage jobs
	Route::group(['prefix' => 'jobs'], function() {
		Route::get('manage-jobs','AdminConfigurationController@manageJobs');
		Route::post('get-jobs','AdminConfigurationController@getJobs');
		Route::post('update-job-status','AdminConfigurationController@updateJobStatus');
		Route::post('bulk-update-job-status','AdminConfigurationController@bulkUpdateJobStatus');
	});
	
});
Route::post('/upload-listing-image','ListingController@uploadListingPhotos');
Route::post('/upload-listing-file','ListingController@uploadListingFiles');


 
/**
USER PROFILE
**/
Route::group(['middleware' => ['auth'], 'prefix' => 'customer-dashboard'], function () {
	Route::get('/','UserController@customerdashboard');
	Route::post('/users/update-resume','UserController@uploadResume');
	Route::post('/users/set-job-alert','UserController@setJobAlert');
 
});

 
/* List View of Listing */
Route::group(['prefix' => '{city}'], function() {
	Route::get('/business-listings', 'ListViewController@listView');
	Route::get('/job-listings', 'JobController@jobListing');
	Route::post('/jobs/get-listing-jobs', 'JobController@getListingJobs');
	Route::get('/{listing_slug}', 'ListingViewController@index');
	Route::get('/', 'LocationController@location');
});

 
 
