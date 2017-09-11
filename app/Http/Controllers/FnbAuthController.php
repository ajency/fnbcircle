<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests;
use Socialite;
use App\User;

use Config;
use Illuminate\Support\Facades\Session;

use Symfony\Component\Console\Output\ConsoleOutput;

class FnbAuthController extends Controller {
    public function activateUser($user, $type) {
        if ($type == 'website') {
            if ($user->status == 'active') {
                auth()->login($user); // Authenticate using User Object
                return redirect('/');
            } else if ($user->status == 'inactive') {
                return redirect('/?login=true&message=email_confirm');
            } else if ($user->status == 'suspended') {
                return redirect('/?login=true&message=account_suspended');
            }
        }
    }

    public function rerouteUser($data, $type) { // function (<User Data>, <Response Type for - Website / API>) -> This reroute function will redirect 'Post' Login
        $service = new SocialAccountService();

        $arraySocial = $service->getOrCreateUser($data); // Create User Details
        $user = $arraySocial[0]; // Get User object

        if ($type == "website") { // It's Website request
            if ($arraySocial[1] == "present" || $arraySocial[1] == "exist") { // If Account (Exist or Created) & Verified then,
                return $this->activateUser($user, "website"); // Pass User Object
            } else { // Same Email but different Source
                if ($arraySocial[1] == "different") { // If 'account' exists but 'Different Source', then 'Reject'
                    return redirect('/?login=true&message=is_' . $user->signup_source . '_account');
                } else {
                    return redirect('/?login=true');
                }
            }
        } else { // It's API request
            if ($arraySocial[1] == "present") { // If Account is created & Verified
                return response()->json(array("url" => "/", "message" => 'created_account', "status" => 201, "data" => $data)); // Account created - HTTP_STATUS: Created
            } else if ($arraySocial[1] == "exist") { // If Account exists & is Verified
                return response()->json(array("url" => "/", "message" => 'verified', "status" => 200, "data" => $data)); // Account verified - HTTP_STATUS: Success
            } else {
                if ($arraySocial[1] == "different") { // If 'account' exists but 'Different Source', then 'Reject'
                    return response()->json(array("url" => "/", "message" => 'is_' . $user->signup_source . '_account', "status" => 409)); // Account with this Email / Credential already exist - HTTP_STATUS: Conflict
                } else {
                    return response()->json(array("url" => "/", "message" => '', "status" => 400)); // Invalid Account - HTTP_STATUS: Bad Request
                }
            }
        }
    }
}
