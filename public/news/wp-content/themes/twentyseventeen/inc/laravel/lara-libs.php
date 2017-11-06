<?php 

/*if(!is_user_logged_in()){

	if(username_exists($username)){

		//login the user 
	}
}
*/


	echo "<pre> PARAG :-";

	$url = LARAVELURL."/wp-get-logged-in-laravel-user";
	$mch = curl_init();
	$headers = array(
		'Content-Type: application/json',
		
	);
	curl_setopt($mch, CURLOPT_URL, $url );
	curl_setopt($mch, CURLOPT_HTTPHEADER, $headers);
	//curl_setopt($mch, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
	curl_setopt($mch, CURLOPT_RETURNTRANSFER, true); // do not echo the result, write it into variable
	curl_setopt($mch, CURLOPT_CUSTOMREQUEST, "GET"); // according to MailChimp API: POST/GET/PATCH/PUT/DELETE
	curl_setopt($mch, CURLOPT_TIMEOUT, 10);
	curl_setopt($mch, CURLOPT_SSL_VERIFYPEER, false); // certificate verification for TLS/SSL connection
 
	
 
	print_r(curl_exec($mch));
?>