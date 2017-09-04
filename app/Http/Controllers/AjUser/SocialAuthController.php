<?php

namespace App\Http\Controllers\AjUser;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests;
use Socialite;
use App\SocialAccountService;
use App\User;

use Config;
use Illuminate\Support\Facades\Session;

use Symfony\Component\Console\Output\ConsoleOutput;

class SocialAuthController extends Controller {
    public function redirect($provider) { // for Provider authentication -> Provider = ['Google', 'Facebook']
        return Socialite::driver($provider)->redirect();
    }

    public function callback(SocialAccountService $service, $provider) { // after 'Provider' authentication & redirection
        try {
            $output = new ConsoleOutput();

            $account = Socialite::driver($provider)->stateless()->user(); /* trying to use socialite on a laravel with socialite sessions deactivated */

            $data = $service->getSocialData($account, $provider);
            
            $output->writeln("callback() -> User");
            $output->writeln(var_export($data, true));
            
            //if $service->check_if_user_exists($data) {
            $arraySocial = $service->getOrCreateUser($data);
            // } 

            $user = $arraySocial[0]; // Get User object
            
            if ($arraySocial[1] == "present" || $arraySocial[1] == "exist") {
                auth()->login($user); // Authenticate using User Object
                return redirect('/home');
            } else { // Same Email but different Source
                return redirect('/register');
            }
            
            
        } catch (Exception $e) {
            
        }
    }
    
    public function getDetails(Request $request, $provider) {
        try {
            $output = new ConsoleOutput();


            $token = $request->token;//"ya29.Glu3BER1pDE1i7Y77B7IiDo_He-Z-zcsZqs193WTR57qTGO4Lw3a2XnGjJO_PLjGGs4H-Qvjexh_KdEuNCWL1SjRfyQoiXe0oJfbBJg3BC6LL22FE1Onwjfm7GC9";
            $account = Socialite::driver($provider)->userFromToken($token);
            
            $service = new SocialAccountService();
            $data = $service->getSocialData($account, $provider);
            // $this->create_fnb_user($service, $data);
         
            $output->writeln("getDetails() -> User");
            $output->writeln(var_export($data, true));

        } catch (Exception $e) {
            
        }
    }

    public function logout() { // overrided the default login
        $output = new ConsoleOutput();

        try {
            if(auth()->check()) { // User's session is Valid
                if (array_key_exists(auth()->user()->lang, Config::get('app.locales'))) {
                    Session::set('locale', "en");
                }

                auth()->logout();
                //return redirect()->to(session('locale').'/home');
                return redirect('/login');
            } else { // User's Session Timed out
                Session::set('locale', "en");
                auth()->logout();
                return redirect('/login')->with('message', "session_timeout");
            }
        } catch (Exception $e) { // User session validation Exception
            Session::set('locale', "en");
            auth()->logout();
            return redirect('/login')->with('message', "session_timeout");
        }
    }
}