<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Common;
use App\Area;
use App\City;
use Illuminate\Http\Request;

class AdminConfigurationController extends Controller
{
    public function __construct()
    {
        // Common::authenticate('dashboard', $this);
    }

    public function locationView(Request $request)
    {
        $cities = City::all();
        return view('admin-dashboard.location')->with('cities',$cities);
    }

    public function saveLocationData(Request $request)
    {
        $this->validate($request, [
            'type'       => 'required|boolean',
            'area_id'    => 'nullable|integer',
            'city_id'    => 'nullable|integer',
            'name'       => 'required|string|max:255',
            'slug'       => 'required|string|max:255',
            'sort_order' => 'required|integer',
            'status'     => 'required|integer',
        ]);

        if ($request->area_id != '') {
            if (!Common::verify_id($request->area_id, 'areas')) {
                abort(404, 'Area not found');
            }
        }
        if ($request->city_id != '') {
            if (!Common::verify_id($request->city_id, 'cities')) {
                abort(404, 'City Not Found');
            }
        }
        if ($request->status < 0 or $request->status > 2) {
            abort(400);
        }
        if ($request->type == "0") {
            if ($request->city_id == '') {
                $city         = new City;
                $city->status = "0";
                $city->slug   = $request->slug;
            } else {
                $city = City::find($request->city_id);
                if ($city->status == "0" and $request->status == "2") {
                    abort(412, 'You cannot archive a draft location');
                }
                if ($city->status != "0" and $request->status == "0") {
                    abort(412, 'Once the location is published, It cannot be made draft');
                }
                if($request->status=="1"){
                	$city->published_date = Carbon::now();
                } 
                $city->status = $request->status;
                if ($city->status != "0" and $city->slug != $request->slug) {
                    abort(400, 'slug can be edited only in draft');
                }
                $city->slug = $request->slug;
            }
            $city->name       = $request->name;
            $city->order = $request->sort_order;
            $city->save();
            $city = City::find($city->id);
            return response()->json($city);
        } else {
            if ($request->city_id == '') {
                abort(400, 'City required to save area');
            }
            if ($request->area_id == '') {
                $area          = new Area;
                $area->status  = "0";
                $area->slug    = $request->slug;
                $area->city_id = $request->city_id;
            } else {
                $area = Area::find($request->area_id);
                if ($area->status == "0" and $request->status == "2") {
                    abort(412, 'You cannot archive a draft area');
                }
                if ($area->status != "0" and $request->status == "0") {
                    abort(412, 'Once the location is published, It cannot be made draft');
                }
                if($request->status=="1"){
                	$area->published_date = Carbon::now();
                } 
                $area->status = $request->status;
                if ($area->status != "0" and $area->slug != $request->slug) {
                    abort(400, 'slug can be edited only in draft');
                }
                $area->slug = $request->slug;
                if ($area->status != "0" and $area->city_id != $request->city_id) {
                    abort(400, 'you cannot change city after publishing');
                }
                $area->city_id = $request->city_id;
            }
            $area->name       = $request->name;
            $area->order = $request->sort_order;
            $area->save();
            $area=Area::with('city')->find($area->id);
            return response()->json($area);
        }
    }

    public function listLocationConfig(Request $request){
    	$status = array("0"=>"Draft","1"=>"Published","2"=>"Archived");
    	$cities = City::all();
    	$data = array();
    	foreach($cities as $city){
    		$pub = ($city->published_date != null)? $city->published_date->toDateString():"-";
    		$data[] = array(
    			"id"=>"<a href=\"#\"><i class=\"fa fa-pencil\"></i></a><span class=\"hidden\">".$city->id."</span>",
    			"slug" => $city->slug,
    			"name"=>$city->name,
    			"isCity"=>"<i class=\"fa fa-check text-success\"></i><span class=\"hidden\">Yes</span>",
    			"isArea"=>"-<span class=\"hidden\">no</span>",
    			"city"=>"",
    			"sort_order"=>$city->order,
    			"update"=>$city->updated_at->toDateString(),
    			"publish"=>$pub,
    			"status"=>$status[$city->status]

    		);
    	}
    	$areas = Area::with('city')->get();
    	foreach($areas as $area){
    		$pub = ($area->published_date != null)? $area->published_date->toDateString():"-";
    		$data[] = array(
    			"id"=>"<a href=\"#\"><i class=\"fa fa-pencil\"></i></a><span class=\"hidden\">".$area->id."</span>",
    			"slug" => $area->slug,
    			"name"=>$area->name,
    			"isCity"=>"-<span class=\"hidden\">no</span>",
    			"isArea"=>"<i class=\"fa fa-check text-success\"></i><span class=\"hidden\">Yes</span>",
    			"city"=>$area->city['name'].'<span class="hidden">'.$area->city['id'].'</span>',
    			"sort_order"=>$area->order,
    			"update"=>$area->updated_at->toDateString(),
    			"publish"=>$pub,
    			"status"=>$status[$area->status]

    		);
    	}
    	return response()->json(array("data"=>$data));
    }


}
