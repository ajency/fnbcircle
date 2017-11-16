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
    	elseif($state == 'all'){
	    	session()->forget('user_location');
	    	// $cookie = cookie('user_state', '', config('constants.user_state_cookie_expiry'));
	    	$cookie = \Cookie::forget('user_state');
	 		  
	    	return redirect(url('/'))->withCookie($cookie);
    	}
    	else
    		return redirect(url('/')); 
    	 
    }
}
