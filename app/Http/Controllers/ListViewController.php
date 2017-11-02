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
use App\Update;
use App\User;
use App\UserCommunication;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\View;
use App\Helper;
use Illuminate\Support\Facades\DB;

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
    	} else if(request()->has('state') && request()->state && Area::where('slug', request()->state)->count() > 0) {
    		$filters["state"] = request()->state;
    		$city = request()->state;
    		$filters["areas_selected"] = [$city];
    	} else if(City::where('slug', $city)->count() > 0) {
    		$filters["state"] = $city;
    	} else {
    		$filters["state"] = "";
    	}

    	if($request->has("categories") && $request->categories) {
			/*$category_search_filter = json_decode(explode("|", $request->categories)[1]);// Get the Node_categories list

			if(isset($filters["categories"])) {
				$filters["categories"] = array_merge($filters["categories"], is_array($category_search_filter) ? $category_search_filter : [$category_search_filter]);
			} else {
				$filters["categories"] = is_array($category_search_filter) ? $category_search_filter : [$category_search_filter];
			}*/
    		$filters["category"] = array("slug" => explode("|", $request->categories)[0]);
		} else {
			$filters["category"] = array("slug" => "");
		}

		if($request->has('listing_status') && $request->listing_status) {
			$filters["listing_status"] = json_decode($request->listing_status);
		} else {
			$filters["listing_status"] = [];
		}

		if($request->has('business_types') && $request->business_types) {
			$filters["business_type"] = json_decode($request->business_types);
		} else {
			$filters["business_type"] = [];
		}

    	if($request->has('areas_selected') && json_decode($request->areas_selected) && Area::whereIn('slug', json_decode($request->areas_selected))->count() > 0) {
    		$category_search_filter = json_decode($request->areas_selected);

			if(isset($filters["areas_selected"])) {
				$filters["areas_selected"] = array_merge($filters["areas_selected"], is_array($category_search_filter) ? $category_search_filter : [$category_search_filter]);
			} else {
				$filters["areas_selected"] = is_array($category_search_filter) ? $category_search_filter : [$category_search_filter];
			}
			
			$filter_filters["areas_selected"] = $filters["areas_selected"];
    	}
    	
    	$filter_view_html = $this->getListFilterData($filters, true);

    	$page = $request->has('page') && intval($request->has('page')) ? (int)($request->page) : 1;
    	$page_size = $request->has('limit') && intval($request->has('limit')) ? (int)$request->limit : 10;

    	$paginate = pagination($page * $page_size, $page, $page_size);

    	return view('list-view.business_listing', compact('header_type', 'filter_view_html', 'city', 'paginate'));
    }

    /**
    * This function is general function that is used to get the searchData for the searchBoxes
    */
    public function searchData($keyword, $model, $search_key='name', $columns_needed = ['id'], $min_str_len = 0, $return_filterable_obj = false) {
    	$keywords = explode(" ", $keyword); // Split String to Keywords
    	$output = new ConsoleOutput;

    	foreach ($keywords as $key => $value) {
    		$temp = null;
    		if(strlen($value) > $min_str_len && $search_key !== "id") {
	    		$temp = $model->where($search_key, 'like', '%' . $value . '%');

	    		//$output->writeln($temp->count());
	    		$model = $temp;
	    		/*if($temp->count() > 0) { // Ignore if filter returns '0' counts
	    			$model = $temp;
	    			//$output->writeln($model->count());
	    		}*/ /*else {
	    			$output->writeln($model->count());
	    		}*/
	    	} else if($search_key == "id") {
	    		$temp = $model->where($search_key,  $value);
	    		$model = $temp;
	    	}
    	}

    	if($return_filterable_obj) { // If true, then only object without "get()" is returned. Adv: the obj is further Queryable
    		return $model;
    	} else { // Default is false, hence passes "get([column1, column2, ...])". Adv: returns obj, with data. Disadv: can't do major query & filters
    		if(sizeof($columns_needed) > 0)
    			return $model->get($columns_needed); // Get specific column alues
    		else
    			return $model->get(); // Get all
    	}
    }

    /**
    * This function is used to search the Keyword in the Area & City table
    */
    public function searchCity(Request $request) {
		$city_obj = City::where('status', 1)->orderBy('order', 'asc');

		if($request->has("search") && $request->search) { 
			$area_obj = Area::where('status', 1)->orderBy('order', 'asc');
			/* Search the City / State */
    		$response_data = $this->searchData($request->search, $city_obj, 'name', ['id', 'name', 'slug', 'status', 'order'], 0); // Get all the published State
    		if($response_data->count() > 0) {
	    		$response_data = $response_data->each(function($city_val) {
	    			$city_val["search_text"] = $city_val->name;
					$city_val["search_value"] = $city_val->slug;
	    		});
	    	}

    		/* Search the Area */
    		$response_data_areas = $this->searchData($request->search, $area_obj, 'name', ['id', 'name', 'slug', 'status', 'order', 'city_id'], 0); // Get all the published Areas
    		if($response_data_areas->count() > 0) {
    			$response_data_areas = $response_data_areas->each(function($area) {
    				$area["city"] = $area->city()->pluck("name")->first();#->get(['id', 'name', 'slug', 'status', 'order'])->first()->toArray();
    				$area["search_text"] = $area->name . "," . $area->city()->pluck("name")->first();
    				$area["search_value"] = $area->slug . "," . $area->city()->pluck("slug")->first();
    			})->toArray();
    		} else {
    			$response_data_areas = [];	
    		}

    		if ($response_data->count() > 0 && sizeof($response_data_areas) > 0) {
    			$response_data = array_merge($response_data->toArray(), $response_data_areas);
    		} else if ($response_data->count() <= 0 && sizeof($response_data_areas) > 0) {
    			$response_data = $response_data_areas;
    		}
    	} else {
    		$response_data = $this->searchData('', $city_obj, 'name', ['id', 'name', 'slug', 'status', 'order'], 0);// Get all the Published state with Order '1' & Status 'published'
    		if($response_data->count() > 0) {
	    		$response_data = $response_data->each(function($city_val) {
	    			$city_val["search_text"] = $city_val->name;
					$city_val["search_value"] = $city_val->slug;
	    		});
	    	}
    	}

    	return response()->json(array("data" => $response_data), 200);
    }

    /**
    * This function is used to search the Keyword in the Category table
    */
    public function searchCategory(Request $request) {
    	//$is_parent = false;
		$category_obj = Category::where([["status", 1], ["type", "listing"]])->orderBy('order', 'asc');

		$output = new ConsoleOutput;

		if($request->has("search") && $request->search) {
			$response_data = $this->searchData($request->search, $category_obj, 'name', ['id', 'name', 'slug', 'level'], 1, true);
    	} else if($request->has("keyword") && $request->keyword) {
    		$response_data = $this->searchData($request->keyword, $category_obj, 'name', ['id', 'name', 'slug', 'level'], 1, true);
    	} else if ($request->has("load") && $request->load) {
    		$response_data = $this->searchData(explode("|", $request->load)[0], $category_obj, 'slug', ['id', 'name', 'slug', 'level'], 1, true);
    	} else { // return parent Data
    		//$is_parent = true;
    		$response_data = $this->searchData("", $category_obj->where('level', 1), 'name', ['id', 'name', 'slug', 'level'], 0, true);
    	}

    	$response_data = $response_data->get(['id', 'name', 'slug', 'level']);//$response_data->distinct('id')->get(['id', 'name', 'slug', 'level']);

    	$response_data->each(function($category) {
			$output = new ConsoleOutput;

			if($category["level"] != 1) {
				$temp = Category::where("id", $category["id"])->first();

				while($temp["level"] > 1) { // Get the Parent Category
					$temp = Category::where("id", $temp["parent_id"])->first();
				}

				$category["search_name"] = " in <b>" . $temp["name"] . "</b>";
				//dd($category->path);
			} else {
				$category["search_name"] = " ";
			}

			$category["node_children"] = $this->getCategoryNodeArray($category["id"], "slug", true);
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
    	if(($request->has("search") && $request->search) || ($request->has("load") && $request->load)) { 
    		$business_obj = Listing::where('status', 1);// new Listing;

    		$output = new ConsoleOutput;
    		/*$output->writeln("City");
    		$output->writeln($request->has("city"));

    		$output->writeln($request->has("search"));
    		$output->writeln(json_encode($request->all()));*/

    		if($request->has("city") && $request->city) {
    			$area_list = City::where('slug', $request->city)->first()->areas()->pluck('id')->toArray();
    			$business_obj = $business_obj->whereIn('locality_id', $area_list);
    		}

    		if($request->has("category") && $request->category) {
    			$node_category_result = Category::where('id', $request->category);
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
    		}

            if($request->has('load') && (strpos($request->load, '-') > -1 || strpos($request->load, '_') > -1)) {
                $response_data = $this->searchData($request->load, $business_obj, 'slug', ['id', 'title', 'slug'], 1);
            } else if($request->has('search') && (strpos($request->search, '-') > -1 || strpos($request->search, '_') > -1)) {
                $response_data = $this->searchData($request->search, $business_obj, 'slug', ['id', 'title', 'slug'], 1);
            } else if($request->has('search'))
                $response_data = $this->searchData($request->search, $business_obj, 'title', ['id', 'title', 'slug'], 1);
    	} else {
    		$response_data = null;#Listing::where('status', 1)->get(['id', 'title', 'slug']);
    	}

    	return response()->json(array("data" => $response_data), 200);
    }

    public function getCategoryNodeArray($category_val, $col_return = "id", $is_id = false) {
    	$temp_cat_obj = new Category;

    	if($is_id) {
    		$category_val = Category::find($category_val);
    	}

    	if($category_val->level < 3) {
			$node_categories = $temp_cat_obj->where([["path", 'like', $category_val->path() . '%'], ["level", 3], ['status', 1]])->pluck($col_return)->toArray();
		} else {
			$node_categories = [$category_val[$col_return]];
		}

		$final_op = strVal($category_val[$col_return]) . "|" . json_encode($node_categories);

		return $final_op;
    }

    /**
    * This function will read the "filters" params & will generate an Array / Json values (with flags for the Checkbox) & if $render_html = "true", then render the blade with the values
    * This function will @return
    * 	"filter_data" if $render_html = false
    *			AND
    *	"html" if the $render_html = true
    */
    public function getListFilterData($filters=[], $render_html = false) {

		// $category_obj = Category::where([["status", 1], ["type", "listing"]])->orderBy('order', 'asc');
		$category_obj = new Category;
		$path_breaker = array(1 => 0, 2 => 1, 3 => 2); // <level> => no of breaks

		$filter_data["category"] = [];

		/* If the category is defined in the filter param & the value exist, then get that "category's" Parent, Child, Name & Node Categories under that Category */
        if(isset($filters["category"]) && $filters["category"] && isset($filters["category"]["slug"]) && strlen($filters["category"]["slug"]) > 0 ) {
    	// if(isset($filters["category"]) && $filters["category"] && intVal($filters["category"]["id"]) > 0 ) {
    		$cat_obj = $category_obj->where('slug', $filters["category"]["slug"])->get()->first();
            
    		// Get the name & node_categories under it
    		$filter_data["category"] = array("name" => $cat_obj->name, "node_categories" => $this->getCategoryNodeArray($cat_obj, "slug", false));

			// Find the parent & Grand-parent
    		if($cat_obj->level > 1) {
    			$filter_data["category"]["parent"] = [];
    			for($i = $cat_obj->level; $i > 1; $i--) {
    				$filter_data["category"]["parent"] = array_merge($filter_data["category"]["parent"], 
		    			$category_obj->where("id", intVal(substr($cat_obj->path(), $path_breaker[$i - 1] * 5, 5)))->get()->each(function($parent_cat){
		    				$parent_cat["node_categories"] = $this->getCategoryNodeArray($parent_cat, "slug", false);
		    			})->toArray()
		    		);
		    	}
		    	$filter_data["category"]["parent"] = array_reverse($filter_data["category"]["parent"], true);
	    	} else {
	    		$filter_data["category"]["parent"] = [];
	    	}
    		
    		// Find the children
    		$filter_data["category"]["children"] = $category_obj->where([["path", "like", $cat_obj->path() . "%"], ["level", $cat_obj->level + 1], ['status', 1]])->get()->each(function($child_cat) {
				$child_cat["node_categories"] = $this->getCategoryNodeArray($child_cat, "slug", false);
			})->toArray();
    	} else {
    		$filter_data["category"] = array("parent" => [], "node_categories" => "|[]", "name" => "");
			
			$filter_data["category"]["children"] = $category_obj->where([["level", 1], ["type", "listing"], ['status', 1]])->get()->each(function($category_val) {
				$category_val["node_categories"] = $this->getCategoryNodeArray($category_val, "slug", false);
			})->toArray();
    	}
    	
    	/* if state filter is passed, then get all the areas to be displayed in the filter */
    	if(isset($filters["state"]) && $filters["state"]) {
    		$filter_data["areas"] = City::where('slug', $filters["state"]);//City::where([['slug', $filters["state"]], ['status', 1]]);
    		
    		if($filter_data["areas"]->count() > 0) {
    			$filter_data["areas"] = $filter_data["areas"]->first()->areas()->where('status', 1)->get()->toArray();
    		} else {
    			$filter_data["areas"] = Area::where([['slug', $filters["state"]], ['status', 1]])->get()->toArray();

    			if(sizeof($filter_data["areas"]) == 1) {
    				$filter_data["areas_selected"] = [$filter_data["areas"][0]["slug"]];
    			}
    		}
    	} else {
    		$filter_data["areas"] = [];
    	}

    	if(isset($filters["areas_selected"])) {
    		if (isset($filter_data["areas_selected"])) {
    			$filter_data["areas_selected"] = array_merge($filter_data["areas_selected"], $filters["areas_selected"]);
    		} else {
    			$filter_data["areas_selected"] = $filters["areas_selected"];
    		}
    	} else {
    		$filter_data["areas_selected"] = [];
    	}

    	/* If business_type filter is selected or exist then update the values */
    	$listing_business_value = [];
    	foreach (Listing::listing_business_type as $type_key => $type_value) {
    		$listing_business_type[Listing::listing_business_type_slug[$type_key]] = $type_value;
    	}

    	$filter_data["business_type"]["value"] = $listing_business_type;
    	$filter_data["business_type"]["status"] = [];
    	$filter_data["business_type"]["check_count"] = 0;

		if(isset($filters["business_type"])) {
    		foreach ($filter_data["business_type"]["value"] as $key => $value) {
    			if(in_array($key, $filters["business_type"])) {
    				$filter_data["business_type"]["status"][$key] = "checked";
    				$filter_data["business_type"]["check_count"]++;
    			} else {
    				$filter_data["business_type"]["status"][$key] = "";
    			}
    		}
    	}    	

    	/* If listing_status filter is selected or exist then update the values */
    	$filter_data["listing_status"]["value"] = array("premium" => "Premium", "verified" => "Verified");
    	$filter_data["listing_status"]["status"] = [];
    	$filter_data["listing_status"]["check_count"] = 0;

    	if(isset($filters["listing_status"])) {
    		foreach ($filter_data["listing_status"]["value"] as $key => $value) {
    			if(in_array($key, $filters["listing_status"])) {
    				$filter_data["listing_status"]["status"][$key] = "checked";
    				$filter_data["listing_status"]["check_count"]++;
    			} else {
    				$filter_data["listing_status"]["status"][$key] = "";
    			}
    		}
    	}
    	$filter_data["star_ratings"] = array(5 => 100, 4 => 80, 3 => 60, 2 => 40, 1 => 20);

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
	    	$filter_mapping = array("published" => "updated_at", "rank" => "", "views" => "views_count");
	    	//$output = new ConsoleOutput;

	    	if(isset($city) && !($city == "all" || $city == "")) { // If city filter is added, then
				$area_list = City::where('slug', $city);
				if($area_list->count() > 0) {
					$area_list = $area_list->first()->areas()->pluck('id')->toArray(); // Get list of all the Areas under that City
				} else {
					$area_list = Area::where('slug', $city)->get(['id'])->toArray();
				}
				$listing_obj = Listing::whereIn('locality_id', $area_list);//->get();
			} else {
				$listing_obj = new Listing;//::all();
			}

			$listing_obj = $listing_obj->where("status", 1); // [1 -> "published", 2 -> "review", 3 -> "draft", 4 -> "archived", 5 -> "rejected"]
	    		
	    	if(isset($filters['categories']) && sizeof($filters['categories']) > 0) {
	    		/*
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
		    	*/

		    	$listing_ids = ListingCategory::whereIn('category_slug', $filters['categories'])->pluck('listing_id')->toArray();
	    		$listing_obj = $listing_obj->whereIn("id", $listing_ids);
	    	}

	    	if(isset($filters["areas"]) && sizeof($filters["areas"]) > 0) { // If list of area is selected, then
	    		$area_ids = Area::whereIn('slug', $filters["areas"])->pluck("id")->toArray();
    			$listing_obj = $listing_obj->whereIn('locality_id', $area_ids);
    		}

			if(isset($filters["business_type"]) && sizeof($filters["business_type"]) > 0) { // If list of business_type is selected, then
				$business_type_list = [];
				foreach ($filters["business_type"] as $type_key => $type_value) {
					array_push($business_type_list, array_search($type_value, Listing::listing_business_type_slug));
				}
    			$listing_obj = $listing_obj->whereIn('type', $business_type_list); // [11 -> wholesaler, 12 -> retailer, 13 -> manufacturer]
    		}

    		if(isset($filters["listing_ids"]) && sizeof($filters["listing_ids"]) > 0) {
    			$listing_obj = $listing_obj->whereIn('id', $filters["listing_ids"]);
    		}

    		if(isset($filters["listing_status"]) && sizeof($filters["listing_status"]) > 0) { // If list of listing_status is selected, then
    			//$listing_obj = $listing_obj->orWhere($value_listing, true); // 'verified' => true || 'premium' => 'true'
    			$listing_status = $filters["listing_status"];
				$listing_obj = $listing_obj->where(function($query) use ($listing_status){
					foreach ($listing_status as $key_listing => $value_listing) {
						$query->orWhere($value_listing, true);// 'verified' => true || 'premium' => 'true'
					}
				});
    		}

    		if(isset($filters["ratings"]) && sizeof($filters["ratings"]) > 0) { // If list of ratings are selected, then
    			$listing_obj = $listing_obj->whereIn('rating', $filters["ratings"]); // [1 - 5 star]
    		}

	    	$filtered_count = $listing_obj->distinct('id')->count('id');
	    	
	    	$listing_obj = $listing_obj->orderBy('premium', 'desc')->orderBy($sort_by, $sort_order)->skip(($start - 1) * $page_limit)->take($page_limit)->get(['id', 'title', 'status', 'verified', 'type', 'published_on', 'locality_id', 'display_address', 'premium', 'slug', 'updated_at']);// , 'rating']);

	    	$listing_obj = $listing_obj->each(function($list){ // Get following data for each list
	    		$list["area"] = $list->location()->where('status', 1)->get(["id", "name", "slug", "city_id"])->first(); // Get the Primary area
	    		$list["city"] = ($list["area"]) ? $list['area']->city()->get(["id", "name", "slug"])->first() : "";

	    		// $list["status"] = Listing::listing_status[$list["status"]]; // Get the string of the Listing Status
	    		// $list["business_type"]['name'] = Listing::listing_business_type[$list["type"]]; // Get the string of the Listing Type

                $list["business_type"] = ['name' => Listing::listing_business_type[$list["type"]], 'slug' => Listing::listing_business_type_slug[$list["type"]]];

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

                $recent_update_obj = DB::table('updates')->where([["object_type", "App\Listing"], ['object_id', $list->id], ['deleted_at', null]])->orderBy('updated_at', "desc")->get();// Update::where([["object_type", "App\Listing"], ['object_id', $list->id]])->orderBy('updated_at', "desc")->get();
                $list["recent_updates"] = $recent_update_obj->count() > 0 ? $recent_update_obj->first() : null;

	    		//$list["categories"] = ListingCategory::getCategories($list->id); // Get list of all the categories & it's respective Parent & branch node
	    		
	    		// Fetches the list of all the Core categories & it's details
	    		$list["cores"] = Category::whereIn('id', ListingCategory::where([['listing_id', $list->id],['core',1]])->pluck('category_id')->toArray())->get(['id', 'name', 'slug', 'level', 'order'])->each(function($cat_obj) {
                        $cat_obj["node_categories"] = $this->getCategoryNodeArray($cat_obj, "slug", false);
                });

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
    	$status = 200; $filter_filters = [];
    	$filter_mapping = array("published" => "updated_at", "rank" => "", "views" => "views_count");

    	$output = new ConsoleOutput;
    	//$output->writeln(json_encode($request->all()));

    	if($request->has("filters")) {
    		$filters = $request->filters;
    		$filters["categories"] = [];
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
                $listing_business_obj = Listing::where('slug', $request->filters["business_search"])->get();
                if($listing_business_obj->count() > 0) {
                    $listing_business_obj = $listing_business_obj->first();
                    if(!isset($filters["listing_ids"])) {
                        $filters["listing_ids"] = [$listing_business_obj->id];
                    } else {
                        array_push($filters["listing_ids"], $listing_business_obj->id);
                    }
                }
            }

    		// If a Category is selected from the List from the Search box
    		if(isset($request->filters["category_search"])) {
    			$category_search_filter = json_decode(explode("|", $request->filters["category_search"])[1]);// Get the Node_categories list
    			if(isset($filters["categories"])) {
    				$filters["categories"] = array_merge($filters["categories"], is_array($category_search_filter) ? $category_search_filter : [$category_search_filter]);
    			} else {
    				$filters["categories"] = is_array($category_search_filter) ? $category_search_filter : [$category_search_filter];
    			}

    			$filter_filters["category"] = array("id" => explode("|", $request->filters["category_search"])[0]);
    		}

    		// If a Category is selected from the List on the Left-hand side
    		if(isset($request->filters["categories"])) {
    			$filter_filters["category"] = array("slug" => explode("|", $request->filters["categories"])[0]);
    			$category_search_filter = json_decode(explode("|", $request->filters["categories"])[1]);// Get the Node_categories list

    			/*if($filter_filters["category"]["id"] > 0 && sizeof($category_search_filter) <= 0) {
    				$category_search_filter = [0];
    			}*/

    			if(isset($filters["categories"])) {
    				$filters["categories"] = array_merge($filters["categories"], is_array($category_search_filter) ? $category_search_filter : [$category_search_filter]);
    			} else {
    				$filters["categories"] = is_array($category_search_filter) ? $category_search_filter : [$category_search_filter];
    			}
    		} else {
    			if(!isset($filter_filters["category"])) {
    				$filter_filters["category"] = array("slug" => "");
	    			$filters["categories"] = [];
	    		}
    		}

    		if(isset($request->filters["listing_status"]) && $request->filters["listing_status"]) {
				$filters["listing_status"] = json_decode($request->listing_status);
			} else {
				$filters["listing_status"] = [];
			}

			// If 1 or more areas are selected then update the list
    		if(isset($request->filters["areas_selected"])) {
    			$area_search_filter = $request->filters["areas_selected"];// Get the Node_categories list

    			if(isset($filters["areas"])) {
    				$filters["areas"] = array_merge($filters["areas"], is_array($area_search_filter) ? $area_search_filter : [$area_search_filter]);
    			} else {
    				$filters["areas"] = is_array($area_search_filter) ? $area_search_filter : [$area_search_filter];
    			}
    			
    			$filter_filters["areas_selected"] = $area_search_filter;
    		}

    		if($request->has("area") && $request->area) {
    			if(isset($filters["areas"])) {
    				$filters["areas"] = array_push($filters["areas"], $request->area);
    			} else {
    				$filters["areas"] = [$request->area];
    			}
    			
    			if(isset($filter_filters["areas_selected"])) {
    				$filter_filters["areas_selected"] = array_push($filter_filters["areas_selected"], $request->area);
    			} else {
    				$filter_filters["areas_selected"] = [$request->area];
    			}
    		}

    		if(isset($request->filters["business_types"]) && $request->filters["business_types"]) {
    			$filters["business_type"] = $request->filters["business_types"];
    			$filter_filters["business_type"] = $request->filters["business_types"];
    		} else {
    			$filters["business_type"] = [];
    			$filter_filters["business_type"] = [];
    		}

    		// If 1 or more listing_statuses are selected then update the list
    		if(isset($request->filters["listing_status"])) {
    			$listing_search_filter = $request->filters["listing_status"];// Get the Node_categories list

    			if(isset($filters["listing_status"])) {
    				$filters["listing_status"] = array_merge($filters["listing_status"], is_array($listing_search_filter) ? $listing_search_filter : [$listing_search_filter]);
    			} else {
    				$filters["listing_status"] = is_array($listing_search_filter) ? $listing_search_filter : [$listing_search_filter];
    			}
    			
    			$filter_filters["listing_status"] = $filters["listing_status"];
    		}
    	}

    	$filtered_list_response = $this->getListingSummaryData($city, $filters, $start, $page_size, $sort_by, $sort_order); // Get list of all the data
    	$listing_data = $filtered_list_response["data"];
    	$list_view_html = View::make('list-view.single-card.listing_card')->with(compact('listing_data'))->render();

    	if($request->has('state') && $request->state && (City::where('slug', $request->state)->count() > 0 || Area::where('slug', request()->state)->count() > 0)) {
    		$filter_filters["state"] = $request->state;
    		$city = $request->state;
    	} else if(City::where('slug', $city)->count() > 0) {
    		$filter_filters["state"] = $city;
    	} else if(Area::where('slug', $city)->count() > 0) {
    		$filter_filters["state"] = $city;
    		if(isset($filter_filters["areas_selected"]) && sizeof($filter_filters["areas_selected"]) > 0) {
    			$filter_filters["areas_selected"] = array_merge($filter_filters["areas_selected"], [$city]);
    		} else {
    			$filter_filters["areas_selected"] = [$city];
    		}
    	} else {
    		$filter_filters["state"] = "";
    	}

    	//$output->writeln(json_encode($filter_filters));

    	/* Get the Filter DOM template */
    	$filter_view_html = $this->getListFilterData($filter_filters, true);

    	/* Get the Pagination DOM template */
    	$paginate = pagination(intVal($filtered_list_response["filtered_count"]), intVal($filtered_list_response["start"]), intVal($filtered_list_response["page_limit"]));

    	return response()->json(array("data" => ["list_view" => $list_view_html, "filter_view" => $filter_view_html, "paginate" => $paginate], "count" => $filtered_list_response["filtered_count"], "page" => $filtered_list_response["start"], "page_size" => $filtered_list_response["page_limit"]), $status);
    }
}