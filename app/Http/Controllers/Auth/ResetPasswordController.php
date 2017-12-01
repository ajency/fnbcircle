<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\PasswordReset;

use App\UserCommunication;
use Illuminate\Support\Facades\DB;


class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
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

    /* The below function are copied from the Illuminate\Foundation\Auth\ResetsPasswords.php */
    /**
     * Display the password reset view for the given token.
     *
     * If no token is present, display the link request form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string|null  $token
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showResetForm(Request $request, $token = null) {
        if($request->has('email') && $request->email) {
            $email = $request->email;
        } else {
            $reset_obj = DB::table('password_resets')->where('token', $token)->orderBy('created_at', 'desc')->first();
            if($reset_obj) {
                $email = $reset_obj->email;   
            } else {
                $email = null;
            }
        }
        if($request->has('new_user') and $request->new_user == "true"){
            $new_user = true;
        }else{
            $new_user=false;
        }
        return view('auth.passwords.reset')->with(
            ['token' => $token, 'email' => $email]
        )->with('new_user',$new_user);
    }

     /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword  $user
     * @param  string  $password
     * @return void
     */
    protected function resetPassword($user, $password) {
        $user->password = Hash::make($password);

        $user->setRememberToken(Str::random(60));

        if($user->status == "inactive") { // Activate the User
            $user->status = "active";
        }

        $user->save();

        UserCommunication::where('object_type', 'App\\User')->where('object_id', $user->id)->where('type','email')->where('is_primary',1)->update(['is_verified'=>1]);

        event(new PasswordReset($user));

        $this->guard()->login($user);
    }
}
