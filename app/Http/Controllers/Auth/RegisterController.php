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
            'password' => 'required|string|min:6|confirmed',
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

        if ($request->has("area") && $request->has("city")) {
            $request_data["user_details"]["area"] = $request->area;
            $request_data["user_details"]["city"] = $request->city;
        }
        
        $output->writeln(json_encode($request_data));
        //return redirect("/");
        //$social_data = $socialaccount_obj->getSocialData($account, "email_signup");
        $valid_response = $userauth_obj->validateUserLogin($request_data["user"], "email_signup");

        $output->writeln(json_encode($valid_response));

        if($valid_response["status"] == "success" || $valid_response["message"] == "no_account") {
            $output->writeln("IF");
            $fnb_auth = new FnbAuthController;
            
            if ($valid_response["authentic_user"]) { // If the user is Authentic, then Log the user in
                $output->writeln("authentic_user");
                if($valid_response["user"]) { // If $valid_response["user"] == None, then Create/Update the User, User Details & User Communications
                    $output->writeln("GET user");
                    $user_resp = $userauthObj->getUserData($valid_response["user"]);
                } else {
                    $output->writeln("Create USer");
                    $user_resp = $userauth_obj->updateOrCreateUser($request_data["user"], $request_data["user_details"], $request_data["user_comm"]);
                }

                if($user_resp["user"]) {
                    $output->writeln("Rerouting");
                    return $fnb_auth->rerouteUser(array("user" => $user_resp["user"], "status" => "success"), "website");
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
