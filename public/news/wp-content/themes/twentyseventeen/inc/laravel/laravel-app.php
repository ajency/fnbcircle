<?php 
	require '../../bootstrap/autoload.php';
	$app = require_once '../../bootstrap/app.php';

	$app->make('Illuminate\Contracts\Http\Kernel')
	    ->handle(Illuminate\Http\Request::capture());

	// An instance of the Laravel app should be now at your fingertip ;-)

	

	$isAuthorized = Auth::user();

	echo "<pre>LARAVEL AUTH CHECK <br/>";
	print_r( Cookie::get('user_state') );
	print_r($isAuthorized );

 