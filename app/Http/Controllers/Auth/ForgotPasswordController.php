<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

use App\User;
use App\UserCommunication;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function validatingEmail(Request $request) {
        $this->validateEmail($request);

        $user_comm_obj = UserCommunication::where([['object_type', 'App\User'], ['type', 'email'], ['value', $request->email]])->first();
        $user_obj = User::find($user_comm_obj->object_id);

        if(!in_array($user_obj->signup_source, config('aj_user_config.social_account_provider'))) {
            $this->sendResetLinkEmail($request);
            $message = "success";
            $status = 200;
        } else if (in_array($user_obj->signup_source, config('aj_user_config.social_account_provider'))) {
            $message = "This account is registered through " . ucfirst($user_obj->signup_source);
            $status = 406;
        } else {
            $message = "This email ID doesn't exist";
            $status = 400;
        }

        return response()->json(array("message" => $message), $status);
    }

    /**
    * This below functions are referred from "Illuminate/Contracts/Auth/SendsPasswordResetEmails.php"
    */

     /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLinkRequestForm() {
        return view('auth.passwords.email');
    }

    /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendResetLinkEmail(Request $request) {
        $this->validateEmail($request);

        $user_comm_obj = UserCommunication::where([['object_type', 'App\User'], ['type', 'email'], ['value', $request->email]])->first();
        $user_obj = User::find($user_comm_obj->object_id);

        if(!in_array($user_obj->signup_source, config('aj_user_config.social_account_provider'))){
            // We will send the password reset link to this user. Once we have attempted
            // to send the link, we will examine the response then see the message we
            // need to show to the user. Finally, we'll send out a proper response.
            $response = $this->broker()->sendResetLink(
                $request->only('email')
            );
            
            return $response == Password::RESET_LINK_SENT ? $this->sendResetLinkResponse($response) : $this->sendResetLinkFailedResponse($request, $response);
            
        } else if(in_array($user_obj->signup_source, config('aj_user_config.social_account_provider'))) {
            $this->sendResetLinkFailedResponse($request, '', "This account is registered through " . ucfirst($user_obj->signup_source));
        } else {
            $this->sendResetLinkFailedResponse($request, '', "No account with this email");
        }
    }

    /**
     * Validate the email for the given request.
     *
     * @param \Illuminate\Http\Request  $request
     * @return void
     */
    /*protected function validateEmail(Request $request) {
        $this->validate($request, ['email' => 'required|email']);
    }*/

    /**
     * Get the response for a successful password reset link.
     *
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse
     */
    /*protected function sendResetLinkResponse($response) {
        return back()->with('status', trans($response));
    }*/

    /**
     * Get the response for a failed password reset link.
     *
     * @param  \Illuminate\Http\Request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendResetLinkFailedResponse(Request $request, $response, $alternate_messages = "") {
        if (strlen($alternate_messages) > 0) {
            return back()->withErrors(
                ["email" => $alternate_messages]
            );
        } else {
            return back()->withErrors(
                ['email' => trans($response)]
            );
        }
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker() {
        return Password::broker();
    }
}
