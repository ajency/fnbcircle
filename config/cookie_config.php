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
	    	"is_logged_in"
		],
		"expires_in" => 10080, //120,

	];