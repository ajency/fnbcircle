<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;

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
        
        if(!hasAccess($uriPath,$objectId,$tableReference))
            abort(403);
         

        return $next($request);
    }
}
