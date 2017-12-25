<?php

namespace App\Http\Controllers;
use App\Area;
use App\City;
use App\Category;
use App\Plan;
use App\Job;
use App\Listing;
use App\PlanAssociation;
use App\ListingCategory;
use Carbon\Carbon;
use App\User;
use Session;
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

    public function getAreas(Request $request)
    {
        $this->validate($request, [
            'city' => 'required|min:1|integer',
        ]);
        
        

        $areaQuery = Area::where('city_id', $request->city)->where('status', '1');

        if(isset($request->area_name) && $request->area_name!=""){
             $areaQuery->where('name','like','%'.$request->area_name.'%');
        }

        $areas = $areaQuery->orderBy('order')->orderBy('name')->get();
        $res   = array();
        
        foreach ($areas as $area) {
            $res[] = array('id'=>$area->id,'name'=>$area->name,'slug'=>$area->slug);
        }
        
        return response()->json($res);
    }

    

    public function getCategories(Request $request,$type){ 
        // $this->validate($request, [
        //     'keyword' => 'required',
        // ]);

        $categories = Category::where("type",$type)->where('status',1)->where('name','like','%'.$request->keyword.'%')->orderBy('name')->get();
        
        return response()->json(['results' => $categories, 'options' => []]);
    } 

    /**
    * This function can be called in blade to generate the HTML required.
    * This function @return
    * [
    *   array("html" => "", "title" => "", "content" => ""),
    *   ....
    * ]
    * 
    * Note: This function is a duplicate of generateHTML() in app\Helper.php -> that was created for generating in blade
    *
    */
    public function generateHtml($layout_type, $css_classes="", $layout_id="", $name="", $ui_data=[], $data=[], $disabled='false') {
        $temp_html = []; $data_tag = '';
        $data_params = ["data-toggle", "data-target"];
        
        foreach ($data_params as $data_key => $data_value) { // If data tag is defined, then add to data_tag
            if (isset($data[$data_value]) && !empty($data[$data_value])) {
                $data_tag .= ' ' . $data_value . '="' . $data[$data_value] . '"';
            } else {
                $data_tag .= '';
            }
        }

        if ($disabled != 'false') { // If the html tag has to be disabled
            $disable_html = ' disabled=' . $disabled;
        } else {
            $disable_html = '';
        }

        if($layout_type == 'anchor') { // If <a> </a> i.e. Anchor tags
            if(isset($ui_data["target"]) and $ui_data['target']) { ### -- If 'target' in ui_data is True, then assign target data
                $target_ui = 'target="_blank"';
            } else {
                $target_ui = '';
            }

            if(isset($ui_data["href_url"]) && isset($ui_data['display'])) { // If this params are passed, then generate the anchor tag, else
                if (!isset($ui_data['value'])) {
                    $ui_data['value'] = '';
                }
                
                $temp_html["html"] = '<a href= "' . $ui_data['href_url'] . '" class="' . $css_classes . '" name="' . $name . '" id="' . $layout_id . '" ' . $data_tag . $disable_html . ' ' . $target_ui . ' value="'. $ui_data['value'] . '" >' . $ui_data['display'] . '</a>';
            } else {
                $temp_html["html"] = '<a href= "#" class="' . $css_classes . '" name="' . $name . '" id="' . $layout_id . '" ' . $data_tag . $disable_html . ' ' . $target_ui . ' value="'. $ui_data['value'] . '" >' . isset($ui_data['display']) ? $ui_data['display'] : '-' . '</a>';
            }
        } else if($layout_type == "checkbox") { // If checkbox
            if(isset($ui_data["checked"]) && $ui_data["checked"]) { // If checked param is passed, then enable the checkbox
                $temp_html["html"] = "<input type=\"checkbox\" class=\"" . $css_classes . "\" for=\"" . isset($ui_data["for"]) ? $ui_data["for"] : "" . "\" name=\"" . $name . "\" value=\"" . isset($ui_data["value"]) ? $ui_data["value"] : "" . "\" checked=\"true\"/>";
            } else {
                $temp_html["html"] = "<input type=\"checkbox\" class=\"" . $css_classes . "\" for=\"" . isset($ui_data["for"]) ? $ui_data["for"] : "" . "\" name=\"" . $name . "\" value=\"" . isset($ui_data["value"]) ? $ui_data["value"] : "" . "\"/>";
            }
        } else if ($layout_type == 'button') { ## If the request html layout is a button, then generate a button
            $temp_html["html"] = '<button class="' . $css_classes . '" name="' . $name . '" id="' . $layout_id . '" ' . $data_tag . $disable_html . '>' . $ui_data['display'] . '</button>';
        } else { // Else generate general text
            $temp_html["html"] = isset($ui_data['display']) ? $ui_data['display'] : '-';
        }

        if(isset($html_content["title"])) {
            $temp_html["title"] = $html_content["title"];
        }

        if(isset($html_content["content"])) {
            $temp_html["content"] = $html_content["content"];
        }

        return $temp_html;
    }

    public function checkIfEmailExist(Request $request) {
        $userauth_obj = new UserAuth;$response_data = []; $status;

        $user_data = array("email" => $request["email"], "username" => $request["email"]);

        $response_obj = $userauth_obj->checkIfUserExist($user_data, true);

        if($respone_obj["comm"] || $respone_obj["user"]) {
            $response_data = array("message" => "Email exist");
            $status = 400;
        } else {
            $response_data = array("message" => "No such email");
            $status = 200;
        }

        return response()->json($response_data, $status);
    }

    /**
    * This function is used to send a subscription request for job or listing.
    * It adds an entry in Plan association table
    * @param Request containing following:
    * id : Job or listing ID
    * type: job/listing
    * 
    * This function @return
    * [
    *   array("status" => "<<html code>>", "data" => [], "message" => "<<Error message if generated>>"),
    *   ....
    * ]
    * 
    *
    */
    public function premium(Request $request){ 
        $this->validate($request, [
            'id' => 'required',
            'type' => 'required',
            'plan_id' => 'required|integer'
        ]);

        $config = [
            'job' => ['table' => 'jobs', 'id' =>'reference_id', 'type' => 'listing'],
                'listing' => ['table' => 'listings', 'id' =>'reference','type' => 'listing'],
        ];

        $plan = Plan::find($request->plan_id);

        if(empty($plan)){
            return \Redirect::back()->withErrors(array('review' => 'Please select valod plan'));
        }

        if($request->type == 'listing'){
            $object = Listing::where($config['listing']['id'],$request->id)->firstOrFail();
            if ($object->status == 3 or $object->status == 5) {
                if ($object->isReviewable()) {
                    $object->status          = Listing::REVIEW;
                    $object->submission_date = Carbon::now();
                    $object->save();
                    $area = Area::with('city')->find($object->locality_id);
                    $owner = User::find($object->owner_id);
                    $email = [
                        'subject' => "A listing has been submitted for review.",
                        'template_data' => [
                            'listing_name' => $object->title,
                            'listing_link' => url('/listing/'.$object->reference.'/edit'),
                            'listing_type' => Listing::listing_business_type[$object->type],
                            'listing_city' => $area->city['name'],
                            'listing_area' => $area->name,
                            'listing_categories' => ListingCategory::getCategories($object->id),
                            'owner_name' => ($object->owner_id!=null)? $owner->name: 'Orphan',
                            'owner_email' => ($object->owner_id!=null)? $owner->getPrimaryEmail(): 'Nil',
                            'email_verified' => ($object->owner_id!=null)? ($owner->getUserCommunications()->where('type','email')->where('is_primary',1)->first()->is_verified == 1)? 'verified': 'unverified' : 'NA',
                            'owner_phone' => ($object->owner_id!=null)? $owner->getPrimaryContact(): 'Nil',
                            'phone_verified' => ($object->owner_id!=null and $owner->getUserCommunications()->count() >= 2)? ($owner->getUserCommunications()->where('type','mobile')->where('is_primary',1)->first()->is_verified == 1)? 'verified': 'unverified' : 'NA',
                        ],
                        
                    ];
                    // dd($email);
                    sendEmail('listing-submit-for-review',$email);
                    // return \Redirect::back()->withErrors(array('review' => 'Your listing is not eligible for a review'));
                    Session::flash('statusChange', 'review');
                    

                } else {
                    return \Redirect::back()->withErrors(array('review' => 'Your listing is not eligible for a review'));
                }
            }
        }elseif($request->type == 'job'){ 
            $userId = \Auth::user()->id;
            $object = Job::find($request->id);
            $premium = $request->is_premium;
            $activePlan = getActivePlan($object); 

            //check if same plan is requested again
            if((!empty($activePlan) && $activePlan->plan_id == $plan->id) ){
                Session::flash('error_message','You are alredy on '.$plan->title);
                return \Redirect::back();
            }


            //submit job for review if in draft state
            if(($object->status == 1 or $object->status == 5) && $object->isJobDataComplete()) {
                $object->submitForReviewEmail();
                Session::flash('job_review_pending','Job details submitted for review.');
            }
            
            //create plan

            if($premium[$request->plan_id] == "0")
            { 
                if($object->job_expires_on==''){
                    $expiryDate = date('Y-m-d H:i:s',strtotime("+".$plan->duration." days")); 
                    $object->job_expires_on = $expiryDate;
                }
                
            }
            else
               $object->job_expires_on = null; 

            $object->job_modifier = $userId;
            $object->updated_at = date('Y-m-d H:i:s');
            $object->save(); 

            
            

            if($premium[$request->plan_id] == "0")
            {
                return \Redirect::back();
            }
            else{

                $jobOwner = $object->createdBy;
                $templateData = [
                            'job' => $object,
                            'user' => $jobOwner,
                            'planname' => $plan->title,
                            ];

                $data = [];
                $data['from'] = $jobOwner->getPrimaryEmail();
                $data['name'] = $jobOwner->name;
                $data['to'] = [config('constants.email_to')];
                $data['subject'] = "Premium request received for job  ".$object->title." !";
                $data['template_data'] = $templateData;
                
                sendEmail('job-premium-request', $data);


            }
            
            

        }else{
            return response()->json(['status'=>"400", 'message'=>"Invalid Type"]);
        }

        Session::flash('success_message','Premium request sent successfully.');
        // dd(Plan::where('type', $config[$request->type]['type'])->where('id',$request->plan_id)->toSql());
        $object->premium()->where('status',0)->update(['status'=>2]);
        $premium = new PlanAssociation;
        $premium->plan_id = $plan->id;
        $object->premium()->save($premium);

        return \Redirect::back();
    }

    public function canclePremiumRequest($objectType,$referenceId){
        if($objectType == 'job'){
            $object = Job::where('reference_id',$referenceId)->first();
        }

        $object->premium()->where('status',0)->update(['status'=>2]);

        Session::flash('success_message','Premium request cancelled successfully.');
        return \Redirect::back();
    }
}
