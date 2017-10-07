<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;
use Auth;
use Ajency\User\Ajency\userauth\UserAuth;

class FnbPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $router = app()->make('router');
        $uriPath = $router->getCurrentRoute()->uri; 

        $parmeters = $router->getCurrentRoute()->parameters; 
        $objectId = array_first($parmeters);

        $route = explode('/', $uriPath);
        $tableReference = $route[0];
        
        $userType = '';
        $lastLogin = '';

        if(Auth::check()){
            $userType = (!empty(Auth::user()->type)) ? Auth::user()->type :'external';
            $userDetails = Auth::user()->getUserDetails; 
            
            if(!empty($userDetails) &&  $userDetails->has_previously_login == true){
                //do nothing
                $lastLogin = $userDetails->has_previously_login;
            }
            else{  
                $lastLogin = (!empty($userDetails)) ? $userDetails->has_previously_login : false;

                $userauth_obj = new UserAuth;
                $request_data['has_previously_login'] =true;
                $response = $userauth_obj->updateOrCreateUserDetails(Auth::user(), $request_data, "user_id", Auth::user()->id);
                $userDetails = $response["data"];

            }
            
            
            
        }
        

        if(!hasAccess($uriPath,$objectId,$tableReference)){
            if($userType == 'internal')
                abort(403);
            else
                return redirect('/');
        }
    
        //check if loggen in user is first time
        if(!$lastLogin)
        {
            if($userType == 'internal')
                return redirect('/admin-dashboard');
            else
                return redirect('/customer-dashboard');
        }

        //if first time : 

        return $next($request);
    }
}
