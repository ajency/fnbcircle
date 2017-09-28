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
        $routePerrmissions = routePermission();

        $router = app()->make('router');
        $uriPath = $router->getCurrentRoute()->uri;
        
        $configPermission = $routePerrmissions[$uriPath];
         

        return $next($request);
    }
}
