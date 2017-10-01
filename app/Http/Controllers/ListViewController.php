<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Ajency\User\Ajency\userauth\UserAuth;
use App\Area;
use App\Category;
use App\City;
use App\Common;
use App\Listing;
use App\ListingAreasOfOperation;
use App\ListingCategory;
use App\ListingOperationTime;
use App\User;
use App\UserCommunication;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Response;

use Symfony\Component\Console\Output\ConsoleOutput;

class ListViewController extends Controller {
	/**
	* This function will load the List View Blade of Listing
	*/
    public function listView(Request $request, $city='all') {
    	$header_type = "trans-header";
    	return view('list-view.business_listing', compact('header_type'));
    }

    /**
    * This function is general function that is used to get the searchData for the searchBoxes
    */
    public function searchData($keyword, $model, $search_key='name', $columns_needed = ['id']) {
    	$keywords = explode(" ", $keyword); // Split String to Keywords
    	$output = new ConsoleOutput;

    	foreach ($keywords as $key => $value) {
    		$temp = null;
    		if(strlen($value) > 2) {
	    		$temp = $model->where($search_key, 'like', '%' . $value . '%');

	    		$output->writeln($temp->count());
	    		if($temp->count() > 0) {
	    			$model = $temp;
	    			$output->writeln($model->count());
	    		} else {
	    			$output->writeln($model->count());
	    		}
	    	}
    	}

    	return $model->get($columns_needed);
    }

    /**
    * This function is used to search the Keyword in the Category table
    */
    public function searchCategory(Request $request) {
    	if($request->has("search") && $request->search) { 
    		$category_obj = new Category;
    		$response_data = $this->searchData($request->search, $category_obj, 'name', ['id', 'name', 'slug']);
    	} else {
    		$response_data = null;
    	}

    	return response()->json(array("data" => $response_data), 200);
    }

    /**
    * This function is used to search the Keyword in the Listing table
    * This function @return
    * 	[
    *		{"id": <id1>, "title": <title1>, "slug": <slug1>},
    *		{"id": <id2>, "title": <title2>, "slug": <slug2>},
    *		....
    *	]
    */
    public function searchBusiness(Request $request) {
    	if($request->has("search") && $request->search) { 
    		$business_obj = new Listing;
    		$response_data = $this->searchData($request->search, $business_obj, 'title', ['id', 'title', 'slug']);
    	} else {
    		$response_data = null;
    	}

    	return response()->json(array("data" => $response_data), 200);
    }

    /**
    * This function is used to get the API values for the ListView page
    * This function @return
    * array("data" => [], "filters_count" => 78, "total_count" => 100)
    */
    public function getListData(Request $request) {
    	$status = 200;

    	try {
	    	$filter_mapping = array("published" => "created_at", "rank" => "", "views" => "views_count");
	    	//$output = new ConsoleOutput;

	    	if($request->has('city') && !($request->city == "all" || $request->city == "")) { // If city filter is added, then
				$area_list = City::where('slug', $request->city)->first()->areas()->pluck('id')->toArray(); // Get list of all the Areas under that City
				$listing_obj = Listing::whereIn('locality_id', $area_list);//->get();
			} else {
				$listing_obj = new Listing;//::all();
			}
	    	
	    	if($request->has('node_category') && $request->node_category) {
	    		$node_category_result = Category::where('id', $request->node_category);
	    		$node_category_result = $node_category_result->first();
	    		

	    		if($node_category_result->level < 3) { // If the level is not 3, then trace all the Node of the Parent / Branch
	    			$array_ids = [$node_category_result->id];

	    			for($i = $node_category_result->level; $i < 3; $i++) {
	    				$array_temp = [];
	    				foreach ($array_ids as $key_id => $value_id) {
	    					$array_temp = array_merge($array_temp, Category::where('parent_id', $value_id)->pluck('id')->toArray());
	    				}
	    				$array_ids = $array_temp; // Transfer the array value to the  new list
	    			}
	    		}

	    		$listing_ids = ListingCategory::whereIn('category_id', $array_ids)->pluck('listing_id')->toArray();
	    		$listing_obj = $listing_obj->whereIn("id", $listing_ids);
	    	}

	    	if($request->has('filters')) {

	    		if(isset($request->filters["areas"]) && sizeof($request->filters["areas"]) > 0) { // If list of area is selected, then
	    			$listing_obj = $listing_obj->whereIn('locality_id', $request->filters["areas"]);
	    		}

				if(isset($request->filters["business_type"]) && sizeof($request->filters["business_type"]) > 0) { // If list of business_type is selected, then
	    			$listing_obj = $listing_obj->whereIn('type', $request->filters["business_type"]); // [11 -> wholesaler, 12 -> retailer, 13 -> manufacturer]
	    		}

	    		if(isset($request->filters["listing_status"]) && sizeof($request->filters["listing_status"]) > 0) { // If list of listing_status is selected, then
	    			foreach ($request->filters["listing_status"] as $key_listing => $value_listing) {
	    				$listing_obj = $listing_obj->orWhere($value_listing, true); // 'verified' => true || 'premium' => 'true'
	    			}
	    		}

	    		/*if(isset($request->filters["ratings"]) && sizeof($request->filters["ratings"]) > 0) { // If list of ratings are selected, then
	    			$listing_obj = $listing_obj->whereIn('rating', $request->filters["ratings"]); // [1 - 5 star]
	    		}*/
	    	}

	    	// Get the page index & no of index to display
	    	$start = ($request->has('page') && $request->page) ? $request->page : 1;
	    	$page_size = ($request->has('page_size') && $request->page_size) ? $request->page_size : 10;

	    	$sort_by = ($request->has('sort_by') && $request->sort_by) ? $filter_mapping[$request->sort_by] : "published";
	    	$sort_order = ($request->has('sort_order') && $request->sort_order) ? $request->sort_order : "desc"; // asc / desc

	    	$filtered_count = $listing_obj->distinct('id')->count('id');
	    	
	    	$listing_obj = $listing_obj->orderBy($sort_by, $sort_order)->skip(($start - 1) * $page_size)->take($page_size)->get(['id', 'title', 'status', 'verified', 'type', 'published_on', 'locality_id']);// , 'rating']);

	    	$listing_obj = $listing_obj->each(function($list){
	    		$list["area"] = $list->location()->get(["id", "name", "slug"])->first(); // Get the Primary area
	    		$list["city"] = $list['area']->first()->city()->get(["id", "name", "slug"])->first();

	    		// Get list of areas under that Listing
	    		$areas_operation_id = ListingAreasOfOperation::where("listing_id", $list->id)->pluck('area_id')->toArray();
	    		$city_areas = Area::whereIn('id', $areas_operation_id)->get(['id', 'name', 'slug', 'city_id'])->groupBy('city_id');

	    		$areas_operation = [];
	    		foreach ($city_areas as $city_id => $city_areas) { // Get City & areas that the Listing is under operation
	    			array_push($areas_operation, 
	    				array("city" => City::where("id", $city_id)->first(['id', 'name', 'slug']),
	    				"areas" => $city_areas
	    			));
	    		}
	    		$list["areas_operation"] = $areas_operation; // Array of cities & areas under that city
	    	});
    	} catch (Exception $e) {
    		$start = 0;
    		$page_size = 0;
    		$filtered_count = 0;
    		$status = 400;
    	}

    	return response()->json(array("data" => $listing_obj, "count" => $filtered_count, "page" => $start, "page_size" => $page_size), $status);
    }
}