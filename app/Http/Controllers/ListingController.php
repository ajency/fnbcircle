<?php

namespace App\Http\Controllers;

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
use Session;
use Carbon\Carbon;
use App\Plan;
use App\PlanAssociation;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Password;
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
        // Common::authenticate('listing', $this);
    }

    
    public function createUserAndAssignListing($user_details,$listing){
        if($user_details->email == "") return false;
        $user = User::findUsingEmail($user_details->email);
        if($user != null){
            $listing->owner_id = $user->id;
            $listing->save();
            if($user_details->sendmail == "true"){    
                $area = Area::with('city')->find($listing->locality_id);
                $email = [
                        'to' => $listing->owner()->first()->getPrimaryEmail(),
                        'subject' => "Listing added under your account on F&B Circle",
                        'template_data' => [
                            'listing_name' => $listing->title,
                            'listing_type' => Listing::listing_business_type[$listing->type],
                            'listing_state' => $area->city['name'],
                            'listing_city' => $area->name,
                        ],
                    ];
                sendEmail('listing-user-notify',$email);
            }
            if(1 == $user->getPrimaryEmail(true)['is_verified']){
                $listing->verified = 1;
                $listing->save();
            }
            return true;
        }
        $request_data = [
            "user" => array("username" => $user_details->email, "email" => $user_details->email, "password" => str_random(10) , "provider" => "internal_listing_signup", "name" => explode('@', $user_details->email)[0]),
            "user_comm" => array("email" => $user_details->email, "is_primary" => 1, "is_communication" => 1, "is_visible" => 0, "is_verified" => 0),
            "user_details" => array("is_job_seeker" => 0, "has_job_listing" => 0, "has_business_listing" => 0, "has_restaurant_listing" => 0)
        ];
        $userauth_obj = new UserAuth;
        $valid_response = $userauth_obj->validateUserLogin($request_data["user"], "email_signup");
        if($valid_response["status"] == "success" || $valid_response["message"] == "no_account") {
            if ($valid_response["authentic_user"]) {
                if(!$valid_response["user"]) {
                    $request_data["user"]["roles"] = "customer";
                    $request_data["user"]["type"] = "external";
                    $user_resp = $userauth_obj->updateOrCreateUser($request_data["user"], $request_data["user_details"], $request_data["user_comm"]);
                }
                if($user_details->phone != "" && isset($user_resp["user"]) && $user_resp["user"]) { // If communication, then enter Mobile No in the UserComm table
                    $usercomm_obj = UserCommunication::create([
                        "type" => "mobile", "country_code" => ($user_details->locality) ? $user_details->locality : "91",
                        "value" => $user_details->phone, "object_id" => $user_resp["user"]->id, "object_type" => "App\User", "is_primary" => 1
                    ]);
                }
                $listing->owner_id = $user_resp["user"]->id;
                $listing->save();
                //send email here
                if($user_details->sendmail == "true"){ 
                    $user = Password::broker()->getUser(['email'=>$user_details->email]);
                    $token =Password::broker()->createToken($user);
                    $reset_password_url = url(config('app.url').route('password.reset', $token, false)) . "?email=" . $user_details->email.'&new_user=true';
                    // dd($reset_password_url);
                    $area = Area::with('city')->find($listing->locality_id);
                    $email = [
                            'to' => $user_details->email,
                            'subject' => "Activate your account to claim your business on FnB Circle",
                            'template_data' => [
                                'listing_name' => $listing->title,
                                'listing_type' => Listing::listing_business_type[$listing->type],
                                'listing_state' => $area->city['name'],
                                'listing_city' => $area->name,
                                'confirmationLink' => $reset_password_url,
                            ],
                        ];
                    sendEmail('listing-user-verify',$email);
                }
            }
        }
    }

    //-----------------------------------Step 1-----------------------

    public function listingInformation($data)
    {

        $this->validate($data, [
            'title'         => 'required|max:255',
            'type'          => 'required|integer|between:11,16',
            'primary_email' => 'required|boolean',
            'primary_phone' => 'required|boolean',
            'user'          => 'required|json',
            'area'          => 'required|integer|min:1',
            'contacts'      => 'required|json|contacts',
            'change'        => 'nullable|boolean',

        ]);
        $contacts_json = json_decode($data->contacts);
        $contacts      = array();
        foreach ($contacts_json as $contact) {
            $contacts[$contact->id] = array('visible' => $contact->visible);
            if(isset($contact->country) ) $contacts[$contact->id]['country'] = $contact->country;
            else $contacts[$contact->id]['country'] = null;
        }
        // print_r($contacts);
        if ($data->listing_id == "") {
            $listing = new Listing;
        } else {
            $listing = Listing::where('reference', $data->listing_id)->firstorFail();
        }
        $listing->saveInformation($data->title, $data->type, $data->primary_email, $data->area, $data->primary_phone);
        UserCommunication::where('object_type', 'App\\Listing')->where('object_id', $listing->id)->update(['object_id' => null]);
        foreach ($contacts as $contact => $info) {
            // dd($info);
            $com               = UserCommunication::find($contact);
            $com->country_code = $info['country'];
            $com->object_id    = $listing->id;
            $com->is_visible   = $info['visible'];
            $com->save();
        }

        $user = json_decode($data->user);
        if($listing->owner_id == null and $user->email != "") $this->createUserAndAssignListing($user,$listing);

        $change = "";
        if (isset($data->change) and $data->change == "1") {
            $change = "&success=true";
        }

        if (isset($data->submitReview) and $data->submitReview == 'yes') {
            return ($this->submitForReview($data));
        } elseif (isset($data->archive) and $data->archive == 'yes') {
            return ($this->archive($data));
        } elseif (isset($data->publish) and $data->publish == 'yes') {
            return ($this->publish($data));
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
        $types = ['1' => 'email', '2' => 'mobile', '3' => 'landline'];
        $type  = $types[$request->type];
        $id    = $request->id;
        if ($id == "") {
            $contact              = new UserCommunication;
            $contact->object_type = 'App\\Listing';
        } else {
            $contact = UserCommunication::find($id);
        }
        if (isset($request->country)) {
            $contact->country_code = $request->country;
        }
        $contact->value = $value;
        $contact->type  = $type;
        $contact->save();
        return response()->json(array('id' => $contact->id));
    }
    // public function createOTP(Request $request)
    // {
    //     $this->validate($request, [
    //         'value' => 'required',
    //         'type'  => 'required|integer',
    //         'id'    => 'nullable|  integer',
    //     ]);
    //     // $request->session()->flush();
    //     if ($request->id == null) {
    //         $contact = new ListingCommunication;
    //     } else {
    //         $contact = ListingCommunication::findorFail($request->id);
    //     }
    //     $contact->value              = $request->value;
    //     $contact->communication_type = $request->type;
    //     $contact->save();
    //     $OTP       = rand(1000, 9999);
    //     $timestamp = Carbon::now()->timestamp;
    //     $json      = json_encode(array("id" => $contact->id, "OTP" => $OTP, "timestamp" => $timestamp));
    //     error_log($json); //send sms or email here
    //     $request->session()->put('contact#' . $contact->id, $json);
    //     return response()->json(array('id' => $contact->id, 'verify' => $contact->is_verified, 'value' => $contact->value, 'OTP' => $OTP));

    // }

    // public function validateOTP(Request $request)
    // {
    //     $this->validate($request, [
    //         'OTP' => 'integer|min:1000|max:9999',
    //         'id'  => 'integer|min:1',
    //     ]);
    //     $json = session('contact#' . $request->id);
    //     if ($json == null) {
    //         abort(404);
    //     }

    //     $array = json_decode($json);
    //     $old   = Carbon::createFromTimestamp($array->timestamp);
    //     $now   = Carbon::now();
    //     if ($now > $old->addMinutes(15)) {
    //         abort(410);
    //     }

    //     if ($request->OTP == $array->OTP) {
    //         $contact              = ListingCommunication::find($request->id);
    //         $contact->is_verified = 1;
    //         $contact->save();
    //         // dd($request->session);
    //         $request->session()->forget('contact#' . $request->id);
    //         return response()->json(array('success' => "1"));

    //     }
    //     return response()->json(array('success' => "0"));

    // }

    public function findDuplicates(Request $request)
    {
        if (isset($request->id)) {
            $listing = Listing::find($request->id);
            $comm    = UserCommunication::where('object_type', 'App\\Listing')->where('object_id', $request->id)->get();
            //only(['country_code','value','type'])->all();
            $contacts = array();
            foreach ($comm as $com) {
                $contacts[] = ['value' => $com->value, 'country' => $com->country_code, 'type' => $com->type];
            }
        } else {
            $listing           = new Listing;
            $listing->title    = $request->title;
            $contacts          = json_decode($request->contacts, true);
            if(Auth::user()->type == 'external') $listing->owner_id = Auth::user()->id;
        }
        $alltitles = Listing::where('status', "1")->where('id', '!=', $listing->id)->pluck('title', 'reference')->toArray();
        $similar   = array();
        $titles    = array();
        $output = [];
        foreach ($alltitles as $key => $value) {
            similar_text($listing->title, $value, $percent);
            $output[] = $value.'=>'.$percent;
            if ($percent >= 80) {

                $similar[$key] = array('name' => $value, 'messages' => array("Business name matches this"));
                $titles[$key]  = array('id' => $key, 'title' => $value);
            }
        }

        $check_emails = [];
        foreach ($contacts as $value) {
            if($value['type'] == 'email') $check_emails[] = $value['value'];
        }
        $check_mobile = [];
        foreach ($contacts as $value) {
            if($value['type'] == 'mobile') $check_mobile[] = $value['value'];
        }

        // dd($output);
        $owner = User::find($listing->owner_id);
        $query = UserCommunication::where('object_type', 'App\\Listing')->whereNotNull('object_id')->where('object_id','!=',$listing->id);
        $query = $query->where(function ($query) use ($contacts, $owner) {
            $query->where(function ($query) use ($owner) {
                if($owner!=null) $query->where('value', $owner->getPrimaryEmail())->where('type','email');
                else $query->whereNull('value');
            });
            $query->orWhere(function ($query) use ($owner) {
                if($owner!=null) $query->where('value', $owner->getPrimaryContact()['contact'])->where('country_code',$owner->getPrimaryContact()['contact_region'])->where('type','mobile');
                else $query->whereNull('value');
            });
            foreach ($contacts as $value) {
                $query->orWhere(function ($query) use ($value) {
                    if($value['type'] != 'email') {$query->where('value',$value['value'])->where('country_code',$value['country'])->where('type',$value['type']);}
                    else {$query->where('value',$value['value'])->where('type',$value['type']);}

                });
            }
        })->with('object');
        $dup_com = $query->get();
        // dd($dup_com);


        $userauth_obj = new UserAuth;
        //create an array of only emails
        $user_comm = $userauth_obj->getPrimanyUsersUsingContact($check_emails,'email',true)->where('object_type','App\\User')->pluck('object_id')->toArray();
        $users = User::whereIn('id', $user_comm)->with('listing')->get();
        // dd($users);
        $emails = [];
        $phones = [];
        foreach ($users as $user) {
            foreach ($user->listing as $business) {
                if ($business['status'] != 1) {
                    continue;
                }
                if (!isset($similar[$business['reference']]) /* listing is published*/) {
                    $similar[$business['reference']] = array('name' => $business['title'], 'messages' => array());

                }
                if (!isset($emails[$business['reference']])) {
                    $emails[$business['reference']] = array('id' => $business['reference'], 'email' => []);
                }
                $similar[$business['reference']]['messages'][] = "Matches found Email (<span class=\"heavier\">{$user->email}</span>)";
                $emails[$business['reference']]['email'][]     = $user->getPrimaryEmail();
            }
        }
        // $user_comm = $userauth_obj->getPrimanyUsersUsingContact($check_mobile,'mobile',true)->where('object_type','App\\User')->pluck('object_id')->toArray();
        // $users = User::whereIn('id', $user_comm)->with('listing')->get();
        // foreach ($users as $user) {
        //     foreach ($user->listing as $business) {
        //         if ($business['status'] != 1) {
        //             continue;
        //         }
        //         if (!isset($similar[$business['reference']]) /* listing is published*/) {
        //             $similar[$business['reference']] = array('name' => $business['title'], 'messages' => array());

        //         }
        //         if (!isset($phones[$business['reference']])) {
        //             $phones[$business['reference']] = array('id' => $business['reference'], 'email' => []);
        //         }
        //         $similar[$business['reference']]['messages'][] = "Matches found Email Number (<span class=\"heavier\">{$user->email}</span>)";
        //         $user_mobile = $user->getPrimaryContact();
        //         $emails[$business['reference']]['email'][]     = '+'.$user_mobile['contact_region'].'-'.$user_mobile['contact'];
        //     }
        // }

        foreach ($dup_com as $row) {
            if ($row->object['status'] != 1) {
                continue;
            }

            if (!isset($similar[$row->object['reference']]) /* object is published*/) {
                $similar[$row->object['reference']] = array('name' => $row->object['title'], 'messages' => array());

            }
            if ($row->type == 'email') {
                $similar[$row->object['reference']]['messages'][] = "Matches found Email (<span class=\"heavier\">{$row->value}</span>)";
                if (!isset($emails[$row->object['reference']])) {
                    $emails[$row->object['reference']] = array('id' => $row->object['reference'], 'email' => []);
                }
                $emails[$row->object['reference']]['email'][] = $row->value;
            }
            if ($row->type == 'mobile' or $row->type == 'landline') {

                $similar[$row->object['reference']]['messages'][] = "Matches found Phone Number(<span class=\"heavier\">{$row->value}</span>)";
                if (!isset($phones[$row->object['reference']])) {
                    $phones[$row->object['reference']] = array('id' => $row->object, 'email' => []);
                }
                $phones[$row->object['reference']]['email'][] = $row->value;
                // dd($similar);
            }
        }
        return response()->json(array('matches' => array('title' => $titles, 'email' => $emails, 'phones' => $phones), 'similar' => $similar, 'type' => Auth::user()->type));

    }
    public function getAreas(Request $request)
    {
        $this->validate($request, [
            'city' => 'required|min:1|integer',
        ]);
        $areas = Area::where('city_id', $request->city)->where('status', '1')->orderBy('order')->orderBy('name')->get();
        $res   = array();
        foreach ($areas as $area) {
            $res[] = array('id' => $area->id, 'name' => $area->name);
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
            $category->category_slug = Category::find($id)->slug;
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
            $listing->retag('brands', $request->brands);
        } else {
            $listing->untag('brands');
        }
        $change = "";
        if (isset($request->change) and $request->change == "1") {
            $change              = "&success=true";
            $listing->updated_at = Carbon::now();
            $listing->save();
        }

        if (isset($request->submitReview) and $request->submitReview == 'yes') {
            return ($this->submitForReview($request));
        } elseif (isset($request->archive) and $request->archive == 'yes') {
            return ($this->archive($request));
        } elseif (isset($request->publish) and $request->publish == 'yes') {
            return ($this->publish($request));
        }

        // echo $data->change;
        return redirect('/listing/' . $listing->reference . '/edit/business-location-hours?step=true' . $change);

    }

    public function getCategories(Request $request)
    {
        $this->validate($request, [
            'parent' => 'id_json|not_empty_json|required',
            'status' => 'required',
        ]);
        $parents = json_decode($request->parent);
        foreach ($parents as $parent) {
            if (!Common::verify_id($parent->id, 'categories')) {
                return abort(404);
            }
        }
        $statuses = explode(",", $request->status);
        foreach ($parents as $parent) {
            $child = Category::where('type', 'listing')->where('parent_id', $parent->id)->where(function ($sql) use ($statuses) {
                $i = 0;
                foreach ($statuses as $status) {
                    if ($i == 0) {
                        $sql->where('status', $status);
                    } else { $sql->orWhere('status', $status);}
                    $i++;
                }
            })->orderBy('order')->orderBy('name')->get();
            // dd($child);
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

            $parent_array[$parent_obj->id] = array('name' => $parent_obj->name, 'children' => $child_array, 'parent' => $grandparent);
        }
        return response()->json($parent_array);
    }

    public function getBrands(Request $request)
    {
        $this->validate($request, [
            'keyword' => 'required',
        ]);
        // dd(Listing::existingTagsLike($request->keyword));
        return response()->json(['results' => Listing::existingTagsLike('brands', $request->keyword), 'options' => []]);
    }

    //------------------------step 3 --------------------

    public function validateListingLocationAndOperationHours($data)
    {
        $this->validate($data, [
            'latitude'        => 'required|numeric|min:-90|max:90',
            'longitude'       => 'required|numeric|min:-180|max:180',
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
        } elseif (isset($data->archive) and $data->archive == 'yes') {
            return ($this->archive($data));
        } elseif (isset($data->publish) and $data->publish == 'yes') {
            return ($this->publish($data));
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
            'website'     => 'nullable',
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
            if(substr($data->website,0,4) == 'http') $other['website'] = $data->website;
            else $other['website'] = 'http://'.$data->website;
        }
        $other                  = json_encode($other);
        $listing->other_details = $other;
        $payment                = array();
        foreach ($data->payment as $key => $value) {
            $payment[$key] = $value;
        }
        $listing->payment_modes = json_encode($payment);
        if (isset($data->other_payment) and $data->other_payment != '') {
            $listing->retag('payment-modes', $data->other_payment);
        } else {
            $listing->untag('payment-modes');
        }
        $listing->save();

        $change = "";
        if (isset($data->change) and $data->change == "1") {
            $change = "&success=true";
        }

        if (isset($data->submitReview) and $data->submitReview == 'yes') {
            return ($this->submitForReview($data));
        } elseif (isset($data->archive) and $data->archive == 'yes') {
            return ($this->archive($data));
        } elseif (isset($data->publish) and $data->publish == 'yes') {
            return ($this->publish($data));
        }

        // echo $data->change;
        return redirect('/listing/' . $listing->reference . '/edit/business-photos-documents?step=true' . $change);
    }

    public function listingOtherDetails($request)
    {

        $check = $this->validateListingOtherDetails($request);
        if ($check !== true) {
            return $check;
        }

        return $this->saveListingOtherDetails($request);

    }

    //----------------------------step 5------------------------------
    public function validateListingPhotosAndDocuments($data)
    {
        $this->validate($data, [
            'listing_id' => 'required',
            'main'       => 'nullable|integer',

        ]);
        return true;
    }

    public function listingPhotosAndDocuments($request)
    {
        $check = $this->validateListingPhotosAndDocuments($request);
        if ($check !== true) {
            return $check;
        }

        $change = "";
        if (isset($request->change) and $request->change == "1") {
            $change = "&success=true";
        }

        $listing = Listing::where('reference', $request->listing_id)->firstorFail();
        if (isset($request->images)) {
            $images = explode(',', $request->images);
        } else {
            $images = [];
        }

        if (isset($request->files)) {
            $files = json_decode($request['files'], true);
        } else {
            $files = [];
        }

        $filemap = array();
        foreach ($files as $file) {
            $listing->renameFile($file);
            $filemap[] = (int) $file['id'];
        }
        $listing->remapImages($images);
        $listing->remapFiles($filemap);

        $listing->updated_at = Carbon::now();
        $saved_images        = $listing->getImages();
        if (isset($saved_images[$request->main][config('tempconfig.listing-thumb-size')])) {
            $listing->photos = '{"id": "' . $request->main . '", "url" : "' . $saved_images[$request->main][config('tempconfig.listing-thumb-size')] . '", "order" : "' . implode(',', $images) . '"}';
        } else {
            $listing->photos = null;
        }
        $listing->save();

        if (isset($request->submitReview) and $request->submitReview == 'yes') {
            return ($this->submitForReview($request));
        } elseif (isset($request->archive) and $request->archive == 'yes') {
            return ($this->archive($request));
        } elseif (isset($request->publish) and $request->publish == 'yes') {
            return ($this->publish($request));
        }

        return redirect('/listing/' . $listing->reference . '/edit/business-premium?step=true' . $change);

    }

    public function uploadListingPhotos(Request $request)
    {
        $this->validate($request, [
            'listing_id' => 'required',
            'file'       => 'image',
        ]);
        $image   = $request->file('file');
        $listing = Listing::where('reference', $request->listing_id)->first();
        $id      = $listing->uploadImage($request->file('file'));
        if ($id != false) {
            return response()->json(['status' => '200', 'message' => 'Image Uploaded successfully', 'data' => ['id' => $id]]);
        } else {
            return response()->json(['status' => '400', 'message' => 'Image Upload Failed', 'data' => []]);
        }
    }

    public function uploadListingFiles(Request $request)
    {

        $this->validate($request, [
            'listing_id' => 'required',
            'file'       => 'file',
        ]);
        $file    = $request->file('file')->getClientOriginalName();
        $listing = Listing::where('reference', $request->listing_id)->first();
        $id      = $listing->uploadFile($request->file('file'), true, $file);
        if ($id != false) {
            return response()->json(['status' => '200', 'message' => 'File Uploaded successfully', 'data' => ['id' => $id]]);
        } else {
            return response()->json(['status' => '400', 'message' => 'File Upload Failed', 'data' => []], 400 );
        }
    }

    public function listingPremium(Request $request){
        $this->validate($request, [
            'listing_id' => 'required',
        ]);

        $change = "";
        if (isset($request->change) and $request->change == "1") {
            $change = "&success=true";
        }
        if (isset($request->submitReview) and $request->submitReview == 'yes') {
            return ($this->submitForReview($request));
        } elseif (isset($request->archive) and $request->archive == 'yes') {
            return ($this->archive($request));
        } elseif (isset($request->publish) and $request->publish == 'yes') {
            return ($this->publish($request));
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
                case 'business-photos-documents':
                    return $this->listingPhotosAndDocuments($request);
                    break;
                case 'business-premium':
                    return $this->listingPremium($request);
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
        $user    = Auth::user();
        $details = $user->getUserDetails()->first();
        if($user->type == 'internal') $areas = [];
        else    {
            if($details==null){
                $areas = [];
                $listing->locality_id = null;
            }
            else{
                $areas  = Area::where('city_id', $details->city)->get();
                $listing->locality_id = $details->area;
            }
        }
        if($user->type == 'external') $listing->owner_id = $user->id;
        return view('add-listing.business-info')->with('listing', $listing)->with('step', 'business-information')->with('emails', array())->with('mobiles', array())->with('phones', array())->with('cities', $cities)->with('owner', $user)->with('areas', $areas)->with('show_duplicates',false);
    }
    public function edit($reference, $step = 'business-information')
    {
        // dd(request()->has('show_duplicates'));
        $listing = Listing::where('reference', $reference)->with('location')->with('operationTimings')->firstorFail();
        $cityy = City::find($listing->location['city_id']);
        if ($step == 'business-information') {

            $emails  = UserCommunication::where('object_type', 'App\\Listing')->where('object_id', $listing->id)->where('type', 'email')->get();
            $emails1=[];
            foreach ($emails as $email) {
                $emails1[] = [
                    'id' => $email->id,
                    'email' => $email->value,
                    'verified' => $email->is_verified,
                    'visible' => $email->is_visible,
                ];
            }
            $mobiles = UserCommunication::where('object_type', 'App\\Listing')->where('object_id', $listing->id)->where('type', 'mobile')->get();
             $mobiles1=[];
            foreach ($mobiles as $mobile) {
                $mobiles1[] = [
                    'id' => $mobile->id,
                    'country_code' => $mobile->country_code,
                    'mobile' => $mobile->value,
                    'verified' => $mobile->is_verified,
                    'visible' => $mobile->is_visible,
                ];
            }
            $phones = UserCommunication::where('object_type', 'App\\Listing')->where('object_id', $listing->id)->where('type', 'landline')->get();
            $landlines=[];
            foreach ($phones as $landline) {
                $landlines[] = [
                    'id' => $landline->id,
                    'country_code' => $landline->country_code,
                    'landline' => $landline->value,
                    'verified' => $landline->is_verified,
                    'visible' => $landline->is_visible,
                ];
            }
            $cities = City::where('status', '1')->orderBy('order')->orderBy('name')->get();
            $areas  = Area::where('city_id', function ($area) use ($listing) {
                $area->from('areas')->select('city_id')->where('id', $listing->locality_id);
            })->where('status', '1')->orderBy('order')->orderBy('name')->get();
            if($listing->owner_id != null)
                $user = User::find($listing->owner_id);
            else
                $user = Auth::user();
            // dd($cityy);
            if(request()->has('show_duplicates') and request()->show_duplicates == 'true'){
                $show_duplicates = true;
                $request  = new Request;
                $request->merge(array('id' => $listing->id));
                $duplicates = $this->findDuplicates($request)->original["similar"];
                // dd($duplicates);
            }else{
                $show_duplicates = false;
                $duplicates = null;
            }
            return view('add-listing.business-info')->with('listing', $listing)->with('step', $step)->with('emails', $emails1)->with('mobiles', $mobiles1)->with('phones', $landlines)->with('cities', $cities)->with('areas', $areas)->with('owner', $user)->with('show_duplicates',$show_duplicates)->with('duplicates',$duplicates)->with('cityy',$cityy);
        }
        if ($step == 'business-categories') {
            $parent_categ  = Category::where('type', 'listing')->whereNull('parent_id')->where('status', '1')->orderBy('order')->orderBy('name')->get();
            $category_json = ListingCategory::getCategories($listing->id);
            return view('add-listing.business-categories')->with('listing', $listing)->with('step', 'business-categories')->with('parents', $parent_categ)->with('categories', $category_json)->with('brands', array())->with('back', 'business-information')->with('cityy',$cityy);
            // dd($category_json);
        }
        if ($step == 'business-location-hours') {
            $operationAreas = ListingAreasOfOperation::city($listing->id);

            $cities         = City::where('status', '1')->orderBy('order')->orderBy('name')->get();
            // dd($listing);
            return view('add-listing.location')->with('listing', $listing)->with('step', $step)->with('back', 'business-categories')->with('cities', $cities)->with('areas', $operationAreas)->with('cityy',$cityy);
        }
        if ($step == 'business-details') {
            $listing = Listing::where('reference', $reference)->firstorFail();

            return view('add-listing.business-details')->with('listing', $listing)->with('step', 'business-details')->with('back', 'business-location-hours')->with('cityy',$cityy);
        }
        if ($step == 'business-photos-documents') {
            return view('add-listing.photos')->with('listing', $listing)->with('step', 'business-photos-documents')->with('back', 'business-details')->with('cityy',$cityy);
        }
        if ($step == 'business-premium') {
            $plans = Plan::where('type','listing')->get();
            $requests = PlanAssociation::where('premium_type','App\\Listing')->where('premium_id', $listing->id)->orderBy('created_at','desc')->get();
            $now = Carbon::now();
            $active = PlanAssociation::where('premium_type','App\\Listing')->where('premium_id', $listing->id)->whereNotNull('approval_date')->where('billing_start', '<', $now->toDateTimeString())->where('billing_end', '>', $now->toDateTimeString())->where('status',1)->first();
            if($active == null) {
                $current = ['id'=>0];
            } else {
                $current = ['id'=>$active->plan_id];
            }
            $pending = PlanAssociation::where('premium_type','App\\Listing')->where('premium_id', $listing->id)->where('status',0)->first();
            return view('add-listing.premium')->with('listing', $listing)->with('step', 'business-premium')->with('back', 'business-photos-documents')->with('cityy',$cityy)->with('plans',$plans)->with('current',$current)->with('pending',$pending);
        }
        if($listing->status == 1){
            if ($step == 'post-an-update'){
                $latest = $listing->updates()->orderBy('updated_at', 'desc')->first();
                return view('add-listing.post-updates')->with('listing', $listing)->with('step', 'business-updates')->with('back', 'business-premium')->with('cityy',$cityy)->with('post',$latest);
            }
            if ($step == 'manage-leads'){
                $parent_categ  = Category::where('type', 'listing')->whereNull('parent_id')->where('status', '1')->orderBy('order')->orderBy('name')->get();
                $cities       = City::where('status', '1')->get();
                return view('add-listing.manage-leads')->with('listing', $listing)->with('step', 'manage-leads')->with('back', 'business-premium')->with('cityy',$cityy)->with('parents', $parent_categ)->with('cities', $cities);
            }
        }
        abort(404);
    }

    public function submitForReview(Request $request)
    {

        $this->validate($request, [
            'listing_id' => 'required',
        ]);
        // dd($request);
        $listing = Listing::where('reference', $request->listing_id)->firstorFail();
        // dd('yes'); abort();
        if ($listing->isReviewable()) {
            saveListingStatusChange($listing, $listing->status, Listing::REVIEW);
            $listing->status          = Listing::REVIEW;
            $listing->submission_date = Carbon::now();
            $listing->save();

            $area = Area::with('city')->find($listing->locality_id);
            $owner = User::find($listing->owner_id);
            $email = [
                'subject' => "A listing has been submitted for review.",
                'template_data' => [
                    'listing_name' => $listing->title,
                    'listing_link' => url('/listing/'.$listing->reference.'/edit'),
                    'listing_type' => Listing::listing_business_type[$listing->type],
                    'listing_city' => $area->city['name'],
                    'listing_area' => $area->name,
                    'listing_categories' => ListingCategory::getCategories($listing->id),
                    'owner_name' => ($listing->owner_id!=null)? $owner->name: 'Orphan',
                    'owner_email' => ($listing->owner_id!=null)? $owner->getPrimaryEmail(): 'Nil',
                    'email_verified' => ($listing->owner_id!=null)? ($owner->getUserCommunications()->where('type','email')->where('is_primary',1)->first()->is_verified == 1)? 'verified': 'unverified' : 'NA',
                    'owner_phone' => ($listing->owner_id!=null)? $owner->getPrimaryContact(): 'Nil',
                    'phone_verified' => ($listing->owner_id!=null and $owner->getUserCommunications()->count() >= 2)? ($owner->getUserCommunications()->where('type','mobile')->where('is_primary',1)->first()->is_verified == 1)? 'verified': 'unverified' : 'NA',
                ],

            ];
            // dd($email);
            sendEmail('listing-submit-for-review',$email);
            // return \Redirect::back()->withErrors(array('review' => 'Your listing is not eligible for a review'));
            Session::flash('statusChange', 'review');
            return \Redirect::back();

        } else {
            return \Redirect::back()->withErrors(array('review' => 'Your listing is not eligible for a review'));
        }
    }

    public function archive(Request $request)
    {
        $this->validate($request, [
            'listing_id' => 'required',
        ]);
        $listing = Listing::where('reference', $request->listing_id)->firstorFail();
        if ($listing->isReviewable() and $listing->status == "1") {
            saveListingStatusChange($listing, $listing->status, Listing::ARCHIVED);
            $listing->status = Listing::ARCHIVED;
            $listing->save();
            Session::flash('statusChange', 'archive');
            return \Redirect::back();
        } else {
            return \Redirect::back()->withErrors(array('archive' => 'Only Published listings can be archived'));
        }
    }

    public function publish(Request $request)
    {
        $this->validate($request, [
            'listing_id' => 'required',
        ]);
        $listing = Listing::where('reference', $request->listing_id)->firstorFail();
        if ($listing->isReviewable() and $listing->status == "4") {
            saveListingStatusChange($listing, $listing->status, Listing::PUBLISHED);
            $listing->status = Listing::PUBLISHED;
            $listing->save();
            Session::flash('statusChange', 'published');
            return \Redirect::back();

        } else {
            return \Redirect::back()->withErrors(array('PUBLISHED' => 'You can only publish an archived listing'));
        }
    }

}
