<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Helper;
use Illuminate\Support\Facades\Cookie;

class CookieController extends Controller {
	/**
	* This function is used to set a Cookie to that browser
	* Default values are assigned by Laravel, but offers user to configure the Cookie
	*/
    public function set($key, $value, $other_params = [], $is_encrypted = true) {
    	if(sizeof($other_params) > 0) {
    		if(env('APP_URL')) { // If not NULL
    			// Cookie::queue($key, $value, isset($other_params['expires_in']) ? $other_params['expires_in'] : config('session.lifetime'), isset($other_params['path']) ? $other_params['path'] : '/', isset($other_params['domain']) ? $other_params['domain'] : explode('://', config('cookie_config.app_url'))[1], '', isset($other_params['http_only']) ? $other_params['http_only'] : true);
    			Cookie::queue($key, $value, isset($other_params['expires_in']) ? $other_params['expires_in'] : config('session.lifetime'));
    		} else {
    			Cookie::queue($key, $value, isset($other_params['expires_in']) ? $other_params['expires_in'] : config('session.lifetime'));
    		}
    	} else {
    		Cookie::queue($key, $value);
    	}
    }

    /**
    * This function is used to get the Cookie using a KEY
    */
    public function get($key) {
    	if(strlen($key) > 0) {
    		return Cookie::get($key);
    	} else {
    		return null;
    	}
    }

    /**
    * This function is used to SET the default cookie values that will be needed in Today's website flow
    */
    public function generateDefaults() {
    	$status = 'success';
    	try {
	    	$other_params = ["expires_in" => config('cookie_config.expires_in'), "path" => "/", "domain" => explode('://', config('cookie_config.app_url'))[1], "http_only" => false];
	    	$this->set('user_id', Auth::guest() ? '0' : Auth::user()->id, $other_params);
	    	$this->set('user_type', Auth::guest() ? '-' : 'user', $other_params);
	    	$this->set('is_logged_in', Auth::guest() ? 'false' : 'true', $other_params);
	    	$this->set('is_verified', Auth::guest() ? 'false' : 'true', $other_params);
	    } catch(Exception $e) {
	    	$status = 'failed';
	    }

	    //dd($status);

	    return $status;
    }
}
