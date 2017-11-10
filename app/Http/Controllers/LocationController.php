<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cookie;

class LocationController extends Controller
{
    public function location($state){
    	session(['user_location' => $state]);
    	$cookie = cookie('user_state', $state, 45000);
 		 
    	$header_type = "home-header";
    	return response(view('welcome', compact('header_type')))->cookie($cookie);
    	 
    }
}
