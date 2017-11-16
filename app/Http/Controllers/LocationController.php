<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cookie;
use App\City;

class LocationController extends Controller
{
    public function location($state){
    	$stateExist = City::where('slug',$state)->first();

    	if(!empty($stateExist)){
	    	session(['user_location' => $state]);
	    	$cookie = cookie('user_state', $state, config('constants.user_state_cookie_expiry'));
	 		 
	    	$header_type = "home-header";
	    	return response(view('welcome', compact('header_type')))->cookie($cookie);
    	}
    	else
    		return redirect(url('/')); 
    	 
    }
}
