<?php

namespace App\Http\Controllers;

use App\Area;
use App\Category;
use App\City;
use App\Common;
use App\Listing;
use App\ListingAreasOfOperation;
use App\ListingBrand;
use App\ListingCategory;
use App\ListingCommunication;
use App\ListingHighlight;
use App\ListingOperationTime;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
 *    will be retrieved from request can take following values: "listing_information", "listing_categories",
 *    "listing_location_and_operation_hours", "listing_other_details", "listing_photos_and_documents".
 *    Based on this the function then calls appropriate method to validate and save details sent by the user.
 *    Each called functions have two seperate methods defined for validation and saving details to the database respectively
 */

class ListingController extends Controller
{

    public function isUserAuthenticated($listing_id = 0)
    {
        if (Auth::check()) {
            return true;
        }
        return false;
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
        $listing->saveInformation($data->title, $data->type, $data->primary_email,$data->area);
        ListingCommunication::where('listing_id', $listing->id)->update(['listing_id' => null]);
        foreach ($contacts as $contact => $info) {
            $com = ListingCommunication::find($contact);
            $com->saveInformation($listing->id, $info['visible']);
        }
        return redirect('/listing/' . $listing->reference . '/edit/listing_categories?success=true');
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
            $query->where("id", "0");
            foreach ($contact as $value) {
                $query->orWhere('value', $value['value']);
            }
        });
        $query = $query->with('listing');
        // echo $query->toSql();
        $contacts = $query->get();

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
        $areas = Area::where('city_id', $request->city)->get();
        $res   = array();
        foreach ($areas as $area) {
            $res[$area->id] = $area->name;
        }
        return response()->json($res);
    }

    //---------------------------step 2 ----------------------------------------

    public function validateListingcategories($data)
    {
        $this->validate($data, [
            'listing_id' => 'required|integer|min:1',
            'categories' => 'required|id_json|not_empty_json',
            'core'       => 'required|id_json|not_empty_json',
            'brands'     => 'required|id_json',
        ]);
        if (!Common::verify_id($data->listing_id, 'listings')) {
            return \Redirect::back()->withErrors(array('wrong_step' => 'Listing id is fabricated. Id doesnt exist'));
        }
        $categ = json_decode($data->categories);
        foreach ($categ as $category) {
            if (!Common::verify_id($category->id, 'categories')) {
                return \Redirect::back()->withErrors(array('wrong_step' => 'Category id is fabricated. Id doesnt exist'));
            }
        }
        $allcores = json_decode($data->core);
        foreach ($allcores as $core) {
            if (!Common::verify_id($core->id, 'categories')) {
                return \Redirect::back()->withErrors(array('wrong_step' => 'Category id is fabricated. Id doesnt exist'));
            }
        }
        $brands = json_decode($data->brands);
        foreach ($brands as $brand) {
            if (!Common::verify_id($brand->id, 'brands')) {
                return \Redirect::back()->withErrors(array('wrong_step' => 'Brand id is fabricated. Id doesnt exist'));
            }
        }
        return true;
    }
    public function saveListingCategories($listing_id, $categories, $brands)
    {
        ListingCategory::where('listing_id', $listing_id)->delete();
        foreach ($categories as $id => $core) {
            $category              = new ListingCategory;
            $category->listing_id  = $listing_id;
            $category->category_id = $id;
            $category->core        = $core;
            $category->save();
        }
        ListingBrand::where('listing_id', $listing_id)->delete();
        foreach ($brands as $brand) {
            $row             = new ListingBrand;
            $row->listing_id = $listing_id;
            $row->brand_id   = $brand->id;
            $row->save();
        }
    }
    public function listingCategories($request)
    {
        $check = $this->validateListingCategories($request);
        if ($check !== true) {
            return $check;
        }

        $categories = array();
        $categ      = json_decode($request->categories);
        foreach ($categ as $category) {
            $categories[$category->id] = 0;
        }
        $allcores = json_decode($request->core);
        foreach ($allcores as $core) {
            $categories[$core->id] = 1;
        }
        $brands = json_decode($request->brands);

        $this->saveListingCategories($request->listing_id, $categories, $brands);
    }

    public function getCategories(Request $request)
    {
        $this->validate($request, [
            'parent' => 'id_json|not_empty_json|required',
        ]);
        $children = array();
        $parents  = json_decode($request->parent);
        foreach ($parents as $parent) {
            if (!Common::verify_id($parent->id, 'categories')) {
                return \Redirect::back()->withErrors(array('no_categ' => 'parent id is fabricated. Id doesnt exist'));
            }
        }
        foreach ($parents as $parent) {
            $child       = Category::where('parent_id', $parent->id)->get();
            $child_array = array();
            foreach ($child as $ch) {
                $child_array[$ch->id] = $ch->name;
            }
            $children[] = $child_array;
        }
        return response()->json($children);
    }

    //------------------------step 3 --------------------

    public function validateListingLocationAndOperationHours($data)
    {
        $this->validate($data, [
            'listing_id'      => 'required|integer|min:1',
            'area_id'         => 'required|integer|min:1',
            'latitude'        => 'required|numeric|min:0|max:90',
            'longitude'       => 'required|numeric|min:0|max:180',
            'address'         => 'required|max:255',
            'display_hours'   => 'required|nullable|boolean',
            'operation_areas' => 'required|json|id_json',
            'operation_time'  => 'required|json|week_time',
        ]);
        if (!Common::verify_id($data->listing_id, 'listings')) {
            return \Redirect::back()->withErrors(array('wrong_step' => 'Listing id is fabricated. Id doesnt exist'));
        }
        if (!Common::verify_id($data->area_id, 'areas')) {
            return \Redirect::back()->withErrors(array('wrong_step' => 'Area id is fabricated. Id doesnt exist'));
        }
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
        $listing                          = Listing::find($data->listing_id);
        $listing->locality_id             = $data->area_id;
        $listing->latitude                = $data->latitude;
        $listing->longitude               = $data->longitude;
        $listing->display_address         = $data->address;
        $listing->show_hours_of_operation = $data->display_hours;
        $areas_json                       = json_decode($data->operation_areas);
        ListingAreasOfOperation::where('listing_id', $data->listing_id)->delete();
        $areas = array();
        foreach ($areas_json as $area) {
            $areas[$area->id] = 1;
        }
        foreach ($areas as $area => $nil) {
            $operation             = new ListingAreasOfOperation;
            $operation->listing_id = $data->listing_id;
            $operation->area_id    = $area;
            $operation->save();
        }
        $hours = json_decode($data->operation_time);
        ListingOperationTime::where('listing_id', $data->listing_id)->delete();
        foreach ($hours as $day => $time) {
            $operation              = new ListingOperationTime;
            $operation->listing_id  = $data->listing_id;
            $operation->day_of_week = $day;
            $operation->from        = $time->from;
            $operation->to          = $time->to;
            $operation->closed      = $time->closed;
            $operation->open24      = $time->open24;
            $operation->save();
        }
        $listing->save();
    }
    public function listingLocationAndOperationHours($request)
    {
        $check = $this->validateListingLocationAndOperationHours($request);
        if ($check !== true) {
            return $check;
        }

        $this->saveListingLocationAndOperationHours($request);
    }
    //--------------------------step 4 ----------------------------------------
    public function validateListingOtherDetails($data)
    {
        $this->validate($data, [
            'listing_id'  => 'required|integer|min:1',
            'description' => 'required|max:65535 ',
            'highlights'  => 'required',
            'established' => 'nullable|numeric',
            'website'     => 'nullable|active_url',
            'payment.*'   => 'required|boolean',
        ]);
        if (!Common::verify_id($data->listing_id, 'listings')) {
            return \Redirect::back()->withErrors(array('wrong_step' => 'Listing id is fabricated. Id doesnt exist'));
        }
        return true;
    }
    public function saveListingOtherDetails($data)
    {
        $listing              = Listing::find($data->listing_id);
        $listing->description = $data->description;
        ListingHighlight::where('listing_id', $data->listing_id)->delete();
        foreach ($data->highlights as $key => $highlight) {
            if (!empty($highlight)) {
                $entry               = new ListingHighlight;
                $entry->listing_id   = $data->listing_id;
                $entry->highlight_id = $key;
                $entry->highlight    = $highlight;
                $entry->save();
            }
        }
        $other = array();
        if (isset($data->established) and !empty($data->established)) {
            $other['established'] = $data->established;
        }

        if (isset($data->website) and !empty($data->website)) {
            $other['website'] = $data->website;
        }

        $other                  = json_encode($other);
        $listing->other_details = $other;
        foreach ($data->payment as $key => $value) {
            if (!isset($payment)) {
                if ($value == 1) {
                    $payment = $key;
                }

            } else {
                if ($value == 1) {
                    $payment .= ', ' . $key;
                }

            }
        }
        if (isset($payment)) {
            $listing->payment_modes = $payment;
        }

        $listing->save();
    }

    public function listingOtherDetails($request)
    {
        $check = $this->validateListingOtherDetails($request);
        if ($check !== true) {
            return $check;
        }

        $this->saveListingOtherDetails($request);
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
    }

    //--------------------Common method ------------------------
    public function store(Request $request)
    {
        // if($this->is_user_authenticated()){
        if (true) {
            $this->validate($request, [
                'step' => 'required',
            ]);
            $data = $request->all();
            switch ($data['step']) {
                case 'listing_information':
                    return $this->listingInformation($request);
                    break;
                case 'listing_categories':
                    return $this->listingCategories($request);
                    break;
                case 'listing_location_and_operation_hours':
                    return $this->listingLocationAndOperationHours($request);
                    break;
                case 'listing_other_details':
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
        $listing = new Listing;
        $cities  = City::all();
        return view('business-info')->with('listing', $listing)->with('step', 'listing_information')->with('emails', array())->with('mobiles', array())->with('phones', array())->with('cities', $cities);
    }
    public function edit($reference, $step = 'listing_information')
    {
        if ($step == 'listing_information') {
            $listing = Listing::where('reference', $reference)->firstorFail();
            $emails  = ListingCommunication::where('listing_id', $listing->id)->where('communication_type', '1')->get();
            $mobiles = ListingCommunication::where('listing_id', $listing->id)->where('communication_type', '2')->get();
            $phones  = ListingCommunication::where('listing_id', $listing->id)->where('communication_type', '3')->get();
            $cities  = City::all();
            $area = Area::find($listing->locality_id);
            return view('business-info')->with('listing', $listing)->with('step', $step)->with('emails', $emails)->with('mobiles', $mobiles)->with('phones', $phones)->with('cities', $cities)->with('area', $area);
        }
        if ($step == 'listing_categories') {
            $listing = Listing::where('reference', $reference)->firstorFail();
            return view('business-categories')->with('listing', $listing)->with('step', 'listing_categories  ');
        }
    }

}
