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
	    	"is_verified"
		],
		"expires_in" => 10080, // 7 days //120, // 2 hours
		'user_state_expiry' => 45000, // 31 days
		"app_url" => env("APP_URL", "http://fnbcircle.com"),
	];