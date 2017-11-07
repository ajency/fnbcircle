<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function basicDetails($email = null){
    	return view('layouts.profile');
    }
}
