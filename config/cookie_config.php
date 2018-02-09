<?php
	/**
	* This config is used to configure the cookie
	*/
	return [
		"unguarded_cookies" => [
			/* The cookie keys defined below will not be encrypted, i.e. those values will be visible on Client browser. Refer "app\Http\MiddlewareEncryptCookies.php" */
			"user_id",
	    	"user_type",
	    	"mobile_otp",
	    	"is_logged_in",
	    	"is_verified",
	    	"enquiry_modal_first_time_value",
	    	"enquiry_modal_first_time_unit",
	    	"enquiry_modal_display_count"
		],
		"expires_in" => 10080, // 7 days //120, // 2 hours
		'user_state_expiry' => 45000, // 31 days
		"app_url" => env("APP_URL", "http://fnbcircle.com"),
	];