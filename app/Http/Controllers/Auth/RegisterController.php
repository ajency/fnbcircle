<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

use Illuminate\Http\Request;
use Symfony\Component\Console\Output\ConsoleOutput;
use App\Http\Controllers\FnbAuthController;

use App\UserCommunication;
use App\UserToken;

/* Plugin Access Headers */
use Ajency\User\Ajency\socialaccount\SocialAccountService;
use Ajency\User\Ajency\userauth\UserAuth;
use Illuminate\Support\Facades\Hash;
use Exception;
use Auth; 
use Session;

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
            "user_comm" => array("object_type" => "App\User", "email" => $request->email, "is_primary" => 1, "is_communication" => 1, "is_visible" => 0),
            "user_details" => array("is_job_seeker" => 0, "has_job_listing" => 0, "has_business_listing" => 0, "has_restaurant_listing" => 0)
        ];

        if($request->has('is_contact_verified') && in_array(strtolower($request->is_contact_verified), ['true', '1'])) {
            $request_data["user_comm"]["is_verified"] = 1;
        } else {
            $request_data["user_comm"]["is_verified"] = 0;
        }

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
            $request_data["user_comm"]["country_code"] = ($request->has("contact_locality")) ? $request->contact_locality : "91";
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

        $request_data["user_comm"]["object_id"] = $user_obj->id;

        if($request->has('contact_id') && $request->contact_id) {
            $userauth_obj->updateOrCreateUserComm($user_obj, $request_data["user_comm"], $request->contact_id);
        } else {
            $userauth_obj->updateOrCreateUserComm($user_obj, $request_data["user_comm"], '');
        }

        // if(isset($request_data["user_comm"]["contact"])) {
        //     $user_comm = UserCommunication::where([['value', $request_data["user_comm"]["contact"]], ["object_type", "App\User"]])->get();

        //     if($user_comm->count() > 0) {
        //         if($user_comm->object_id === null) {
        //             $user_comm->object_id = $user_obj->id;
        //             $user_comm->save();
        //         }
        //     }
        // }

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
            "user_comm" => array("email" => $request->email, "is_primary" => 1, "is_communication" => 1, "is_visible" => 0),
            "user_details" => array("is_job_seeker" => 0, "has_job_listing" => 0, "has_business_listing" => 0, "has_restaurant_listing" => 0)
        ];

        if($request->has('is_contact_verified') && in_array(strtolower($request->is_contact_verified), ['true', '1'])) {
            $request_data["user_comm"]["is_verified"] = 1;
        } else {
            $request_data["user_comm"]["is_verified"] = 0;
        }

        /*if ($request->has("contact")) {
            $request_data["user_comm"]["country_code"] = ($request->has("contact_locality")) ? $request->contact_locality : "91";
            $request_data["user_comm"]["contact"] = $request->contact;
            $request_data["user_comm"]["contact_type"] = "mobile";
        }*/

        if ($request->has("description")) {
            $request_data["user_details"]["subtype"] = serialize($request->description);
        }

        if ($request->has("area") && $request->has("city")) {
            $request_data["user_details"]["area"] = $request->area;
            $request_data["user_details"]["city"] = $request->city;
        }
        
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

                if($request->has('contact') && isset($user_resp["user"]) && $user_resp["user"]) { // If communication, then enter Mobile No in the UserComm table
                    $usercomm_obj = UserCommunication::create([
                        "type" => "mobile", "country_code" => ($request->has("contact_locality")) ? $request->contact_locality : "91", 
                        "value" => $request->contact, "object_id" => $user_resp["user"]->id, "object_type" => "App\User", "is_primary" => 1
                    ]);
                }

                // Check if all the required fields are filled & is updated in User, User Detail & User Comm
                $required_fields_check = $userauth_obj->updateRequiredFields($user_resp["user"]);

                //send email
                $this->registerConfirmEmail($user_resp["user"]);
 
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

    public function confirmEmail($token_type = 'register', $user_data = [], $email_template_key = 'user-verify') {
        if(sizeof($user_data) > 0 && isset($user_data["id"]) && isset($user_data["email"])) {
            $token = str_random(50);
            if(!isset($user_data["user_type"]) || $user_data["user_type"] !== "lead") {
                $userToken = new UserToken();
                $userToken->user_id = $user_data["id"];
                $userToken->token = $token;
                $userToken->token_type = $token_type;
                $userToken->token_expiry_date = date("Y-m-d H:i:s", strtotime('+2 hours'));
                $userToken->status = 'sent';
                $userToken->save();
            }

            $confirmationLink = url('/user-confirmation/' . $token);
            $userEmail = $user_data["email"];
            $data = [];
            $data['from'] = config('constants.email_from'); 
            $data['name'] = config('constants.email_from_name');
            $data['to'] = [$userEmail];
            $data['cc'] = [];
            $data['subject'] = "Verify your email address!";
            $data['template_data'] = ['name' => $user_data["name"], 'confirmationLink' => $confirmationLink, 'contactEmail' => config('constants.email_from')];
            sendEmail($email_template_key, $data);

            return true;
        } else {
            return false;
        }
    }

    public function registerConfirmEmail($user) {

        $user_data = array("id" => $user->id, "name" => $user->name, "email" => $user->getPrimaryEmail());

        return $this->confirmEmail("register", $user_data, 'user-verify');
    }


    public function userConfirmation($usertoken)
    {
        $token = UserToken:: where(['token'=>$usertoken,'token_type'=>'register'])->first();

        $today = new \DateTime(); 
        $expireDate = new \DateTime($token['token_expiry_date']);  
 
        if(!empty($token) && $expireDate > $today &&  $token->status == 'sent')
        {
            $user = User::find($token['user_id']);
            $user->status = 'active';
            $user->save();

            UserCommunication::where('object_type', 'App\\User')->where('object_id', $user->id)->where('type','email')->where('is_primary',1)->update(['is_verified'=>1]);

            $token->status = 'completed';
            $token->save();

            sendUserRegistrationMails($user);
            $redirectUrl = firstTimeUserLoginUrl();
            
            return redirect(url($redirectUrl));
            
        } else {

            if(!empty($token) && $token->status == "completed") {
                return redirect(url('/').'?login=true&message=token_already_verified'); 
            } else if(!empty($token) && $expireDate > $today) {
                $user = User::find($token['user_id']);
                Session::put('userLoginEmail', $user->email);
                return redirect(url('/').'?login=true&message=token_expired'); 
            } else
                return redirect(url('/')); 
            
            
        }
    }

 
    public function sendConfirmationLink(Request $request)  
    {
        $email = Session::get('userLoginEmail');
        $user = User::where('email',$email)->get()->first();
        $confirmation = $this->registerConfirmEmail($user);
        return redirect(url('/').'?login=true&message=resend_verification'); 
    }
}