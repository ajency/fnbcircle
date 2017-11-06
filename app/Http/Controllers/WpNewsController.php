<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Ajency\User\Ajency\userauth\UserAuth;
 

class WpNewsController extends Controller
{
    public function getLaravelHeaderForWp()
    {  
        return view('wpnews.wp-header');
    }

    public function getLaravelFooterForWp()
    {


		return view('wpnews.wp-footer');
    }

    public function getLaravelLoggedInUser(){
    	if (Auth::check()) {
    		return Auth::user()->username;
    	}
    	else{
    		return false;
    	}
    }



}
