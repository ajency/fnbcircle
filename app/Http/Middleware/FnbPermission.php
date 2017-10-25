<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;
use Auth;


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

        if(Auth::check()){
            $userType = (!empty(Auth::user()->type)) ? Auth::user()->type :'external';
        }
        
        
        if(!hasAccess($uriPath,$objectId,$tableReference)){
            if($userType == 'internal')
                abort(403);
            else
                return redirect('/');
        }
       
        return $next($request);
    }
}
