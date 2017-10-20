<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Config;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Auth;

use Symfony\Component\Console\Output\ConsoleOutput;

use App\Category;
use App\Area;
use App\Listing;
use App\Job;
use App\Lead;
use App\Enquiry;
use App\EnquiryCategory;
use App\EnquiryArea;

use App\Http\Controllers\ListingViewController;

class EnquiryController extends Controller {
	/**
	* This function checks if the device the Session is active on is Mobile or Desktop
	*/
	public function isMobile() {
    	return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
	}

	/**
	* This function will validate the OTP
	*/
	public function validateContactOtp($contact_values=[], $key='contact') {
		$status = 404; $message = '';
		/*$this->validate($contact_values, [
            'otp' => 'integer|min:1000|max:9999',
            //'id'  => 'integer|min:1',
        ]);*/

        if(isset($contact_values['otp']) && ($contact_values['otp'] >= 1000 && $contact_values['otp'] <= 9999)) {
	        $json = Session::get($key);

	        if ($json == null) {
	            $status = 404;
	            $message = 'no_otp';
	        } else {
		        $array = json_decode($json);
		        $old   = Carbon::createFromTimestamp($array->timestamp);
		        $now   = Carbon::now();
		        
		        if ($now > $old->addMinutes(15)) {
		            $status = 410;
		            $message = 'otp_expired';
		        } else if ($contact_values["otp"] == $array->OTP) {
		        	$status = 200;
		        	$message = 'otp_matching';
		        } else {
		        	$status = 400;
		        	$message = 'incorrect_otp';
		        }
			}
		} else {
			$status = 400;
			$message = 'incorrect_otp';
		}

		return array("status" => $status, "message" => $message);
	}

	/**
	* Generate OTP for that contact Number
	*/
	public function generateContactOtp($key_value, $key = 'id') {
		$OTP = rand(1000, 9999);
        $timestamp = Carbon::now()->timestamp;
        $json = json_encode(array($key => $key_value, "OTP" => $OTP, "timestamp" => $timestamp));
        error_log($json); //send sms or email here
        //$request->session()->put('contact', $json);
        Session::put('contact', $json);
        Cookie::queue('mobile_otp', strVal($OTP), 120, '/', explode('://', env('APP_URL'))[1], '', false);

        //return ['keyword' => $key, 'value' => $key_value, 'OTP' => $OTP];
        return $json;
	}

	public function createEnquiry($enquiry_data=[], $enquiry_categories=[], $enquiry_area=[]) {

		if(sizeof($enquiry_data) > 0) {
			$enquiry_obj = Enquiry::create($enquiry_data);

			if(sizeof($enquiry_categories) > 0) {
				foreach ($enquiry_categories as $cat_key => $cat_value) {
					$category_obj = Category::where('slug', $cat_value)->first();
					$enquiry_cat_obj = EnquiryCategory::create(["enquiry_id" => $enquiry_obj->id, "category_id" => $category_obj->id]);
				}
			} else {
				$enquiry_cat_obj = [];
			}

			if(sizeof($enquiry_area) > 0) {
				foreach ($enquiry_area as $area_key => $area_value) {
					$area_obj = Area::where('id', $area_value)->first();
					$enquiry_area_obj = EnquiryArea::create(["enquiry_id" => $enquiry_obj->id, "area_id" => $area_obj->id, "city_id" => $area_obj->city_id]);
				}
			}
		} else {
			$enquiry_obj = [];
			$enquiry_cat_obj = [];
			$enquiry_area_obj = [];
		}

		return array("enquiry" => $enquiry_obj, "enquiry_categories" => "", "enquiry_areas" => "");
	}

	/**
	* This function is used to get respective Modal templates for the Enquiry with data pre-populated if any value found
	*/
   public function getEnquiryTemplate($template_type, $listing_slug="", $session_id = "") {
   		$response_html = ''; $template_name = '';
   		$listing_view_controller = new ListingViewController;
   		$output = new ConsoleOutput;

   		if(strlen($listing_slug) > 0) {
   			$listing_obj = Listing::where('slug', $listing_slug)->get();

    		if($listing_obj->count() > 0 && $listing_obj->first()->premium) { // If premium
    			$template_name .= "premium";
    		} else { // else it is non-premium account
    			$template_name .= "non_premium";
    		}

    		if(Auth::guest()) { // If user is not Logged In
    			$template_name .= "_not_logged_in";
    		} else { // If user is Logged In
    			$template_name .= "_logged_in";
    		}
	    	
	    	$template_config = config('enquiry_flow_config')[$template_name];
   			$listing = Listing::where('slug',$listing_slug)->get();
   			
   			if($listing->count() > 0) {
   				$listing = $listing->first();
	   			$data = $listing_view_controller->getListingData($listing); // Get the data for the Enquiry Modal template

		   		if($template_config[$template_type] == 'popup_level_one' && strlen($session_id) > 0) {
		   			// $value = session($session_id, 'default');
		   			$session_data = DB::table('sessions')->where('id', $session_id)->get();
		   			if($session_data->count() > 0) {
		   				$session_data = $session_data->first()->payload;
		   				$payload_data = unserialize(base64_decode($session_data));

		   				if(isset($payload_data["enquiry_data"])) { // If "enquiry_data" is present in the Session's payload
		   					$enquiry_data = $payload_data["enquiry_data"];
		   					$response_html = View::make('modals.listing_enquiry_popup.popup_level_one')->with(compact('enquiry_data', 'data'))->render();
		   				} else {
		   					$response_html = View::make('modals.listing_enquiry_popup.popup_level_one')->with(compact('data'))->render();
		   				}
		   			}
		   		} else if ($template_config[$template_type] == 'popup_level_two' && strlen($session_id) > 0) {
		   			/*$session_data = DB::table('sessions')->where('id', $session_id)->get();
		   			$session_data = $session_data->first()->payload;*/
	   				
	   				$next_template_type = "step_" . strVal(intVal(explode('step_', $template_type)[1]) + 1);

	   				$payload_data["enquiry_data"] = Session::get('enquiry_data', []); //unserialize(base64_decode($session_data));
	   				if(isset($payload_data["enquiry_data"]["contact"])) {
	   					$data['next_page'] = $next_template_type;
	   					$data['current_page'] = $template_type;
		   				$this->generateContactOtp($payload_data["enquiry_data"]["contact"], "contact"); // Generate OTP
		   				//$request->session()->put('contact', $this->generateContactOtp($payload_data["enquiry_data"]["contact"], "contact")); // Generate OTP

		   				$data["contact"] = $payload_data["enquiry_data"]["contact"];
			   			$response_html = View::make('modals.listing_enquiry_popup.popup_level_two')->with(compact('data'))->render();
			   		}
		   		} else if ($template_config[$template_type] == 'popup_level_three' && strlen($session_id) > 0) {
		   			$payload_data["enquiry_data"] = Session::get('enquiry_data', []);
		   			
		   			// $next_template_type = "step_" . strVal(intVal(explode('step_', $template_type)[1]) + 1);
		   			$data['current_page'] = $template_type;

		   			if(isset($payload_data["enquiry_data"]["contact"])) {
		   				$enquiry_data = $payload_data["enquiry_data"];
		   				$response_html = View::make('modals.listing_enquiry_popup.popup_level_three')->with(compact('data', 'enquiry_data'))->render();
			   		}

		   		} else {
		   			$response_html = View::make('modals.listing_enquiry_popup.enquiry_success_message')->with(compact('data', 'enquiry_data'))->render();
		   		}
		   	} else { // Listing_Slug not found
		   		$response_html = abort(404);
		   	}
	   	}

   		return $response_html;
   }

   /**
   * This function will @return
   *	A JSON that will contain the Modal DOM
   */
	public function requestTemplateEnquiry(Request $request) {
		// dd($request->session()->get(Cookie::get('laravel_session')));
		$session_id = Cookie::get('laravel_session');

		// dd($request->fullUrl());
		if($request->has('listing_slug')) {
			if($request->has('enquiry_level')) {
				$modal_template = $this->getEnquiryTemplate($request->enquiry_level, $request->listing_slug, $session_id);
			} else {
				$modal_template = $this->getEnquiryTemplate('step_1', $request->listing_slug, $session_id);
			}
		} else {
			$modal_template = '';
		}

		return response()->json(["modal_template" => $modal_template], 200);
	}

	/**
	* This function is called by the AJAX to add new Listing Enquiries 
	*/
	public function getEnquiry(Request $request) {
		$output = new ConsoleOutput; $status = 500; $template_name = '';
		$listing_obj_type = "App\Listing"; $listing_obj_id = 0; $listing_obj = '';
		
		$session_id = Cookie::get('laravel_session');
		$template_type = $request->has('enquiry_level') && strlen($request->enquiry_level) > 0 ? $request->enquiry_level : 'step_1';
		
		if($request->has('listing_slug') && strlen($request->listing_slug) > 0) {
			if($request->has('enquiry_to_type') && $request->enquiry_to_type == "job") {
				$listing_obj = Job::where('slug', $request->listing_slug)->get();
				$listing_obj_type = "App\Job";
				$listing_obj_id = $listing_obj->count() > 0 ? $listing_obj->first()->id : 0;
			} else {
				$listing_obj = Listing::where('slug', $request->listing_slug)->get();
				$listing_obj_type = "App\Listing";
				$listing_obj_id = $listing_obj->count() > 0 ? $listing_obj->first()->id : 0;
			}

			if($listing_obj->count() > 0 && $listing_obj->first()->premium) { // If premium
				$template_name .= "premium";
			} else { // else it is non-premium account
				$template_name .= "non_premium";
			}

			if(Auth::guest()) { // If user is not Logged In
				$template_name .= "_not_logged_in";
			} else { // If user is Logged In
				$template_name .= "_logged_in";
			}
			
			$template_config = config('enquiry_flow_config')[$template_name][$template_type];
			// dd($template_name);
		} else {
			$template_config = "popup_level_one";
			$listing_obj = Listing::where('slug', '')->get();
		}

		if($template_config == 'popup_level_one' && strlen($session_id) > 0 && $listing_obj->count() > 0) {
			$session_obj = DB::table('sessions')->where('id', $session_id);
			if($session_obj->count() > 0) {
				// $payload_data = unserialize(base64_decode($session_obj->get()->first()->payload));
				$payload_data = [];
				if($request->has('name') && $request->has('email')) {
					$payload_data["enquiry_data"] = array("name" => $request->name, "email" => $request->email);
					$payload_data["enquiry_data"]["contact"] = ($request->has('contact')) ? $request->contact : "";
					$payload_data["enquiry_data"]["describes_best"] = ($request->has('description')) ? $request->description : "";
					$payload_data["enquiry_data"]["enquiry_message"] = ($request->has('enquiry_message')) ? $request->enquiry_message : "";

					$payload_data["enquiry_data"]["enquiry_to_id"] = $listing_obj_id;
					$payload_data["enquiry_data"]["enquiry_to_type"] = $listing_obj_type;

					// $payload_data = base64_encode(serialize($payload_data));
					//$op = $session_obj->update(['payload' => $payload_data]); // Serialize & Save the Payload content
					
					Session::put('enquiry_data', $payload_data["enquiry_data"]);
					Cookie::queue('user_id', '0', 120, '/', explode('://', env('APP_URL'))[1], '', false);
					Cookie::queue('user_type', 'lead', 120, '/', explode('://', env('APP_URL'))[1], '', false);

					$modal_template_html = $this->getEnquiryTemplate("step_2", $listing_obj->first()->slug, $session_id);
					$status = 200;
				} else {
					$status = 400;
					//$output->writeln("No name & email");
				}
			} else {
				$status = 404;
			}
		} else if($template_config == "popup_level_three") {
			if($listing_obj->count() > 0) {
				$session_payload = Session::get('enquiry_data', "[]");

				if(Auth::guest()) {
					$lead_obj = Lead::where([['email', $request->email], ['mobile', $request->contact]])->get();
					$lead_type = "App\Lead";
					$lead_obj = $lead_obj->first();
				} else {
					$lead_obj = Auth::user();
					$lead_type = "App\User";
				}
				
				$enquiry_data = ["user_object_id" => $lead_obj->id, "user_object_type" => $lead_type, "enquiry_device" => $this->isMobile() ? "mobile" : "desktop", "enquiry_type" => "shared", "enquiry_to_id" => $session_payload["enquiry_to_id"], "enquiry_to_type" => $session_payload["enquiry_to_type"], "enquiry_message" => $session_payload["enquiry_message"]];

				if($request->has('categories_interested') && sizeof($request->categories_interested) > 0) {
					$enquiry_categories = $request->categories_interested;
				} else {
					$enquiry_categories = [];
				}

				if($request->has('area') && sizeof($request->area) > 0) {
					$enquiry_areas = $request->area;
				} else {
					$enquiry_areas = [];
				}

				$enq_objs = $this->createEnquiry($enquiry_data, $enquiry_categories, $enquiry_areas);
				$next_template_type = "step_" . strVal(intVal(explode('step_', $template_type)[1]) + 1);
				$modal_template_html = $this->getEnquiryTemplate($next_template_type, $listing_obj->first()->slug, $session_id);
				$status = 200;
			}
		} else if($template_config == "popup_level_four") {
			$next_template_type = "step_" . strVal(intVal(explode('step_', $template_type)[1]) + 1);
			$modal_template_html = $this->getEnquiryTemplate($next_template_type, $listing_obj->first()->slug, $session_id);;
			$status = 200;
		}

		return response()->json(["popup_template" => $modal_template_html], $status);
	}

	/**
	* This function is used to verify the OTP
	*/
    public function verifyOtp(Request $request) {
    	$status = 400; $modal_template_html = '';

    	if($request->has('listing_slug')) {
	    	$session_id = Cookie::get('laravel_session');
	    	$template_type = $request->has('enquiry_level') && strlen($request->enquiry_level) > 0 ? $request->enquiry_level : 'step_1';

	    	if($request->has('contact') && $request->has('otp') && strlen($request->contact) > 0 && strlen($request->otp) == 4) {
	    		$contact_data = ["contact" => $request->contact, "otp" => $request->otp];
	    		$validation_status = $this->validateContactOtp($contact_data, "contact");

	    		if($validation_status["status"] == 200) {
	    			$status = 200;
	    			$session_payload = Session::get('enquiry_data', "[]");
	    			
	    			if(sizeof($session_payload) > 0) {
	    				if(Auth::guest()) {
	    					$lead_obj = Lead::create(["name" => $session_payload["name"], "email" => $session_payload["email"], "mobile" => $session_payload["contact"], "is_verified" => true, "lead_creation_date" => date("Y-m-d H:i:s")]);
	    					$lead_type = "App\Lead";
	    				} else {
	    					$lead_obj = Auth::user();//Lead::create(["name" => $session_payload["name"], "email" => $session_payload["email"], "mobile" => $session_payload["contact"], "is_verified" => true, "lead_creation_date" => date("Y-m-d H:i:s"), "user_id" => Auth::user()->id]);
	    					$lead_type = "App\User";
	    				}

	    				if(sizeof($session_payload) > 0) {
	    					$enquiry_data = ["user_object_id" => $lead_obj->id, "user_object_type" => $lead_type, "enquiry_device" => $this->isMobile() ? "mobile" : "desktop", "enquiry_type" => "direct", "enquiry_to_id" => $session_payload["enquiry_to_id"], "enquiry_to_type" => $session_payload["enquiry_to_type"], "enquiry_message" => $session_payload["enquiry_message"]];

	    					$this->createEnquiry($enquiry_data, [], []);
	    					// $session_payload["enquiry_id"] = $enquiry_obj->id;
	    				}

	    			}
	    			// $next_template_type = "step_" . strVal(intVal(explode('step_', $template_type)[1]) + 1);
	    			$modal_template_html = $this->getEnquiryTemplate($template_type, $request->listing_slug, $session_id);


	    		} else {
	    			$status = $validation_status["status"];
	    			$modal_template_html = "";
	    		}
	    	} else if($request->has('regenerate') && $request->regenerate == "true") { // Regenerate OTP
    			$modal_template_html = $this->getEnquiryTemplate($template_type, $request->listing_slug, $session_id);
    			$status = 200;
    		}
	    } else {
	    	$modal_template_html = "";
	    }

	    return response()->json(["popup_template" => $modal_template_html], $status);
    }
}