<?php

namespace App\Http\Controllers;

use Auth;
/**
 *  Class to get the  Header, footer etc from laravel into wordpress news 
 */
class WpNewsController extends Controller
{
    public function getLaravelHeaderForWp()
    {
        return view('wpnews.wp-header');
    }

    public function getLaravelFooterForWp()
    {

        return view('wpnews.wp-footer');
    }

    public function getLaravelLoggedInUser()
    {
        if (Auth::check()) {
            return response()->json(Auth::user());
        } else {
            return response()->json(false);
        }
    }

}
