<?php

namespace App\Http\Controllers;

use Ajency\User\Ajency\userauth\UserAuth;
 

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



}
