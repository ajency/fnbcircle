<?php

namespace App\Http\Controllers;

use App\Common;
use Illuminate\Http\Request;

class AdminConfigurationController extends Controller
{
     public function __construct()
    {
        Common::authenticate('dashboard', $this);
    }

    public function locationView(Request $request){
    	return view('admin-dashboard.location');
    }
}
