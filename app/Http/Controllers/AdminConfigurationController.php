<?php

namespace App\Http\Controllers;

use App\User;
use App\Area;
use App\Category;
use App\City;
use App\Common;
use App\Listing;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Controllers\CommonController;
use Ajency\User\Ajency\userauth\UserAuth;
use Symfony\Component\Console\Output\ConsoleOutput;

use App\Job;
use App\Company;
use App\UserCommunication;

class AdminConfigurationController extends Controller
{
    public function __construct()
    {
        Common::authenticate('dashboard', $this);
    }

    public function locationView(Request $request)
    {
        $cities = City::orderBy('order')->orderBy('name')->get();
        return view('admin-dashboard.location')->with('cities', $cities);
    }
    public function categoriesView(Request $request)
    {
        $parents  = Category::where('type','listing')->where('level', '1')->orderBy('order')->orderBy('name')->get();
        $branches = Category::where('type','listing')->where('level', '2')->orderBy('order')->orderBy('name')->get();
        return view('admin-dashboard.categories')->with('parents', $parents)->with('branches', $branches);
    }
    public function getCities(Request $request)
    {
        $cities = City::orderBy('order')->orderBy('name')->get();
        return response()->json($cities);
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
        if ($request->type == 0) {
            if (City::where('slug', $request->slug)->where('id', '!=', $request->city_id)->count() != "0") {
                return response()->json(array("status" => "400", "msg" => "City with same slug exists", "data" => array()));
            }

            if (City::where('name', $request->name)->where('id', '!=', $request->city_id)->count() != "0") {
                return response()->json(array("status" => "400", "msg" => "City with same name exists", "data" => array()));
            }
            if ($request->city_id == '') {
                $city         = new City;
                $city->status = "0";
                $city->slug   = $request->slug;
            } else {
                $city = City::find($request->city_id);
                if ($city->status == "0" and $request->status == "2") {
                    return response()->json(array("status" => "400", "msg" => "You cannot archive a draft location", "data" => array()));
                }
                if ($city->status != "0" and $request->status == "0") {
                    return response()->json(array("status" => "400", "msg" => "Once the location is published, It cannot be made draft", "data" => array()));
                }

                if ($city->status != "0" and $city->slug != $request->slug) {
                    return response()->json(array("status" => "400", "msg" => "slug can be edited only in draft", "data" => array()));
                }
                $city->slug = $request->slug;
            }
            if ($request->status == "1") {
                $city->published_date = Carbon::now()->toDateTimeString();
            }
            $city->status = $request->status;
            $city->name   = $request->name;
            $city->order  = $request->sort_order;
            $city->save();
            $city = City::find($city->id);
            return response()->json(array("status" => "200", "msg" => "City saved successfully", "data" => $city));
        } else {
            if ($request->city_id == '') {
                return response()->json(array("status" => "400", "msg" => "City required to save area", "data" => array()));
            }
            if (Area::where('slug', $request->slug)->where('id', '!=', $request->area_id)->count() != "0") {
                return response()->json(array("status" => "400", "msg" => "Area with same slug exists", "data" => array()));
            }
            if (Area::where('name', $request->name)->where('id', '!=', $request->area_id)->where('city_id', $request->city_id)->count() != "0") {
                return response()->json(array("status" => "400", "msg" => "Area with same name exists", "data" => array()));
            }
            if ($request->area_id == '') {
                $area          = new Area;
                $area->status  = "0";
                $area->slug    = $request->slug;
                $area->city_id = $request->city_id;
            } else {
                $area = Area::find($request->area_id);
                if ($area->status == "0" and $request->status == "2") {
                    return response()->json(array("status" => "412", "msg" => "You cannot archive a draft area", "data" => array()));
                }
                if ($area->status != "0" and $request->status == "0") {
                    return response()->json(array("status" => "400", "msg" => "Once the location is published, It cannot be made draft", "data" => array()));
                }

                if ($area->status != "0" and $area->slug != $request->slug) {
                    return response()->json(array("status" => "400", "msg" => "Slug can be edited only in draft", "data" => array()));
                }
                $area->slug = $request->slug;
                if ($area->status != "0" and $area->city_id != $request->city_id) {
                    return response()->json(array("status" => "400", "msg" => "you cannot change city after publishing", "data" => array()));
                }
                $area->city_id = $request->city_id;
            }
            if ($request->status == "1") {
                $area->published_date = Carbon::now()->toDateTimeString();
            }

            $area->status = $request->status;
            $area->name   = $request->name;
            $area->order  = $request->sort_order;
            if($request->status == "2") $area->archieve();
            $area->save();
            $area = Area::with('city')->find($area->id);
            return response()->json(array("status" => "200", "msg" => "area saved successfully", "data" => $area));
        }
    }
    public function categConfigList(Request $request)
    {
        $status     = array("0" => "Draft", "1" => "Published", "2" => "Archived");
        $categories = Category::where('type','listing')->get();
        $data       = array();
        foreach ($categories as $category) {
            $pub                 = ($category->published_date != null) ? $category->published_date->toDateTimeString() : "";
            $data[$category->id] = array(
                "#"          => '<a href="#"><i class="fa fa-pencil"></i></a>',
                "slug"       => $category->slug,
                "name"       => $category->name,
                "sort_order" => $category->order,
                "update"     => $category->updated_at->toDateTimeString(),
                "publish"    => $pub,
                "status"     => $status[$category->status],
                "id"         => $category->id,
                "level"      => $category->level,
                "parent_id"  => "",
                "branch_id"  => "",
                "name_data"  => $category->name,
                "image_url"  => $category->icon_url,
            );
            if ($category->level == "1") {
                $data[$category->id]['isParent'] = "<i class=\"fa fa-check text-success\"></i><span class=\"hidden\">Yes</span>";
                $data[$category->id]['isBranch'] = "-<span class=\"hidden\">no</span>";
                $data[$category->id]['isNode']   = "-<span class=\"hidden\">no</span>";
                $data[$category->id]['parent']   = "";
                $data[$category->id]['branch']   = "";
                $data[$category->id]['name']     = $category->name . '<img src="' . $category->icon_url . '" class="img-circle m-l-20" width="35">';
            }
            if ($category->level == "2") {
                $data[$category->id]['isParent']  = "-<span class=\"hidden\">no</span>";
                $data[$category->id]['isBranch']  = "<i class=\"fa fa-check text-success\"></i><span class=\"hidden\">Yes</span>";
                $data[$category->id]['isNode']    = "-<span class=\"hidden\">no</span>";
                $data[$category->id]['parent']    = $data[$category->parent_id]['name_data'];
                $data[$category->id]['branch']    = "";
                $data[$category->id]['parent_id'] = $data[$category->parent_id]['id'];
            }
            if ($category->level == "3") {
                $data[$category->id]['isParent']  = "-<span class=\"hidden\">no</span>";
                $data[$category->id]['isBranch']  = "-<span class=\"hidden\">no</span>";
                $data[$category->id]['isNode']    = "<i class=\"fa fa-check text-success\"></i><span class=\"hidden\">Yes</span>";
                $data[$category->id]['parent']    = $data[$data[$category->parent_id]['parent_id']]['name_data'];
                $data[$category->id]['branch']    = $data[$category->parent_id]['name'];
                $data[$category->id]['parent_id'] = $data[$category->parent_id]['parent_id'];
                $data[$category->id]['branch_id'] = $data[$category->parent_id]['id'];
            }
        }
        // print_r($data);
        $data1 = array();
        foreach ($data as $category) {
            $data1[] = $category;
        }
        return response()->json(array("data" => $data1));
    }

    public function listLocationConfig(Request $request)
    {
        $status = array("0" => "Draft", "1" => "Published", "2" => "Archived");
        $cities = City::all();
        $data   = array();
        foreach ($cities as $city) {
            $pub    = ($city->published_date != null) ? $city->published_date->toDateTimeString() : "";
            $data[] = array(
                "#"          => "<a href=\"#\"><i class=\"fa fa-pencil\"></i></a>",
                "slug"       => $city->slug,
                "name"       => $city->name,
                "isCity"     => "<i class=\"fa fa-check text-success\"></i><span class=\"hidden\">Yes</span>",
                "isArea"     => "-<span class=\"hidden\">no</span>",
                "city"       => "",
                "sort_order" => $city->order,
                "update"     => $city->updated_at->toDateTimeString(),
                "publish"    => $pub,
                "status"     => $status[$city->status],
                "id"         => $city->id,
                "area"       => "0",
                "city_id"    => "",

            );
        }
        $areas = Area::with('city')->get();
        foreach ($areas as $area) {
            $pub    = ($area->published_date != null) ? $area->published_date->toDateTimeString() : "";
            $data[] = array(
                "#"          => "<a href=\"#\"><i class=\"fa fa-pencil\"></i></a>",
                "slug"       => $area->slug,
                "name"       => $area->name,
                "isCity"     => "-<span class=\"hidden\">no</span>",
                "isArea"     => "<i class=\"fa fa-check text-success\"></i><span class=\"hidden\">Yes</span>",
                "city"       => $area->city['name'],
                "sort_order" => $area->order,
                "update"     => $area->updated_at->toDateTimeString(),
                "publish"    => $pub,
                "status"     => $status[$area->status],
                "id"         => $area->id,
                "area"       => "1",
                "city_id"    => $area->city['id'],

            );
        }
        return response()->json(array("data" => $data));
    }

    public function hasListing(Request $request)
    {
        $this->validate($request, [
            'type'    => 'required|boolean',
            'area_id' => 'nullable|integer',
            'city_id' => 'integer',
        ]);
        if ($request->type == "1") {
            $count = Area::find($request->area_id)->listings()->count();
            if ($count > 0) {
                return response()->json(array("warning" => "This city has listings associated with it. Click here to view the listings.<br>You can archive this city only once this is removed from all the listings."));
            }
        } else {
            $areas = City::find($request->city_id)->areas()->get();
            $count = City::find($request->city_id)->areas()->where('status', '1')->count();
            // echo $areas;
            foreach ($areas as $area) {
                // echo $area;
                $count += Area::find($area->id)->listings()->count();
            }
            if ($count > 0) {
                return response()->json(array("warning" => "This area has listings associated with it. Click here to view the listings.<br>You can archive this area only once this is removed from all the listings."));
            }
        }

        return response()->json(array("warning" => false));

    }

    public function hasPublishedAreas(Request $request)
    {
        $this->validate($request, [
            'city_id' => 'required|integer',
        ]);
        $count = City::find($request->city_id)->areas()->where('status', '1')->count();
        if ($count > 0) {
            return response()->json(true);
        } else {
            return response()->json(false);
        }

    }

    public function getAssociatedListings(Request $request)
    {
        $this->validate($request, [
            'category' => 'required|json',
            'location' => 'required|json',
        ]);
        $list          = array();
        $categories    = json_decode($request->category);
        $categSibCount = array();
        foreach ($categories as $category) {
            if ($category->type == "1") {
                $branches = Category::where('type','listing')->where('parent_id', $category->id)->get();
                foreach ($branches as $branch) {
                    $nodes = Category::where('type','listing')->where('parent_id', $branch->id)->get();
                    foreach ($nodes as $node) {
                        $listings = Category::find($node->id)->listing()->get();
                        foreach ($listings as $listing) {
                            $list[$listing->id] = ["ref" => $listing->reference];
                        }
                    }
                }
                $categSibCount[$category->id] = array();
            }
            if ($category->type == "2") {
                $nodes = Category::where('type','listing')->where('parent_id', $category->id)->get();
                foreach ($nodes as $node) {
                    $listings = Category::find($node->id)->listing()->get();
                    foreach ($listings as $listing) {
                        $list[$listing->id] = ["ref" => $listing->reference];
                    }
                }
                $count                        = Category::find($category->id)->siblingCount();
                $categSibCount[$category->id] = array('branch' => $count);
            }
            if ($category->type == "3") {
                $listings = Category::find($category->id)->listing()->get();
                // dd($listings);
                foreach ($listings as $listing) {
                    $list[$listing->id] = ["ref" => $listing->reference];
                }
                $count                        = Category::find($category->id)->siblingCount();
                $p_count                      = Category::find(Category::find($category->id)->parent_id)->siblingCount();
                $categSibCount[$category->id] = array('node' => $count, 'branch' => $p_count);
            }
        }
        $categ_list   = $list;
        $list         = array();
        $locations    = json_decode($request->location);
        $areaSibCount = array();
        foreach ($locations as $location) {
            if ($location->type == "city") {
                $areas = City::find($location->id)->areas()->get();
                foreach ($areas as $area) {
                    $listings = Area::find($area->id)->listings()->get();
                    foreach ($listings as $listing) {
                        $list[$listing->id] = ["ref" => $listing->reference];
                    }
                }
            }
            if ($location->type == "area") {
                $listings = Area::find($location->id)->listings()->get();
                foreach ($listings as $listing) {
                    $list[$listing->id] = ["ref" => $listing->reference];
                }
                $count        = Area::find($location->id)->siblingCount();
                $areaSibCount = array('areas' => $count);
            }
        }
        $loc_list = $list;
        if (count($categories) == 0) {
            $list = $loc_list;
        } else if (count($locations) == 0) {
            $list = $categ_list;
        } else {
            $list = array_intersect_key($categ_list, $loc_list);
        }

        return response()->json(array('status' => 'success', 'msg' => "", "data" => array("listings" => $list, "category_sibling_count" => $categSibCount, 'area_sibling_count' => $areaSibCount)));
    }

    public function saveCategory(Request $request)
    {
        $this->validate($request, [
            'level'      => 'required|integer|min:1|max:3',
            'id'         => 'nullable|integer',
            'parent_id'  => 'nullable|integer',
            'name'       => 'required|string|max:255',
            'slug'       => 'required|string|max:255',
            'sort_order' => 'required|integer',
            'status'     => 'required|integer|min:0|max:2',
            
        ]);
        // dd($request);
        if ($request->id != '') {
            if (!Common::verify_id($request->id, 'categories')) {
                return response()->json(array("status" => "404", "msg" => "category not found", "data" => array()));
            }
        }
        if ($request->level != "1") {
            if (!Common::verify_id($request->parent_id, 'categories')) {
                return response()->json(array("status" => "404", "msg" => "parent category not found", "data" => array()));
            }
        }
        // dd(Category::where('slug', $request->slug)->where('id', '!=', $request->id)->count());
        if (Category::where('slug', $request->slug)->where('id', '!=', $request->id)->count() != "0") {
            return response()->json(array("status" => "400", "msg" => "Category with same slug exists", "data" => array()));
        }

        if (Category::where('name', $request->name)->where('id', '!=', $request->id)->where('parent_id', $request->parent_id)->count() != "0") {
            return response()->json(array("status" => "400", "msg" => "Category with same name exists", "data" => array()));
        }
        if ($request->id == '') {
            $category         = new Category;
            $category->status = "0";
            $category->type = 'listing';
            $category->level  = $request->level;
        } else {
            $category = Category::find($request->id);
        }
        if ($category->status == "0") {
            $category->slug = $request->slug;
            if ($category->level != "1") {
                $category->parent_id = $request->parent_id;
                $category->path      = Category::find($category->parent_id)->path . str_pad($category->parent_id, 5, '0', STR_PAD_LEFT);
            }
        }
        $category->name     = $request->name;
        $category->order    = $request->sort_order;
        // $category->icon_url = $request->image_url;
        // dd(isset($request->image) and $request->image!='undefined');

        $message            = $category->saveStatus($request->status);
        if ($message != true) {
            return response()->json(array("status" => "400", "msg" => $message, "data" => array()));
        }

        $category->save();
        if(isset($request->image) and $request->image!='undefined'){
            $photoId = $category->uploadImage($request->file('image'),false);  
            $category->remapImages([$photoId]);
            $cat_image = $category->getImages();
            foreach($cat_image as $img){
                $category->icon_url = $img['65x65'];    
            }
            $category->save(); 
        }
        $category = Category::find($category->id);
        $parents  = Category::where('type','listing')->where('level', '1')->orderBy('order')->orderBy('name')->get();
        $branches = Category::where('type','listing')->where('level', '2')->orderBy('order')->orderBy('name')->get();
        return response()->json(array("status" => "200", "msg" => "", "data" => array("item" => $category, "other_data" => array("parents" => $parents, "branches" => $branches))));
    }
    public function getBranches(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|integer',
        ]);
        if (!Common::verify_id($request->id, 'categories')) {
            return response()->json(array("status" => "404", "msg" => "category not found", "data" => array()));
        }
        $branches = Category::where('type','listing')->where('parent_id', $request->id)->orderBy('order')->orderBy('name')->get();
        return response()->json(array("status" => "200", "msg" => "", "data" => $branches));
    }
    public function checkCategStatus(Request $request)
    {
        $this->validate($request, [
            'id'     => 'required|integer',
            'status' => 'required|integer|min:0|max:2',
        ]);
        if (!Common::verify_id($request->id, 'categories')) {
            return response()->json(array("status" => "404", "msg" => "category not found", "data" => array()));
        }
        $category = Category::find($request->id);
        if ($request->status == '1' and $category->level != '3') {
            $x = $category->isPublishable();
            if ($x === true) {
                return response()->json(array("status" => "200", "msg" => "", "data" => array('continue' => true)));
            } else {
                return response()->json(array("status" => "400", "msg" => "", "data" => array('continue' => false, 'message' => $x)));
            }
        }
        if ($request->status == '2') {
            $x = $category->isArchivable();
            if ($x === true) {
                return response()->json(array("status" => "200", "msg" => "", "data" => array('continue' => true)));
            } else {
                return $x;
            }
        }
        return response()->json(array("status" => "200", "msg" => "", "data" => array('continue' => true)));
    }
    public function checkLocStatus(Request $request)
    {
        $this->validate($request, [
            'id'     => 'required|integer',
            'status' => 'required|integer|min:0|max:2',
            'type'   => 'required|boolean',
        ]);
        if ($request->type == "1") {
            if (!Common::verify_id($request->id, 'areas')) {
                return response()->json(array("status" => "404", "msg" => "area not found", "data" => array()));
            }
            if ($request->status == "1") {
                return response()->json(array("status" => "200", "msg" => "", "data" => array('response' => true, 'message' => "")));
            }

            if ($request->status == "2") {
                $area = Area::find($request->id);
                // dd($area->isArchivable());
                return response()->json(array("status" => "200", "msg" => "", "data" => $area->isArchivable()));
            }
            return response()->json(array("status" => "200", "msg" => "", "data" => array('response' => true, 'message' => "")));
        } else {
            if (!Common::verify_id($request->id, 'cities')) {
                return response()->json(array("status" => "404", "msg" => "city not found", "data" => array()));
            }
            if ($request->status == "1") {
                $city = City::find($request->id);
                return response()->json(array("status" => "200", "msg" => "", "data" => $city->isPublishable()));
            }
            if ($request->status == "2") {
                $city = City::find($request->id);
                // dd($city->isArchivable());
                return response()->json(array("status" => "200", "msg" => "", "data" => $city->isArchivable()));
            }
            return response()->json(array("status" => "200", "msg" => "", "data" => array('response' => true, 'message' => "")));
        }

    }

    public function internalUserView(Request $request) {
        $status = User::userStatuses();
        return view('admin-dashboard.internal_users')->with(compact('status'));
    }

    

    /**
    * This function is a GET request & is used to get the Internal / External User data
    *
    * This function @return
    * 
    */
    public function getUserData(Request $request) {
        $response_data = []; $common_obj = new CommonController;
        $output = new ConsoleOutput;
        $userauth_obj = new UserAuth; $status = 200;

        if ($request->has('filters') && isset($request->filters["user_type"])) {
            $user_obj = User::where("type", $request->filters["user_type"])->get();
        } else {
            $user_obj = User::where("type", "external")->get();
        }

        try {
            $total_count = $user_obj->count();
            $filtered_count = $total_count;

            foreach($user_obj as $obj_key => $obj_val) {
                $ui_data = array("display" => "<i class=\"fa fa-pencil\"></i>", "href_url" => "#");
                $data_tag = array("data-toggle" => "modal", "data-target" => "#add_newuser_modal");
                $columns_html = []; $roles = '';

                //$columns_html = "<td class=\"sorting_1\">" . $common_obj->generateHtml("anchor", "editUser", "", "", $ui_data, $data_tag) . "</td><td>" . $obj_val->name . "</td><td>" . implode(", ", $userauth_obj->getAllUserRoles($obj_val, false)["roles"]) . "</td><td>" . $obj_val->status . "</td>";

                if(isset($userauth_obj->getAllUserRoles($obj_val, false)["roles"])) {
                    foreach ($userauth_obj->getAllUserRoles($obj_val, false)["roles"] as $key_role => $value_role) {
                        if($key_role !== 0) {
                            $roles .= ", ";
                        }
                        $roles .= ucfirst($value_role); // Make 1st character UpperCase
                    }
                }

                $columns_html["edit"] = $common_obj->generateHtml("anchor", "editUser", $obj_val->id, "", $ui_data, $data_tag)["html"];

                $columns_html["name"] = $obj_val->name;
                $columns_html["email"] = ($obj_val->getPrimaryEmail()) ? $obj_val->getPrimaryEmail() : $obj_val->email;
                $columns_html["roles"] = $roles;//implode(", ", $userauth_obj->getAllUserRoles($obj_val, false)["roles"]);
                $columns_html["status"] = ucfirst($obj_val->status);

                //$row_html = "<tr role=\"row\" class=\"" . ((($obj_key + 1) % 2) == 1 ? "odd" : "even") . "\">" . $columns_html . "</tr>"; // Generate table row
                array_push($response_data, $columns_html);
            }
        } catch (Exception $e) {
            $status = 400;
            $output->writeln("error: " . json_encode($e));
        }

        $result_output = array(
            #"draw" => 1,
            "data" => $response_data,
            "recordsTotal" => $total_count,
            "recordsFiltered" => $filtered_count
        );

        return response()->json($result_output, $status);
    }

    /**
    * This function is a POST request & is used to add the Internal / External User data
    *
    * This function @return
    * 
    */
    public function addNewUser(Request $request) {
        $status = 201; $response_data = [];
        $userauth_obj = new UserAuth;

        $output = new ConsoleOutput;

        $request = $request->all();

        $user_data = array("name" => $request["name"], "username" => $request["email"], "email" => $request["email"], "has_required_fields_filled" => true, "type" => "internal", "provider" => "added_by_internal");
        $user_comm = array("email" => $request["email"], "is_verified" => true);
        
        if(isset($request["password"]) && $request["password"] == $request["confirm_password"]) {
            $user_data["password"] = $request["password"];
        } else if (isset($request["password"]) && $request["password"] !== $request["confirm_password"]) {
            $status = 406;
            $response_data = array("message" => "password_and_confirm_not_matching");
        }

        if(isset($request["roles"]) && sizeof($request["roles"]) > 0) {
            $user_data["roles"] = $request["roles"][0];
        }
        
        if($request["status"]) {
            $user_data["status"] = $request["status"];
        }


        $user_obj_response = $userauth_obj->checkIfUserExists($user_data);

        if(!$user_obj_response && $status == 201) { // If user doesn't exist then create user, else
            $create_response = $userauth_obj->updateOrCreateUser($user_data, [], $user_comm);
            
            $userRoles = $create_response['user']->getRoleNames()->toArray();
          
            $userEmail = $request["email"];
            $userEmail = 'prajay@ajency.in';
            $data = [];
            $data['from'] = config('constants.email_from'); 
            $data['name'] = config('constants.email_from_name');
            $data['to'] = [$userEmail];
            $data['cc'] = 'prajay@ajency.in';
            $data['subject'] = "You are added as internal user on FnB Circle.";
            $data['template_data'] = ['request' => $request,'userRoles' => $userRoles];
            sendEmail('register-internal-user', $data);

            $output->writeln(json_encode($create_response));
            $status = 201;
        } else {
            $status = 406; ## Not Acceptable
            if(sizeof($response_data) <= 0) {
                $response_data = array("message" => "email_exist");
            }
        }

        


        return response()->json($response_data, $status);
    }

    /**
    * This function is a POST request & is used to update the Internal / External User data
    *
    * This function @return
    * 
    */
    public function editCurrentUser(Request $request, $username) { 
        $status = 200; $response_data = [];
        $userauth_obj = new UserAuth;
        $request = $request->all();

        if($username) {
            $user_obj = User::find($username)->first();

            $user_data = array("name" => $request["name"], "username" => $user_obj->email, "email" => $request["email"], "has_required_fields_filled" => true);
            $user_comm = array("email" => $request["email"], "is_verified" => true);
            if(isset($request["roles"]) && sizeof($request["roles"]) > 0) {
                $user_data["roles"] = $request["roles"][0];
            }
            
            if($request["status"]) {
                $user_data["status"] = $request["status"];
            }

            $userauth_obj->updateOrCreateUser($user_data, [], $user_comm);
            $user_comm_obj = $user_obj->getUserCommunications()->get();
            $response_data = array("message" => "success");
        } else {
            $status = 406; ## Not Acceptable
            $response_data = array("message" => "fail");
        }

        return response()->json($response_data, $status);
    }


    public function registeredUserView() {
        $cities = City::where('status', 1)->orderBy('order')->orderBy('name')->get();
        $areas = Area::where('status', 1)->orderBy('order')->orderBy('name')->get();
        return view('admin-dashboard.registered_users')->with('cities', $cities)->with('areas', $areas);
    }

    public function getRegisteredUsers(Request $request){
        $requestData = $request->all(); 
        $data =[];
        $skip = $requestData['start'];
        $length = $requestData['length'];
        $orderValue = $requestData['order'][0];
      
       
        $columnOrder = array( 
                                        '0'=> 'jobs.id',
                                        '2'=> 'jobs.title',
                                        '3'=> 'categories.name',
                                        '5'=> 'companies.title',
                                        '6'=> 'jobs.date_of_submission',
                                        '7'=> 'jobs.published_on',
                                        '8'=> 'jobs.updated_at'
                                        );

        
        $userQuery = User::select('users.*')->where('users.type','external')->join('user_details', 'user_details.user_id', '=', 'users.id');

        if($requestData['filters']['user_name']!="")
        {
  
            $userQuery->where('users.name','like','%'.$requestData['filters']['user_name'].'%');
        }
 
        if(isset($requestData['filters']['registration_type']) && !empty($requestData['filters']['registration_type']))
        {
  
            $userQuery->whereIn('users.signup_source',$requestData['filters']['registration_type']);
        }

        if(isset($requestData['filters']['state']) && !empty($requestData['filters']['state']))
        {
  
            $userQuery->whereIn('user_details.city',$requestData['filters']['state']);
        }

        if(isset($requestData['filters']['city']) && !empty($requestData['filters']['city']))
        {
  
            $userQuery->whereIn('user_details.area',$requestData['filters']['city']);
        }

        if($requestData['filters']['user_email']!="")
        {
            $usersIds = UserCommunication:: where('value','like','%'.$requestData['filters']['user_email'].'%')->where('object_type','App\User')->where('is_primary','1')->where('type','email') ->pluck('object_id')->toArray(); 

            $userQuery->whereIn('users.id',$usersIds);
        }

        if($requestData['filters']['user_phone']!="")
        {
            $usersIds = UserCommunication:: where('value','like','%'.$requestData['filters']['user_phone'].'%')->where('object_type','App\User')->where('is_primary','1')->where('type','mobile') ->pluck('object_id')->toArray(); 

            $userQuery->whereIn('users.id',$usersIds);
        }

        if(isset($requestData['filters']['user_status']) && !empty($requestData['filters']['user_status']))
        {
            $userQuery->whereIn('users.status',$requestData['filters']['user_status']);
        }

        
        if(isset($requestData['filters']['user_created_from']) && !empty($requestData['filters']['user_created_from']) && !empty($requestData['filters']['user_created_to']))
        { 
            $userQuery->where('users.created_at','>=',$requestData['filters']['user_created_from'].' 00:00:00'); 
            $userQuery->where('users.created_at','<=',$requestData['filters']['user_created_to'].' 23:59:59');
        }

        if(isset($requestData['filters']['last_login_from']) && !empty($requestData['filters']['last_login_from']) &&  !empty($requestData['filters']['last_login_to']))
        {
            $userQuery->where('users.last_login','>=',$requestData['filters']['last_login_from'].' 00:00:00'); 
            $userQuery->where('users.last_login','<=',$requestData['filters']['last_login_to'].' 23:59:59');
        }

         

        $columnName = 'users.created_at';
        $orderBy = 'desc';
        
        
        
        // if(isset($columnOrder[$orderValue['column']]))
        // {   
        //     $columnName = $columnOrder[$orderValue['column']];
        //     $orderBy = $orderValue['dir'];
        // }


        if($length>1)
        {  
            $totalUsers = $userQuery->get()->count(); 
            $users = $userQuery->orderBy($columnName,$orderBy)->skip($skip)->take($length)->get();   
        }
        else
        {
            $users    = $userQuery->orderBy($columnName,$orderBy)->get();  
            $totalUsers = $users->count();  
        }


        $usersData = [];
        $sourceType = ['email_signup'=>'Email signup','google'=>'Google','facebook'=>'Facebook'];
        foreach ($users as $key => $user) {
         
            $userDetails = $user->getUserDetails; 
            $subTypes = $userDetails->getSavedUserSubTypes();
            
            $usersData[] = [ 
                            'name' => '<a href="/profile/basic-details/'.$user->getPrimaryEmail().'">'.$user->name.'</a>',
                            'type' => $sourceType[$user->signup_source],
                            'email' => $user->getPrimaryEmail(),
                            'phone' => (!empty($user->getPrimaryContact())) ? '+('.$user->getPrimaryContact()['contact_region'].')'.$user->getPrimaryContact()['contact'] : '',
                            'describe' => implode(', ', $subTypes),
                            'state' => (!empty($userDetails) && $userDetails->city) ? $userDetails->userCity->name :'',
                            'city' => (!empty($userDetails) && $userDetails->area) ? $userDetails->userArea->name :'',
                            'date_created' => $user->created_at->toDateTimeString(),
                            'last_login' => ($user->last_login!=null)? $user->last_login->toDateTimeString():"",
                            'total_listing' => $user->listing()->count() ,
                            'published_listing' =>  $user->listing()->where('status','3')->count(),
                            'total_jobs' =>  $user->jobs()->where('status','3')->count(),
                            'published_jobs' =>  $user->jobs()->where('status','3')->count(),
                            'job_applied' =>  '',
                            'resume_uploaded' =>  ($userDetails->resume_id)?'Yes':'No',
                            'status' =>  ucwords($user->status),
                            ];
            
        }

        $json_data = array(
                "draw"            => intval( $requestData['draw'] ),
                "recordsTotal"    => intval( $totalUsers ),
                "recordsFiltered" => intval( $totalUsers ),
                "data"            => $usersData,
            );
              
        return response()->json($json_data);
    }

    public function manageJobs(){
        $job = new Job;
        $jobStatuses = $job->jobStatuses();
        $jobAvailabeStatus = $job->jobAvailabeStatus();
        $cities = City::where('status', 1)->orderBy('order')->orderBy('name')->get();
        $categories =  $job->jobCategories();
        $keywords = $job->jobKeywords();

        return view('admin-dashboard.manage-jobs')->with('cities', $cities)
                                                  ->with('categories', $categories)
                                                  ->with('keywords', $keywords)
                                                  ->with('jobStatuses', $jobStatuses)
                                                  ->with('jobAvailabeStatus', $jobAvailabeStatus);
    }

    public function getJobs(Request $request){

        $requestData = $request->all();  //dd($requestData);
        $data =[];
        $skip = $requestData['start'];
        $length = $requestData['length'];
        $orderValue = $requestData['order'][0];
      
       
        $columnOrder = array( 
                                        '0'=> 'jobs.id',
                                        '2'=> 'jobs.title',
                                        '3'=> 'categories.name',
                                        '5'=> 'companies.title',
                                        '6'=> 'jobs.date_of_submission',
                                        '7'=> 'jobs.published_on',
                                        '8'=> 'jobs.updated_at'
                                        );

 
        $columnName = 'jobs.created_at';
        $orderBy = 'desc';
        
        
        
        if(isset($columnOrder[$orderValue['column']]))
        {   
            $columnName = $columnOrder[$orderValue['column']];
            $orderBy = $orderValue['dir'];
        }

            
        $orderDataBy = [$columnName => $orderBy];
        
        $jobController = new JobController;
        $filterJobs = $jobController->filterJobs($requestData['filters'],$skip,$length,$orderDataBy);

        $jobs = $filterJobs['jobs'];
        $totalJobs = $filterJobs['totalJobs'];
 


        $jobsData = [];
        foreach ($jobs as $key => $job) {
         

            $cityNames = $job->getJobLocationNames('city');
            $cityNamesStr = (!empty($cityNames)) ? implode("<br>", $cityNames) :'';

            $metaData = $job->meta_data;
            $keyWords = (!empty($metaData['job_keyword'])) ? $metaData['job_keyword'] : []; 

            $splitKeywords =  splitJobArrayData($keyWords,2); 
            $jobKeywords = implode(',', $keyWords);
            $moreJobKeywords  = ($splitKeywords['moreArrayCount']) ? '<i title="'.implode(',', $splitKeywords['moreArray']).'">...</i>' :'';

            $companyName = (!empty($job->getJobCompany())) ? $job->getJobCompany()->title :''; 

            $editLink = url('jobs/'.$job->reference_id.'/job-details'); 
            $statusEditHtml =  '<a job-id="'.$job->id.'" job-name="'.$job->title.'" job-link="'.$editLink.'"  job-status="'.$job->status.'" href="#updateStatusModal" data-target="#updateStatusModal" class="update_status" data-toggle="modal"><i class="fa fa-pencil"></i></a>';
            //'#' => '<input type="checkbox" class="hidden" name="job_check[]" value="'.$job->id.'" >',   
            
            $editJob =  '<a  href="'.$editLink.'"  target="_blank" >'.$job->title.'</a>';
            $jobsData[] = [ 
                            'id' => $job->id,
                            'city' => $cityNamesStr,
                            'title' => $editJob,
                            'business_type' => $job->getJobCategoryName(),
                            'keyword' => $jobKeywords,
                            'company_name' => $companyName,
                            'date_of_submission' => $job->jobPostedOn(2),
                            'published_date' => $job->jobPublishedOn(2),
                            'last_updated' => $job->jobUpdatedOn(2),
                            'last_updated_by' => ($job->job_modifier) ? $job->updatedBy->name :'',
                            'status' => '<span status_value="'.$job->id.'">'.$job->getJobStatus().'</span> '.$statusEditHtml ,
                            ];
            
        }

        $json_data = array(
                "draw"            => intval( $requestData['draw'] ),
                "recordsTotal"    => intval( $totalJobs ),
                "recordsFiltered" => intval( $totalJobs ),
                "data"            => $jobsData,
            );
              
        return response()->json($json_data);

    }

    public function updateJobStatus(Request $request){
        $this->validate($request, [
            'job_id'     => 'required',
            'job_status' => 'required',
        ]);

        $requestData = $request->all();  
        $jobId = $requestData['job_id'];
        $jobStatus = $requestData['job_status'];


        $job = Job::find($jobId);
        if(!empty($job) && $job->isJobDataComplete()){
            $job->status = $jobStatus;

            if($job->status == '2' && empty($job->date_of_submission))
                $job->date_of_submission = date('Y-m-d H:i:s');
            $job->save();
            $status = true;
        }
        else
            $status = false;

        

        if($job->status == '3' || $job->status == '5'){

            $jobOwner = $job->createdBy;
            $ownerDetails = $jobOwner->getUserProfileDetails();

            //for testing
            $ownerDetails['email'] = 'nutan@ajency.in';

            $templateData['job'] = $job;
            $templateData['ownerName'] = $jobOwner->name;

            $template = ($job->status == '3') ?'job-published'  : 'job-rejected';
            $subject = ($job->status == '3')? 'Congratulations! Your job is now live on FnB Circle'  : 'Your job is not approved and hence rejected on FnB Circle.';
     
            $data = [];
            $data['from'] = 'nutan@ajency.in';
            $data['name'] = 'fnbcircles';
            $data['to'] = [ $ownerDetails['email']];
            $data['cc'] = 'prajay@ajency.in';
            $data['subject'] = $subject;
            $data['template_data'] = $templateData;
            
            sendEmail($template, $data);
        }
        
        $editLink = url('jobs/'.$job->reference_id.'/job-details');
        return response()->json(array("code" => "200","status" =>$status, "name" => $job->title,"link" => $editLink));
    }

    public function bulkUpdateJobStatus(Request $request){
        $this->validate($request, [
            'new_status_id' => 'required',
            'old_status_id' => 'required',
        ]);

        $requestData = $request->all(); 
        $newStatusId = (int) $requestData['new_status_id'];
        $oldStatusId = (int) $requestData['old_status_id'];
        $jobcheckall = $requestData['jobcheckall'];
        $jobCheckIds = $requestData['job_check_ids'];

        if($jobcheckall == 1)
            \DB::table('jobs')->where(['status'=>$oldStatusId])->update(['status' => $newStatusId]);
        else
        {
            $jobIds = explode(',', $jobcheckall);
            $jobIds = array_filter($jobcheckall);
            \DB::table('jobs')->whereIn('id',$jobCheckIds)->update(['status' => $newStatusId]);
        }

        return response()->json(array("code" => "200","status" =>true, "msg" => ""));

    }
}
