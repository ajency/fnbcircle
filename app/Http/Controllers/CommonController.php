<?php

namespace App\Http\Controllers;
use App\Area;
use App\City;
use Illuminate\Http\Request;

class CommonController extends Controller
{
    public function mapKey(Request $request){
    	$key = env('MAP_KEY', 'AIzaSyBHTsG4PIRcifD2o21lqOinIFsncjLHr00');
    	return response()->json(array('key'=>$key));
    }
    public function slugifyCitiesAreas(){
    	$areas = Area::all();
    	foreach ($areas as $area) {
    		$area->slug = str_slug($area->name);
    		$area->save();
    	}
    	$cities = City::all();
    	foreach ($cities as $city) {
    		$city->slug = str_slug($city->name);
    		$city->save();
    	}
    	echo "success";
    }
}
