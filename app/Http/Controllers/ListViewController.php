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
use Illuminate\Support\Facades\View;

use Symfony\Component\Console\Output\ConsoleOutput;

class ListViewController extends Controller {
	/**
	* This function will load the List View Blade of Listing
	*/
    public function listView(Request $request, $city='all') {
    	$header_type = "trans-header";

    	$filters = [];
    	if(request()->has('state') && request()->state && City::where('slug', request()->state)->count() > 0) {
    		$filters["state"] = request()->state;
    		$city = request()->state;
    	} else if(City::where('slug', $city)->count() > 0) {
    		$filters["state"] = $city;
    	} else {
    		$filters["state"] = "";
    	}

    	$filter_view_html = $this->getListFilterData($filters, true);
    	return view('list-view.business_listing', compact('header_type', 'filter_view_html', 'city'));
    }

    /**
    * This function is general function that is used to get the searchData for the searchBoxes
    */
    public function searchData($keyword, $model, $search_key='name', $columns_needed = ['id'], $min_str_len = 0, $return_filterable_obj = false) {
    	$keywords = explode(" ", $keyword); // Split String to Keywords
    	$output = new ConsoleOutput;

    	foreach ($keywords as $key => $value) {
    		$temp = null;
    		if(strlen($value) > $min_str_len) {
	    		$temp = $model->where($search_key, 'like', '%' . $value . '%');

	    		//$output->writeln($temp->count());
	    		$model = $temp;
	    		/*if($temp->count() > 0) { // Ignore if filter returns '0' counts
	    			$model = $temp;
	    			//$output->writeln($model->count());
	    		}*/ /*else {
	    			$output->writeln($model->count());
	    		}*/
	    	}
    	}

    	if($return_filterable_obj) { // If true, then only object without "get()" is returned. Adv: the obj is further Queryable
    		return $model;
    	} else { // Default is false, hence passes "get([column1, column2, ...])". Adv: returns obj, with data. Disadv: can't do major query & filters
    		return $model->get($columns_needed);
    	}
    }

    /**
    * This function is used to search the Keyword in the Area & City table
    */
    public function searchCity(Request $request) {
		$city_obj = City::where('status', 1);

		if($request->has("search") && $request->search) { 
    		$response_data = $this->searchData($request->search, $city_obj, 'name', ['id', 'name', 'slug', 'status', 'order'], 0); // Get all the published State
    	} else {
    		$city_obj = $city_obj->where('order', 1);
    		$response_data = $this->searchData('', $city_obj, 'name', ['id', 'name', 'slug', 'status', 'order'], 0);// Get all the Published state with Order '1' & Status 'published'
    	}

    	return response()->json(array("data" => $response_data), 200);
    }

    /**
    * This function is used to search the Keyword in the Category table
    */
    public function searchCategory(Request $request) {
    	//$is_parent = false;
		$category_obj = Category::where([["status", 1], ["type", "listing"]])->orderBy('order', 'asc');

    	if($request->has("search") && $request->search) { 
    		$response_data = $this->searchData($request->search, $category_obj, 'name', ['id', 'name', 'slug'], 1, true);
    	} else if($request->has("keyword") && $request->keyword) {
    		$response_data = $this->searchData($request->keyword, $category_obj, 'name', ['id', 'name', 'slug'], 1, true);
    	} else { // return parent Data
    		//$is_parent = true;
    		$response_data = $this->searchData("", $category_obj->where('level', 1), 'name', ['id', 'name', 'slug'], 1, true);
    	}

    	$response_data = $response_data->distinct('id')->get(['id', 'name', 'slug', 'level']);

    	$response_data->each(function($category) {
			$output = new ConsoleOutput;
			if($category["level"] != 1) {
				$temp = Category::where("id", $category["id"])->first();

				while($temp["level"] > 1) {
					$temp = Category::where("id", $temp["parent_id"])->first();
				}

				$category["search_name"] = " in <b>" . $temp["name"] . "</b>";
			} else {
				$category["search_name"] = "";
			}
		});

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

    		if($request->has("city") && $request->city) {
    			$area_list = City::where('slug', $request->city)->first()->areas()->pluck('id')->toArray();
    			$business_obj = $business_obj->whereIn('locality_id', $area_list);
    		}

    		// if($request->has("category") && $request->category) {
    		// 	$node_category_result = Category::where('id', $request->category);
	    	// 	$node_category_result = $node_category_result->get();
	    	// 	$array_ids = []; $array_id_list = [];

	    	// 	foreach($node_category_result as $category_index => $category_values) { // Get all the category list
	    	// 		$array_ids = []; // Clear data
		    // 		if($category_values->level < 3) { // If the level is not 3, then trace all the Node of the Parent / Branch
		    // 			$array_ids = [$category_values->id];

		    // 			for($i = $category_values->level; $i < 3; $i++) { // While the level is LESS THAN 3
		    // 				$array_temp = [];
		    // 				foreach ($array_ids as $key_id => $value_id) {
		    // 					$array_temp = array_merge($array_temp, Category::where('parent_id', $value_id)->pluck('id')->toArray());
		    // 				}
		    // 				$array_ids = $array_temp; // Transfer the array value to the  new list
		    // 			}

		    // 			$array_id_list = array_merge($array_id_list, $array_ids); // Merge the Level 3 IDs list to the array
		    // 		} else {
		    // 			$array_id_list = array_merge($array_id_list, [$category_values->id]); // Push this Category ID as the category is Level 3
		    // 		}
		    // 	}
    		// }

    		$response_data = $this->searchData($request->search, $business_obj, 'title', ['id', 'title', 'slug'], 2);
    	} else {
    		$response_data = null;#Listing::where('status', 1)->get(['id', 'title', 'slug']);
    	}

    	return response()->json(array("data" => $response_data), 200);
    }

    /**
    *
    */
    public function getListFilterData($filters=[], $render_html = false) {
    	
    	if(isset($filters["state"]) && $filters["state"]) {
    		$filter_data["areas"] = City::where('slug', $filters["state"])->first()->areas()->get()->toArray();
    	} else {
    		$filter_data["areas"] = [];
    	}

    	if($render_html) {
    		return $filter_view_html = View::make('list-view.single-card.listing_filter')->with(compact('filter_data'))->render();
    	} else {
    		return $filter_data;
    	}
    }

    /**
    * This function is used to get the data that will used to display as summary of all the businesses
    * This function @return
    * 	array("data" => <DB_Model_Object>, "filtered_count" => xx, "start" => x, "page_limit" => xx)
    */
    public function getListingSummaryData($city, $filters=[], $start = 1, $page_limit = 10, $sort_by = "published_on", $sort_order = "desc") {
    	try {
	    	$filter_mapping = array("published" => "created_at", "rank" => "", "views" => "views_count");
	    	//$output = new ConsoleOutput;

	    	if(isset($city) && !($city == "all" || $city == "")) { // If city filter is added, then
				$area_list = City::where('slug', $city)->first()->areas()->pluck('id')->toArray(); // Get list of all the Areas under that City
				$listing_obj = Listing::whereIn('locality_id', $area_list);//->get();
			} else {
				$listing_obj = new Listing;//::all();
			}

			$listing_obj = $listing_obj->where("status", 1); // [1 -> "published", 2 -> "review", 3 -> "draft", 4 -> "archived", 5 -> "rejected"]
	    	
	    	if(isset($filters['categories']) && $filters['categories']) {
	    		$node_category_result = Category::whereIn('id', $filters['categories']);
	    		$node_category_result = $node_category_result->get();
	    		$array_ids = []; $array_id_list = [];

	    		foreach($node_category_result as $category_index => $category_values) { // Get all the category list
	    			$array_ids = []; // Clear data
		    		if($category_values->level < 3) { // If the level is not 3, then trace all the Node of the Parent / Branch
		    			$array_ids = [$category_values->id];

		    			for($i = $category_values->level; $i < 3; $i++) { // While the level is LESS THAN 3
		    				$array_temp = [];
		    				foreach ($array_ids as $key_id => $value_id) {
		    					$array_temp = array_merge($array_temp, Category::where('parent_id', $value_id)->pluck('id')->toArray());
		    				}
		    				$array_ids = $array_temp; // Transfer the array value to the  new list
		    			}

		    			$array_id_list = array_merge($array_id_list, $array_ids); // Merge the Level 3 IDs list to the array
		    		} else {
		    			$array_id_list = array_merge($array_id_list, [$category_values->id]); // Push this Category ID as the category is Level 3
		    		}
		    	}

		    	$array_id_list = array_unique($array_id_list); // Remove duplicate IDs

	    		$listing_ids = ListingCategory::whereIn('category_id', $array_id_list)->pluck('listing_id')->toArray();
	    		$listing_obj = $listing_obj->whereIn("id", $listing_ids);
	    	}

	    	if(isset($filters["areas"]) && sizeof($filters["areas"]) > 0) { // If list of area is selected, then
    			$listing_obj = $listing_obj->whereIn('locality_id', $filters["areas"]);
    		}

			if(isset($filters["business_type"]) && sizeof($filters["business_type"]) > 0) { // If list of business_type is selected, then
    			$listing_obj = $listing_obj->whereIn('type', $filters["business_type"]); // [11 -> wholesaler, 12 -> retailer, 13 -> manufacturer]
    		}

    		if(isset($filters["listing_ids"]) && sizeof($filters["listing_ids"]) > 0) {
    			$listing_obj = $listing_obj->whereIn('id', $filters["listing_ids"]);
    		}

    		if(isset($filters["listing_status"]) && sizeof($filters["listing_status"]) > 0) { // If list of listing_status is selected, then
    			foreach ($filters["listing_status"] as $key_listing => $value_listing) {
    				$listing_obj = $listing_obj->orWhere($value_listing, true); // 'verified' => true || 'premium' => 'true'
    			}
    		}

    		if(isset($filters["ratings"]) && sizeof($filters["ratings"]) > 0) { // If list of ratings are selected, then
    			$listing_obj = $listing_obj->whereIn('rating', $filters["ratings"]); // [1 - 5 star]
    		}

	    	$filtered_count = $listing_obj->distinct('id')->count('id');
	    	
	    	$listing_obj = $listing_obj->orderBy($sort_by, $sort_order)->skip(($start - 1) * $page_limit)->take($page_limit)->get(['id', 'title', 'status', 'verified', 'type', 'published_on', 'locality_id', 'display_address']);// , 'rating']);

	    	$listing_obj = $listing_obj->each(function($list){ // Get following data for each list
	    		$list["area"] = $list->location()->get(["id", "name", "slug"])->first(); // Get the Primary area
	    		$list["city"] = ($list["area"]) ? $list['area']->first()->city()->get(["id", "name", "slug"])->first() : "";

	    		// $list["status"] = Listing::listing_status[$list["status"]]; // Get the string of the Listing Status
	    		$list["business_type"] = Listing::listing_business_type[$list["type"]]; // Get the string of the Listing Type

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

	    		//$list["categories"] = ListingCategory::getCategories($list->id); // Get list of all the categories & it's respective Parent & branch node
	    		
	    		// Fetches the list of all the Core categories & it's details
	    		$list["cores"] = Category::whereIn('id', ListingCategory::where([['listing_id', $list->id],['core',1]])->pluck('category_id')->toArray())->get(['id', 'name', 'slug']);
	    	});
    	} catch (Exception $e) {
    		$filtered_count = 0;
    	}

    	return array("data" => $listing_obj, "filtered_count" => $filtered_count, "start" => $start, "page_limit" => $page_limit);
    }

    /**
    * This function is used to get the API values for the ListView page
    * This function @return
    * array("data" => [], "filters_count" => 78, "total_count" => 100)
    */
    public function getListViewData(Request $request) {
    	$status = 200;
    	$filter_mapping = array("published" => "created_at", "rank" => "", "views" => "views_count");

    	if($request->has("filters")) {
    		$filters = $request->filters;
    	} else {
    		$filters = [];
    	}

    	$city = ($request->has('city') && !($request->city == "all" || $request->city == "")) ? $request->city : "all";
    	$start = ($request->has('page') && $request->page) ? $request->page : 1;
    	$page_size = ($request->has('page_size') && $request->page_size) ? $request->page_size : 10;

    	$sort_by = ($request->has('sort_by') && $request->sort_by) ? $filter_mapping[$request->sort_by] : "published";
    	$sort_order = ($request->has('sort_order') && $request->sort_order) ? $request->sort_order : "desc";

    	if($request->has("filters")) {
    		if(isset($request->filters["business_search"])) {
    			if(!isset($filters["listing_ids"])) {
    				$filters["listing_ids"] = [$request->filters["business_search"]];
    			} else {
    				array_push($filters["listing_ids"], $request->filters["business_search"]);
    			}
    		}

    		if(isset($request->filters["category_search"])) {
    			if(isset($filters["categories"])) {
    				$filters["categories"] = array_merge($filters["categories"], [$request->filters["category_search"]]);
    			} else {
    				$filters["categories"] = [$request->filters["category_search"]];
    			}
    		}
    	}

    	$filtered_list_response = $this->getListingSummaryData($city, $filters, $start, $page_size, $sort_by, $sort_order); // Get list of all the data
    	$listing_data = $filtered_list_response["data"];
    	$list_view_html = View::make('list-view.single-card.listing_card')->with(compact('listing_data'))->render();

    	$filter_filters = [];
    	if($request->has('state') && $request->state && City::where('slug', $request->state)->count() > 0) {
    		$filter_filters["state"] = $request->state;
    		$city = $request->state;
    	} else if(City::where('slug', $city)->count() > 0) {
    		$filter_filters["state"] = $city;
    	} else {
    		$filter_filters["state"] = "";
    	}

    	$filter_view_html = $this->getListFilterData($filter_filters, true);

    	return response()->json(array("data" => ["list_view" => $list_view_html, "filter_view" => $filter_view_html], "count" => $filtered_list_response["filtered_count"], "page" => $filtered_list_response["start"], "page_size" => $filtered_list_response["page_limit"]), $status);
    }
}