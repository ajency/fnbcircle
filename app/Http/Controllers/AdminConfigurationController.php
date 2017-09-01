<?php

namespace App\Http\Controllers;

use App\Area;
use App\Category;
use App\City;
use App\Common;
use App\Listing;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminConfigurationController extends Controller
{
    public function __construct()
    {
        // Common::authenticate('dashboard', $this);
    }

    public function locationView(Request $request)
    {
        $cities = City::orderBy('order')->orderBy('name')->get();
        return view('admin-dashboard.location')->with('cities', $cities);
    }
    public function categoriesView(Request $request)
    {
        $parents  = Category::where('level', '1')->get();
        $branches = Category::where('level', '2')->get();
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

                if ($city->status != "0" and $city->slug != $request->slug) {
                    abort(400, 'slug can be edited only in draft');
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

                if ($area->status != "0" and $area->slug != $request->slug) {
                    abort(400, 'slug can be edited only in draft');
                }
                $area->slug = $request->slug;
                if ($area->status != "0" and $area->city_id != $request->city_id) {
                    abort(400, 'you cannot change city after publishing');
                }
                $area->city_id = $request->city_id;
            }
            if ($request->status == "1") {
                $area->published_date = Carbon::now()->toDateTimeString();
            }

            $area->status = $request->status;
            $area->name   = $request->name;
            $area->order  = $request->sort_order;
            $area->save();
            $area = Area::with('city')->find($area->id);

            return response()->json($area);
        }
    }
    public function categConfigList(Request $request)
    {
        $status     = array("0" => "Draft", "1" => "Published", "2" => "Archived");
        $categories = Category::all();
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
            );
            if ($category->level == "1") {
                $data[$category->id]['isParent'] = "<i class=\"fa fa-check text-success\"></i><span class=\"hidden\">Yes</span>";
                $data[$category->id]['isBranch'] = "-<span class=\"hidden\">no</span>";
                $data[$category->id]['isNode']   = "-<span class=\"hidden\">no</span>";
                $data[$category->id]['parent']   = "";
                $data[$category->id]['branch']   = "";
                $data[$category->id]['name']     = $category->name . '<img src="' . $category->icon_url . '" class="img-circle" width="20">';
            }
            if ($category->level == "2") {
                $data[$category->id]['isParent']  = "-<span class=\"hidden\">no</span>";
                $data[$category->id]['isBranch']  = "<i class=\"fa fa-check text-success\"></i><span class=\"hidden\">Yes</span>";
                $data[$category->id]['isNode']    = "-<span class=\"hidden\">no</span>";
                $data[$category->id]['parent']    = $data[$category->parent_id]['name'];
                $data[$category->id]['branch']    = "";
                $data[$category->id]['parent_id'] = $data[$category->parent_id]['id'];
            }
            if ($category->level == "3") {
                $data[$category->id]['isParent']  = "-<span class=\"hidden\">no</span>";
                $data[$category->id]['isBranch']  = "-<span class=\"hidden\">no</span>";
                $data[$category->id]['isNode']    = "<i class=\"fa fa-check text-success\"></i><span class=\"hidden\">Yes</span>";
                $data[$category->id]['parent']    = $data[$data[$category->parent_id]['parent_id']]['name'];
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
            if ($category->type == "parent") {
                $branches = Category::where('parent_id', $category->id)->get();
                foreach ($branches as $branch) {
                    $nodes = Category::where('parent_id', $branch->id)->get();
                    foreach ($nodes as $node) {
                        $listings = Category::find($node->id)->listing()->get();
                        foreach ($listings as $listing) {
                            $list[$listing->id] = ["ref" => $listing->reference];
                        }
                    }
                }
                $categSibCount[$category->id] = array();
            }
            if ($category->type == "branch") {
                $nodes = Category::where('parent_id', $category->id)->get();
                foreach ($nodes as $node) {
                    $listings = Category::find($node->id)->listing()->get();
                    foreach ($listings as $listing) {
                        $list[$listing->id] = ["ref" => $listing->reference];
                    }
                }
                $count                        = Category::find($category->id)->siblingCount();
                $categSibCount[$category->id] = array('branch' => $count);
            }
            if ($category->type == "node") {
                $listings = Category::find($category->id)->listing()->get();
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
        $list     = array_intersect_key($categ_list, $loc_list);

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
            'image_url'  => 'nullable|url',
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
        if (Category::where('slug', $request->slug)->where('id', '!=', $request->id)->count()!="0") {
            return response()->json(array("status" => "400", "msg" => "duplicate slug", "data" => array()));
        }

        if (Category::where('name', $request->name)->where('id', '!=', $request->id)->where('parent_id', $request->parent_id)->count()!= "0") {
            return response()->json(array("status" => "400", "msg" => "duplicate Name", "data" => array()));
        }
        if ($request->id == '') {
            $category         = new Category;
            $category->status = "0";
            $category->level  = $request->level;
        } else {
            $category = Category::find($request->id);
        }
        if ($category->status == "0") {
            $category->parent_id = $request->parent_id;
            $category->slug      = $request->slug;
            $category->path      = Category::find($category->parent_id)->path . str_pad($category->parent_id, 5, '0', STR_PAD_LEFT);
        }
        $category->name     = $request->name;
        $category->order    = $request->sort_order;
        $category->icon_url = $category->icon_url;
        $message = $category->saveStatus($request->status);
        if($message != true){
            return response()->json(array("status" => "400", "msg" => $message, "data" => array()));
        }

        $category->save();
        $category = Category::find($category->id);
        $parents = Category::where('level','1')->get();
        $branches = Category::where('level','2')->get();
        return response()->json(array("status" => "200", "msg" => "", "data" => array("item"=>$category,"other_data"=>array("parents"=>$parents,"branches"=>$branches))));
    }

}
