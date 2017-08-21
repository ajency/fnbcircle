<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommonController extends Controller
{
    public function mapKey(Request $request){
    	$key = env('MAP_KEY', 'AIzaSyBHTsG4PIRcifD2o21lqOinIFsncjLHr00');
    	return response()->json(array('key'=>$key));
    }
}
