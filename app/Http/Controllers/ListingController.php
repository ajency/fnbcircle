<?php

namespace App\Http\Controllers;

use App\Area;
use App\Category;
use App\City;
use App\Common;
use App\Listing;
use App\ListingAreasOfOperation;
use App\ListingCategory;
use App\ListingCommunication;
use App\ListingOperationTime;
use App\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

/*
 *    This class defines the actions required for adding a listing to the database and editing it.
 *    This can be used as a route or as a resource.
 *
 *    @method index will be invoked to return an empty form to create a new listing
 *
 *    @method show will be invoked to view single listing and is called using listing/edit
 *
 *    @method edit will be invoked to edit a listing and is called using listing/{id}/edit
 *
 *    @method store will be invoked on a post request to the controller and is used to store/edit details
 *    of a listing to the database. The store method identifies the step you are on using @param step which
 *    will be retrieved from request can take following values: "business-information", "business-categories",
 *    "listing_location_and_operation_hours", "listing_other_details", "listing_photos_and_documents".
 *    Based on this the function then calls appropriate method to validate and save details sent by the user.
 *    Each called functions have two seperate methods defined for validation and saving details to the database respectively
 */

class ListingController extends Controller
{

    public function __construct()
    {
        Common::authenticate('listing', $this);
    }

    //-----------------------------------Step 1-----------------------

    public function listingInformation($data)
    {
        $this->validate($data, [
            'title'         => 'required|max:255',
            'type'          => 'required|integer|between:11,13',
            'primary_email' => 'required|boolean',
            'area'          => 'required|integer|min:1',
            'contacts'      => 'required|json|contacts',
            'change'        => 'nullable|boolean',

        ]);
        $contacts_json = json_decode($data->contacts);
        $contacts      = array();
        foreach ($contacts_json as $contact) {
            $contacts[$contact->id] = array('visible' => $contact->visible);
        }
        // print_r($contacts);
        if ($data->listing_id == "") {
            $listing = new Listing;
        } else {
            $listing = Listing::where('reference', $data->listing_id)->firstorFail();
        }
        $listing->saveInformation($data->title, $data->type, $data->primary_email, $data->area);
        ListingCommunication::where('listing_id', $listing->id)->update(['listing_id' => null]);
        foreach ($contacts as $contact => $info) {
            $com = ListingCommunication::find($contact);
            $com->saveInformation($listing->id, $info['visible']);
        }
        $change = "";
        if (isset($data->change) and $data->change == "1") {
            $change = "&success=true";
        }

        if (isset($data->submitReview) and $data->submitReview == 'yes') {
            return ($this->submitForReview($data));
        }

        // echo $data->change;
        return redirect('/listing/' . $listing->reference . '/edit/business-categories?step=true' . $change);
    }
    public function saveContact(Request $request)
    {
        $this->validate($request, [
            'value' => 'required',
            'type'  => 'required',
            'id'    => 'nullable|integer',
        ]);
        $value = $request->value;
        $type  = $request->type;
        $id    = $request->id;
        if ($id == "") {
            $contact = new ListingCommunication;
        } else {
            $contact = ListingCommunication::find($id);
        }

        $contact->value              = $value;
        $contact->communication_type = $type;
        $contact->save();
        return response()->json(array('id' => $contact->id));
    }
    public function createOTP(Request $request)
    {
        $this->validate($request, [
            'value' => 'required',
            'type'  => 'required|integer',
            'id'    => 'nullable|  integer',
        ]);
        // $request->session()->flush();
        if ($request->id == null) {
            $contact = new ListingCommunication;
        } else {
            $contact = ListingCommunication::findorFail($request->id);
        }
        $contact->value              = $request->value;
        $contact->communication_type = $request->type;
        $contact->save();
        $OTP       = rand(1000, 9999);
        $timestamp = Carbon::now()->timestamp;
        $json      = json_encode(array("id" => $contact->id, "OTP" => $OTP, "timestamp" => $timestamp));
        error_log($json); //send sms or email here
        $request->session()->put('contact#' . $contact->id, $json);
        return response()->json(array('id' => $contact->id, 'verify' => $contact->is_verified, 'value' => $contact->value, 'OTP' => $OTP));

    }

    public function validateOTP(Request $request)
    {
        $this->validate($request, [
            'OTP' => 'integer|min:1000|max:9999',
            'id'  => 'integer|min:1',
        ]);
        $json = session('contact#' . $request->id);
        if ($json == null) {
            abort(404);
        }

        $array = json_decode($json);
        $old   = Carbon::createFromTimestamp($array->timestamp);
        $now   = Carbon::now();
        if ($now > $old->addMinutes(15)) {
            abort(410);
        }

        if ($request->OTP == $array->OTP) {
            $contact              = ListingCommunication::find($request->id);
            $contact->is_verified = 1;
            $contact->save();
            // dd($request->session);
            $request->session()->forget('contact#' . $request->id);
            return response()->json(array('success' => "1"));

        }
        return response()->json(array('success' => "0"));

    }

    public function findDuplicates(Request $request)
    {
        $this->validate($request, [
            'title'    => 'required|max:255',
            'contacts' => 'required|json',
        ]);

        $titles  = Listing::where('status', "1")->pluck('title', 'reference')->toArray();
        $similar = array();
        foreach ($titles as $key => $value) {
            similar_text($request->title, $value, $percent);
            if ($percent >= 80) {
                $similar[$key] = array('name' => $value, 'messages' => array("Business name matches this"));
            }
        }

        $contact = json_decode($request->contacts, true);
        $query   = ListingCommunication::whereNotNull('listing_id');
        $query   = $query->where(function ($query) use ($contact) {
            $query->where("value", Auth::user()->email);
            foreach ($contact as $value) {
                $query->orWhere('value', $value['value']);
            }
        });
        $query    = $query->with('listing');
        $contacts = $query->get();

        $users = User::where(function ($query) use ($contact) {
            $query->where('id', '0');
            foreach ($contact as $value) {
                $query->orWhere('email', $value['value']);
            }
        })->with('listing')->get();

        foreach ($users as $user) {
            foreach ($user->listing as $business) {
                if ($business['status'] != 1) {
                    continue;
                }
                if (!isset($similar[$business['reference']]) /* listing is published*/) {
                    $similar[$business['reference']] = array('name' => $business['title'], 'messages' => array());
                }
                $similar[$business['reference']]['messages'][] = "Matches found Email (<span class=\"heavier\">{$user->email}</span>)";
            }
        }

        foreach ($contacts as $row) {
            if ($row->listing['status'] != 1) {
                continue;
            }

            if (!isset($similar[$row->listing['reference']]) /* listing is published*/) {
                $similar[$row->listing['reference']] = array('name' => $row->listing['title'], 'messages' => array());
            }
            if ($row->communication_type == 1) {
                $similar[$row->listing['reference']]['messages'][] = "Matches found Email (<span class=\"heavier\">{$row->value}</span>)";
            }
            if ($row->communication_type == 2) {

                $similar[$row->listing['reference']]['messages'][] = "Matches found Phone Number(<span class=\"heavier\">{$row->value}</span>)";
            }
        }
        return response()->json($similar);

    }

    public function getAreas(Request $request)
    {
        $this->validate($request, [
            'city' => 'required|min:1|integer',
        ]);
        $areas = Area::where('city_id', $request->city)->where('status', '1')->orderBy('order')->orderBy('name')->get();
        $res   = array();
        foreach ($areas as $area) {
            $res[$area->id] = $area->name;
        }
        return response()->json($res);
    }

    //---------------------------step 2 ----------------------------------------

    public function saveListingCategories($listing_id, $categories)
    {
        ListingCategory::where('listing_id', $listing_id)->delete();
        foreach ($categories as $id => $core) {
            $category              = new ListingCategory;
            $category->listing_id  = $listing_id;
            $category->category_id = $id;
            $category->core        = $core;
            $category->save();
        }
    }
    public function listingCategories($request)
    {
        $this->validate($request, [
            'listing_id' => 'required',
            'categories' => 'required|id_json|not_empty_json',
            'core'       => 'required|id_json|not_empty_json',
            'change'     => 'nullable|boolean',
            // 'brands'     => 'required|id_json',
        ]);
        $categories = array();
        $categ      = json_decode($request->categories);
        foreach ($categ as $category) {
            $categories[$category->id] = 0;
            if (!Common::verify_id($category->id, 'categories')) {
                return \Redirect::back()->withErrors(array('wrong_step' => 'Category id is fabricated. Id doesnt exist'));
            }
        }
        $allcores = json_decode($request->core);
        foreach ($allcores as $core) {
            $categories[$core->id] = 1;
            if (!Common::verify_id($core->id, 'categories')) {
                return \Redirect::back()->withErrors(array('wrong_step' => 'Category id is fabricated. Id doesnt exist'));
            }
        }
        $listing = Listing::where('reference', $request->listing_id)->firstorFail();
        $this->saveListingCategories($listing->id, $categories);
        if (isset($request->brands) and $request->brands != '') {
            $listing->retag($request->brands);
        } else {
            $listing->untag();
        }
        $change = "";
        if (isset($request->change) and $request->change == "1") {
            $change = "&success=true";
        }

        if (isset($request->submitReview) and $request->submitReview == 'yes') {
            return ($this->submitForReview($request));
        }

        // echo $data->change;
        return redirect('/listing/' . $listing->reference . '/edit/business-location-hours?step=true' . $change);

    }

    public function getCategories(Request $request)
    {
        $this->validate($request, [
            'parent' => 'id_json|not_empty_json|required',
        ]);
        $parents = json_decode($request->parent);
        foreach ($parents as $parent) {
            if (!Common::verify_id($parent->id, 'categories')) {
                return abort(404);
            }
        }
        foreach ($parents as $parent) {
            $child       = Category::where('parent_id', $parent->id)->where('status', '1')->orderBy('order')->orderBy('name')->get();
            $child_array = array();
            foreach ($child as $ch) {
                $child_array[$ch->id] = array('id' => $ch->id, 'name' => $ch->name, 'order' => $ch->order);
            }
            $parent_obj = Category::find($parent->id);
            if ($parent_obj->parent_id != null) {
                $grandparent = Category::findorFail($parent_obj->parent_id);
            } else {
                $grandparent = new Category;
            }

            $parent_array[$parent_obj->id] = array('name' => $parent_obj->name, 'children' => $child_array, 'parent' => $grandparent->name, 'image' => $grandparent->icon_url);
        }
        return response()->json($parent_array);
    }

    public function getBrands(Request $request)
    {
        $this->validate($request, [
            'keyword' => 'required',
        ]);
        // dd(Listing::existingTagsLike($request->keyword));
        return response()->json(['results' => Listing::existingTagsLike($request->keyword), 'options' => []]);
    }

    //------------------------step 3 --------------------

    public function validateListingLocationAndOperationHours($data)
    {
        $this->validate($data, [
            'latitude'        => 'required|numeric|min:0|max:90',
            'longitude'       => 'required|numeric|min:0|max:180',
            'address'         => 'nullable|max:255',
            'map_address'     => 'nullable|max:255',
            'display_hours'   => 'required|boolean',
            'operation_areas' => 'required|json|id_json',
            'operation_time'  => 'required|json|week_time',
        ]);
        $areas = json_decode($data->operation_areas);
        foreach ($areas as $area) {
            if (!Common::verify_id($area->id, 'areas')) {
                return \Redirect::back()->withErrors(array('wrong_step' => 'Area id is fabricated. Id doesnt exist'));
            }
        }
        return true;
    }
    public function saveListingLocationAndOperationHours($data)
    {
        $listing                          = Listing::where('reference', $data->listing_id)->firstorFail();
        $listing->latitude                = $data->latitude;
        $listing->longitude               = $data->longitude;
        $listing->map_address             = $data->map_address;
        $listing->display_address         = $data->address;
        $listing->show_hours_of_operation = $data->display_hours;
        $areas_json                       = json_decode($data->operation_areas);
        ListingAreasOfOperation::where('listing_id', $listing->id)->delete();
        $areas = array();
        foreach ($areas_json as $area) {
            $areas[$area->id] = 1;
        }
        foreach ($areas as $area => $nil) {
            $operation             = new ListingAreasOfOperation;
            $operation->listing_id = $listing->id;
            $operation->area_id    = $area;
            $operation->save();
        }
        $hours = json_decode($data->operation_time);
        ListingOperationTime::where('listing_id', $listing->id)->delete();
        foreach ($hours as $day => $time) {
            $operation              = new ListingOperationTime;
            $operation->listing_id  = $listing->id;
            $operation->day_of_week = $day;
            $operation->from        = $time->from;
            $operation->to          = $time->to;
            $operation->closed      = $time->closed;
            $operation->open24      = $time->open24;
            $operation->save();
        }
        $listing->save();

        $change = "";
        if (isset($data->change) and $data->change == "1") {
            $change = "&success=true";
        }

        if (isset($data->submitReview) and $data->submitReview == 'yes') {
            return ($this->submitForReview($data));
        }

        // echo $data->change;
        return redirect('/listing/' . $listing->reference . '/edit/business-details?step=true' . $change);
    }
    public function listingLocationAndOperationHours($request)
    {
        $check = $this->validateListingLocationAndOperationHours($request);
        if ($check !== true) {
            return $check;
        }

        return $this->saveListingLocationAndOperationHours($request);

    }
    //--------------------------step 4 ----------------------------------------
    public function validateListingOtherDetails($data)
    {
        $this->validate($data, [
            'listing_id'  => 'required',
            'description' => 'max:65535 ',
            'highlights'  => 'required',
            'established' => 'nullable|numeric',
            'website'     => 'nullable|url',
            'payment.*'   => 'required|boolean',
        ]);
        return true;
    }
    public function saveListingOtherDetails($data)
    {
        $listing              = Listing::where('reference', $data->listing_id)->firstorFail();
        $listing->description = $data->description;
        $highlights           = array();
        foreach ($data->highlights as $key => $highlight) {
            if (!empty($highlight)) {
                $highlights[] = $highlight;
            }
        }
        $highlights          = json_encode($highlights);
        $listing->highlights = $highlights;
        $other               = array();
        if (isset($data->established) and !empty($data->established)) {
            $other['established'] = $data->established;
        }

        if (isset($data->website) and !empty($data->website)) {
            $other['website'] = $data->website;
        }
        $other                  = json_encode($other);
        $listing->other_details = $other;
        $payment                = array();
        foreach ($data->payment as $key => $value) {
            $payment[$key] = $value;
        }
        $listing->payment_modes = json_encode($payment);
        $listing->save();
    }

    public function listingOtherDetails($request)
    {

        $check = $this->validateListingOtherDetails($request);
        if ($check !== true) {
            return $check;
        }
        
        $this->saveListingOtherDetails($request);
        if (isset($request->submitReview) and $request->submitReview == 'yes') {
            return ($this->submitForReview($request));
        }

    }
    //----------------------------step 5------------------------------
    public function validateListingPhotosAndDocuments($data)
    {
        $this->validate($data, [
            'listing_id' => 'required|integer|min:1',
            'photos'     => 'required|photo_json',
            'documents'  => 'required|doc_json',
        ]);
        if (!Common::verify_id($data->listing_id, 'listings')) {
            return \Redirect::back()->withErrors(array('wrong_step' => 'Listing id is fabricated. Id doesnt exist'));
        }

        return true;
    }
    public function saveListingPhotosAndDocuments($data)
    {
        $listing            = Listing::find($data->listing_id);
        $listing->photos    = $data->photos;
        $listing->documents = $data->documents;
        $listing->save();
    }
    public function listingPhotosAndDocuments($request)
    {
        $check = $this->validateListingPhotosAndDocuments($request);
        if ($check !== true) {
            return $check;
        }

        $this->saveListingPhotosAndDocuments($request);
        if (isset($request->submitReview) and $request->submitReview == 'yes') {
            return ($this->submitForReview($request));
        }

    }

    //--------------------Common method ------------------------
    public function store(Request $request)
    {
        if (true) {
            $this->validate($request, [
                'step' => 'required',
            ]);
            $data = $request->all();
            switch ($data['step']) {
                case 'business-information':
                    return $this->listingInformation($request);
                    break;
                case 'business-categories':
                    return $this->listingCategories($request);
                    break;
                case 'business-location-hours':
                    return $this->listingLocationAndOperationHours($request);
                    break;
                case 'business-details':
                    return $this->listingOtherDetails($request);
                    break;
                case 'listing_photos_and_documents':
                    return $this->listingPhotosAndDocuments($request);
                    break;
                default:
                    return \Redirect::back()->withErrors(array('wrong_step' => 'Something went wrong. Please try again'));
                    break;
            }
        }
    }

    public function create()
    {
        // dd(Auth::user());
        $listing = new Listing;
        $cities  = City::where('status', '1')->orderBy('order')->orderBy('name')->get();
        return view('business-info')->with('listing', $listing)->with('step', 'business-information')->with('emails', array())->with('mobiles', array())->with('phones', array())->with('cities', $cities);
    }
    public function edit($reference, $step = 'business-information')
    {
        if ($step == 'business-information') {
            $listing = Listing::where('reference', $reference)->firstorFail();
            $emails  = ListingCommunication::where('listing_id', $listing->id)->where('communication_type', '1')->get();
            $mobiles = ListingCommunication::where('listing_id', $listing->id)->where('communication_type', '2')->get();
            $phones  = ListingCommunication::where('listing_id', $listing->id)->where('communication_type', '3')->get();
            $cities  = City::where('status', '1')->orderBy('order')->orderBy('name')->get();
            $areas   = Area::where('city_id', function ($area) use ($listing) {
                $area->from('areas')->select('city_id')->where('id', $listing->locality_id);
            })->where('status', '1')->orderBy('order')->orderBy('name')->get();
            // echo $areas;
            return view('business-info')->with('listing', $listing)->with('step', $step)->with('emails', $emails)->with('mobiles', $mobiles)->with('phones', $phones)->with('cities', $cities)->with('areas', $areas);
        }
        if ($step == 'business-categories') {
            $listing       = Listing::where('reference', $reference)->firstorFail();
            $parent_categ  = Category::whereNull('parent_id')->where('status', '1')->orderBy('order')->orderBy('name')->get();
            $categories    = DB::select("SELECT nodes.category_id as id, nodes.name as name, nodes.core as core, info.id as branchID, info.name as branch, info.parent as parent, info.icon as icon from (select `category_id`,categories.name,categories.parent_id, `core` from listing_category join categories on listing_category.category_id = categories.id where `listing_id` = ? ) as nodes join (select categories.id, categories.name, p_categ.name as parent, p_categ.icon_url as icon from categories join categories as p_categ on categories.parent_id = p_categ.id where categories.id in (select parent_id from listing_category join categories on listing_category.category_id = categories.id where `listing_id` = ? group by parent_id)) as info on nodes.parent_id = info.id ", [$listing->id, $listing->id]);
            $category_json = array();
            foreach ($categories as $category) {
                if (!isset($category_json["$category->branchID"])) {
                    $category_json["$category->branchID"] = array('branch' => "$category->branch", 'parent' => "$category->parent", 'image-url' => "$category->icon", 'nodes' => array());
                }
                $category_json["$category->branchID"]['nodes']["$category->id"] = array('name' => "$category->name", 'id' => "$category->id", 'core' => "$category->core");
            }
            return view('business-categories')->with('listing', $listing)->with('step', 'business-categories')->with('parents', $parent_categ)->with('categories', $category_json)->with('brands', array())->with('back', 'business-information');
            // dd($category_json);
        }
        if ($step == 'business-location-hours') {
            $listing        = Listing::where('reference', $reference)->with('location')->with('operationTimings')->firstorFail();
            $operationAreas = ListingAreasOfOperation::city($listing->id);
            $cities         = City::where('status', '1')->orderBy('order')->orderBy('name')->get();
            // dd($listing);
            return view('location')->with('listing', $listing)->with('step', $step)->with('back', 'business-categories')->with('cities', $cities)->with('areas', $operationAreas);
        }
        if ($step == 'business-details') {
            $listing = Listing::where('reference', $reference)->firstorFail();
            
            return view('business-details')->with('listing', $listing)->with('step', 'business-details')->with('back', 'business-location-hours');
        }
    }

    public function submitForReview(Request $request)
    {
        $this->validate($request, [
            'listing_id' => 'required',
        ]);
        $listing = Listing::where('reference', $request->listing_id)->firstorFail();
        // dd('yes'); abort();
        if ($listing->isReviewable()) {
            $listing->status = Listing::REVIEW;
            $listing->save();
            // return \Redirect::back()->withErrors(array('review' => 'Your listing is not eligible for a review'));
            return redirect('/listing/' . $listing->reference . '/edit/' . $request->step . '?step=true&review=success');
        } else {
            return \Redirect::back()->withErrors(array('review' => 'Your listing is not eligible for a review'));
        }
    }

}
