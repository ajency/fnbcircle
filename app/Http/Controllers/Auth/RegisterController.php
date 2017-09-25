<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

use Illuminate\Http\Request;
use Symfony\Component\Console\Output\ConsoleOutput;
use App\Http\Controllers\FnbAuthController;

/* Plugin Access Headers */
use Ajency\User\Ajency\socialaccount\SocialAccountService;
use Ajency\User\Ajency\userauth\UserAuth;
use Illuminate\Support\Facades\Hash;
use Exception;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'contact' => 'required|min:10|max:13',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function getRequirement(Request $request) {
        $userauth_obj = new UserAuth;
        $fnbauth_obj = new FnbAuthController;

        $output = new ConsoleOutput;

        $request_data = [
            "user" => array("username" => $request->email, "email" => $request->email, "name" => $request->name),
            "user_comm" => array("object_type" => "App\User", "email" => $request->email, "is_primary" => 1, "is_communication" => 1, "is_verified" => 0, "is_visible" => 0),
            "user_details" => array("is_job_seeker" => 0, "has_job_listing" => 0, "has_business_listing" => 0, "has_restaurant_listing" => 0)
        ];

        if($request->has("next_url"))  {
            $next_redirect_url = $request->next_url;
        } else {
            $next_redirect_url = '';
        }

        if(!auth()->guest())  {
            $user_obj = auth()->user();
        } else {
            $user_obj = $userauth_obj->checkIfUserExists($request_data["user"]);
        }

        if ($request->has("contact")) {// && $request->has("contact_locality")) {
            $request_data["user_comm"]["contact"] = $request->contact;//$request->contact_locality . $request->contact;
            $request_data["user_comm"]["contact_type"] = "mobile";
        }

        if ($request->has("description")) {
            $request_data["user_details"]["subtype"] = serialize($request->description);
        }

        if ($request->has("area") && $request->has("city")) {
            $request_data["user_details"]["area"] = $request->area;
            $request_data["user_details"]["city"] = $request->city;
        }

        $userauth_obj->updateOrCreateUserComm($user_obj, $request_data["user_comm"]);
        $response = $userauth_obj->updateOrCreateUserDetails($user_obj, $request_data["user_details"], "user_id", $user_obj->id);
        $required_fields_check = $userauth_obj->updateRequiredFields($user_obj);

        if($required_fields_check["has_required_fields_filled"]) {
            return $fnbauth_obj->rerouteUser(array("user" => $user_obj, "status" => "success", "filled_required_status" => ["filled_required" => true, "fields_to_be_filled" => $required_fields_check["fields_to_be_filled"]], "next_url" => $next_redirect_url), "api");
        } else {
            return response()->json(array("redirect_url" => "","status" => 400, "message" => "required_fields_not_filled", "filled_required_status" => ["filled_required" => true, "fields_to_be_filled" => $required_fields_check["fields_to_be_filled"]], "next_url" => $next_redirect_url));
        }

    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request) {

        $output = new ConsoleOutput;

        $socialaccount_obj = new SocialAccountService;
        $userauth_obj = new UserAuth;
        $fnbauth_obj = new FnbAuthController;

        $this->validator($request->all())->validate();

        /*event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        return $this->registered($request, $user) ?: redirect($this->redirectPath());*/

        $request_data = [
            "user" => array("username" => $request->email, "email" => $request->email, "password" => $request->password, "provider" => "email_signup", "name" => $request->name),
            "user_comm" => array("email" => $request->email, "is_primary" => 1, "is_communication" => 1, "is_verified" => 0, "is_visible" => 0),
            "user_details" => array("is_job_seeker" => 0, "has_job_listing" => 0, "has_business_listing" => 0, "has_restaurant_listing" => 0)
        ];

        if ($request->has("contact") && $request->has("contact_locality")) {
            $request_data["user_comm"]["contact"] = $request->contact_locality . $request->contact;
            $request_data["user_comm"]["contact_type"] = "mobile";
        }

        if ($request->has("description")) {
            $request_data["user_details"]["subtype"] = serialize($request->description);
        }

        if ($request->has("area") && $request->has("city")) {
            $request_data["user_details"]["area"] = $request->area;
            $request_data["user_details"]["city"] = $request->city;
        }
        
        //return redirect("/");
        //$social_data = $socialaccount_obj->getSocialData($account, "email_signup");
        $valid_response = $userauth_obj->validateUserLogin($request_data["user"], "email_signup");

        if($valid_response["status"] == "success" || $valid_response["message"] == "no_account") {
            $fnb_auth = new FnbAuthController;
            
            if ($valid_response["authentic_user"]) { // If the user is Authentic, then Log the user in
                if($valid_response["user"]) { // If $valid_response["user"] == None, then Create/Update the User, User Details & User Communications
                    $user_resp = $userauthObj->getUserData($valid_response["user"]);
                } else {
                    $request_data["user"]["roles"] = "customer";
                    $request_data["user"]["type"] = "external";
                    $user_resp = $userauth_obj->updateOrCreateUser($request_data["user"], $request_data["user_details"], $request_data["user_comm"]);
                }

                // Check if all the required fields are filled & is updated in User, User Detail & User Comm
                $required_fields_check = $userauth_obj->updateRequiredFields($user_resp["user"]);

                if($user_resp["user"]) {
                    return $fnb_auth->rerouteUser(array("user" => $user_resp["user"], "status" => "success", "filled_required_status" => ["filled_required" => $required_fields_check['has_required_fields_filled'], "fields_to_be_filled" => $required_fields_check["fields_to_be_filled"]]), "website");
                } else {
                    ;
                }
            } else {
                $previous_url = url()->previous();
                $redirect_url = strpos($previous_url, "?") >= 0 ? explode('?', url()->previous())[0] : url()->previous();

                return redirect($redirect_url . "?login=true&message=" . $valid_response["message"]);    
            }
        } else {
            $previous_url = url()->previous();
            $redirect_url = strpos($previous_url, "?") >= 0 ? explode('?', url()->previous())[0] : url()->previous();

            return redirect($redirect_url . "?login=true&message=" . $valid_response["message"]);
        }
    }
}