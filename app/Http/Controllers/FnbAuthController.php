<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests;
use Socialite;
use App\User;

use Ajency\User\Ajency\socialaccount\SocialAccountService;

use Config;
use Illuminate\Support\Facades\Session;

use Symfony\Component\Console\Output\ConsoleOutput;

class FnbAuthController extends Controller {
    public function activateUser($user, $required_field_status, $type, $redirect_url = '') {
    	if ($type == 'website') {
            if ($user->status == 'active') {
                auth()->login($user); // Authenticate using User Object
                $user->last_login = date('Y-m-d H:i:s');
                $user->save();

                if($user->type != "internal") { // If not internal user, then get his/her city value from profile
                    //set user state session
                    if($user->getUserDetails->userCity != null)$userState = $user->getUserDetails->userCity->slug;
                    else getSinglePopularCity()->slug;
                    session(['user_location' => $userState]);
                    $cookie = cookie('user_state', $userState, config('cookie_config.user_state_expiry'));
                } else { // If internal User, then get a City 
                    $userState = getSinglePopularCity()->slug;
                    session(['user_location' => $userState]);
                    $cookie = cookie('user_state', $userState, config('cookie_config.user_state_expiry'));
                    $redirect_url = "/admin-dashboard/moderation/listing-approval";
                }

             //    if(!$redirect_url) { // If redirect URL is Empty
	            //     if ($user->hasPermissionTo('add_internal_user')) {
	            //     	$redirect_url = "/admin-dashboard/users/internal-users";
	            //     } else {
	            //     	$redirect_url = "/listing/create";
	            //     }


	            //     /*if(!$required_field_status["filled_required"]) {
	            //     	$redirect_url .= "/?required_field=true";
	            //     }*/ 
	            // }


                if($redirect_url == "")
                    $redirect_url = '/';

                $redirect_url = isFirstTimeLoginRedirect($redirect_url);

            	return redirect($redirect_url)->withCookie($cookie);
            } else if ($user->status == 'inactive') {
                return redirect('/?login=true&message=email_confirm');
            } else if ($user->status == 'suspended') {
                return redirect('/?login=true&message=account_suspended');
            }
        } else {
        	if ($user->status == 'active') {
        		if(!$redirect_url) { // If redirect URL is Empty
	                if ($user->hasPermissionTo('add_internal_user')) {
	                	$redirect_url = "/admin-dashboard/users/internal-users";
	                } else {
	                	$redirect_url = "/listing/create";
	                }

	                /*if(!$required_field_status["filled_required"]) {
	                	$redirect_url .= "/?required_field=true";
	                }*/
	            }
            } else if ($user->status == 'inactive') {
                $redirect_url = '/?login=true&message=email_confirm';
            } else if ($user->status == 'suspended') {
                $redirect_url = '/?login=true&message=account_suspended';
            }

            return $redirect_url;
        }
    }

    public function rerouteUser($data, $type) { // function (<User Data>, <Response Type for - Website / API>) -> This reroute function will redirect 'Post' Login
        $service = new SocialAccountService();
        	
        $next_url = isset($data["next_url"]) ? $data["next_url"] : '';

        if ($type == "website") { // It's Website request
            if ($data["status"] == "success") { // If Account (Exist or Created) & Verified then,
                return $this->activateUser($data["user"], $data["filled_required_status"], "website", $next_url); // Pass User Object
            } else { // Same Email but different Source
                if ($data["status"] == "error") { // If 'account' exists but 'Different Source', then 'Reject'
                    return redirect('/?login=true&message=is_' . $data["user"]->signup_source . '_account');
                } else {
                    return redirect('/?login=true');
                }
            }
        } else { // It's API request
        	$redirect_url = $this->activateUser($data["user"], $data["filled_required_status"], "api", $next_url); // Pass User Object

            if ($data["status"] == "success") { // If Account is created & Verified
            	return response()->json(array("redirect_url" => $redirect_url, "message" => 'success', "status" => 200)); // Account created / found successfully
            } else {
                if ($data["status"] == "error") { // If 'account' exists but 'Different Source', then 'Reject'
                    return response()->json(array("redirect_url" => '/', "message" => 'is_' . $data["user"]->signup_source . '_account', "status" => 409)); // Account with this Email / Credential already exist - HTTP_STATUS: Conflict
                } else {
                    return response()->json(array("redirect_url" => "/", "message" => '', "status" => 400)); // Invalid Account - HTTP_STATUS: Bad Request
                }
            }
        }
    }
}
