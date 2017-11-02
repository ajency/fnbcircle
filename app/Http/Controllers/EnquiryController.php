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
use App\ListingCategory;
use App\ListingAreasOfOperation;
use App\Job;
use App\Lead;
use App\Enquiry;
use App\EnquirySent;
use App\EnquiryCategory;
use App\EnquiryArea;

use App\Http\Controllers\ListingViewController;
use App\Http\Controllers\CookieController;

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

        if(isset($contact_values['otp']) && strlen($contact_values['otp']) !== 4) {
        	$status = 404;
        	$message = 'no_otp';
        } else if(isset($contact_values['otp']) && ($contact_values['otp'] >= 1000 && $contact_values['otp'] <= 9999)) {
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
        Session::put('contact_info', $json);
        
        if(env('APP_DEBUG')) {
        	$cookie_cont_obj = new CookieController;
        	$other_cookie_params = ["path" => "/", "domain" => sizeof(explode('://', env('APP_URL'))) > 1 ? (explode('://', env('APP_URL'))[1]) : (explode('://', env('APP_URL'))[0]), "http_only" => true];
        	$cookie_cont_obj->set('mobile_otp', strVal($OTP), $other_cookie_params);
        }

        //return ['keyword' => $key, 'value' => $key_value, 'OTP' => $OTP];
        return $json;
	}

	/**
	* This function is used to create Enquiry data
	* This function will @return the following Enquiry objects
	*	Enquiry, EnquirySent, EnquiryCategory & EnquiryArea
	*/
	public function createEnquiry($enquiry_data=[], $enquiry_sent=[], $enquiry_categories=[], $enquiry_area=[]) {

		if (sizeof($enquiry_data) > 0 && isset($enquiry_data["enquiry_id"]) && $enquiry_data["enquiry_id"] > 0) { // Get data if ID is passed
			$enquiry_obj = Enquiry::find($enquiry_data["enquiry_id"]);
		} else if(sizeof($enquiry_data) > 0) { // Create data if params are passed
			$enquiry_obj = Enquiry::create($enquiry_data);
		} else {
			$enquiry_obj = null;
		}

		if($enquiry_obj) { // If enquiry object exist, then add other data
			$enquiry_sent["enquiry_id"] = $enquiry_obj["id"];
			$enquiry_sent_obj = EnquirySent::create($enquiry_sent);

			if(sizeof($enquiry_categories) > 0) {
				foreach ($enquiry_categories as $cat_key => $cat_value) {
					$category_obj = Category::where('slug', $cat_value)->first();
					$enquiry_cat_obj = EnquiryCategory::create(["enquiry_id" => $enquiry_obj["id"], "category_id" => $category_obj->id]);
				}
			} else {
				$enquiry_cat_obj = [];
			}

			if(sizeof($enquiry_area) > 0) {
				foreach ($enquiry_area as $area_key => $area_value) {
					$area_obj = Area::where('id', $area_value)->first();
					$enquiry_area_obj = EnquiryArea::create(["enquiry_id" => $enquiry_obj["id"], "area_id" => $area_obj->id, "city_id" => $area_obj->city_id]);
				}
			} else {
				$enquiry_area_obj = [];
			}
		} else {
			$enquiry_obj = null;
			$enquiry_sent_obj = null;
			$enquiry_cat_obj = null;
			$enquiry_area_obj = null;
		}

		return array("enquiry" => $enquiry_obj, "enquiry_sent" => $enquiry_sent_obj, "enquiry_categories" => $enquiry_cat_obj, "enquiry_areas" => $enquiry_area_obj);
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
		   			$payload_data = Session::get('enquiry_data', []);

	   				if(sizeof($payload_data)) { // If "enquiry_data" is present in the Session's payload
	   					$enquiry_data = $payload_data;
	   					$response_html = View::make('modals.listing_enquiry_popup.popup_level_one')->with(compact('enquiry_data', 'data'))->render();
	   				} else {
	   					$response_html = View::make('modals.listing_enquiry_popup.popup_level_one')->with(compact('data'))->render();
	   				}
		   		} else if ($template_config[$template_type] == 'popup_level_two' && strlen($session_id) > 0) {
		   			$next_template_type = "step_" . strVal(intVal(explode('step_', $template_type)[1]) + 1);

	   				$payload_data["enquiry_data"] = Session::get('enquiry_data', []); //unserialize(base64_decode($session_data));
	   				if(isset($payload_data["enquiry_data"]["contact"])) {
	   					$data['next_page'] = $next_template_type;
	   					$data['current_page'] = $template_type;
		   				$this->generateContactOtp('+' . $payload_data["enquiry_data"]["contact_code"] . $payload_data["enquiry_data"]["contact"], "contact"); // Generate OTP
		   				
		   				$data["contact_code"] = $payload_data["enquiry_data"]["contact_code"];
		   				$data["contact"] = $payload_data["enquiry_data"]["contact"];
			   			$response_html = View::make('modals.listing_enquiry_popup.popup_level_two')->with(compact('data'))->render();
			   		}
		   		} else if ($template_config[$template_type] == 'popup_level_three' && strlen($session_id) > 0) {
		   			$payload_data["enquiry_data"] = Session::get('enquiry_data', []);
		   			
		   			$data['current_page'] = $template_type;

		   			if(isset($payload_data["enquiry_data"]["contact"])) {
		   				$enquiry_data = $payload_data["enquiry_data"];
		   				$parents  = Category::where('type', 'listing')->whereNull('parent_id')->where('status', '1')->orderBy('order')->orderBy('name')->get();
            			$categories = ListingCategory::getCategories($listing->id);
		   				$response_html = View::make('modals.listing_enquiry_popup.popup_level_three')->with(compact('data', 'enquiry_data', 'parents', 'categories'))->render();
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
		$session_id = Cookie::get('laravel_session');

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
		$output = new ConsoleOutput; $status = 500; $template_name = '';$modal_template_html = '';
		$listing_obj_type = "App\Listing"; $listing_obj_id = 0; $listing_obj = '';
		$cookie_cont_obj = new CookieController;
		
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
		} else {
			$template_config = "popup_level_one";
			$listing_obj = Listing::where('slug', '')->get();
		}

		if($template_config == 'popup_level_one' && strlen($session_id) > 0 && $listing_obj->count() > 0) {
			$session_obj = DB::table('sessions')->where('id', $session_id);
			if($session_obj->count() > 0) {
				// $payload_data = unserialize(base64_decode($session_obj->get()->first()->payload));
				$payload_data = ["enquiry_data" => Session::get('enquiry_data', [])];
				if($request->has('name') && $request->has('email')) {
					$payload_data["enquiry_data"]['name'] = $request->name;
					$payload_data["enquiry_data"]['email'] = $request->email;
					$payload_data["enquiry_data"]["contact_code"] = (($request->has('contact_locality')) ? $request->contact_locality : "");
					$payload_data["enquiry_data"]["contact"] = ($request->has('contact')) ? $request->contact : "";
					$payload_data["enquiry_data"]["describes_best"] = ($request->has('description')) ? $request->description : "";
					$payload_data["enquiry_data"]["enquiry_message"] = ($request->has('enquiry_message')) ? $request->enquiry_message : "";

					$payload_data["enquiry_data"]["enquiry_to_id"] = $listing_obj_id;
					$payload_data["enquiry_data"]["enquiry_to_type"] = $listing_obj_type;

					// $payload_data = base64_encode(serialize($payload_data));
					//$op = $session_obj->update(['payload' => $payload_data]); // Serialize & Save the Payload content
					

					if(!($cookie_cont_obj->get('user_id') && $cookie_cont_obj->get('user_type'))) { // Set Cookie if it doesn't exist
						$cookie_cont_obj->generateDefaults();
					}

					$verified_session = Session::get('otp_verified', []);
					
					if(isset($payload_data["enquiry_data"]["user_object_id"]) && isset($verified_session["mobile"]) && $verified_session["mobile"] && $listing_obj->first()->premium) {
						$enquiry_data = ["user_object_id" => isset($payload_data["enquiry_data"]["user_object_id"]) ? $payload_data["enquiry_data"]["user_object_id"] : null, "user_object_type" => isset($payload_data["enquiry_data"]["user_object_type"]) ? $payload_data["enquiry_data"]["user_object_type"] : "App\Lead", "enquiry_device" => $this->isMobile() ? "mobile" : "desktop", "enquiry_to_id" => $payload_data["enquiry_data"]["enquiry_to_id"], "enquiry_to_type" => $payload_data["enquiry_data"]["enquiry_to_type"], "enquiry_message" => $payload_data["enquiry_data"]["enquiry_message"]];

    					$enquiry_sent = ["enquiry_type" => "direct", "enquiry_to_id" => $payload_data["enquiry_data"]["enquiry_to_id"], "enquiry_to_type" => $payload_data["enquiry_data"]["enquiry_to_type"]];

    					$create_enq_response = $this->createEnquiry($enquiry_data, $enquiry_sent, [], []);
    					$payload_data["enquiry_data"]["enquiry_id"] = $create_enq_response["enquiry"]->id;

						$modal_template_html = $this->getEnquiryTemplate("step_3", $listing_obj->first()->slug, $session_id);
					} else {
						$modal_template_html = $this->getEnquiryTemplate("step_2", $listing_obj->first()->slug, $session_id);
					}

					Session::put('enquiry_data', $payload_data["enquiry_data"]);

					$status = 200;
				} else {
					$status = 400;
				}
			} else {
				$status = 404;
			}
		} else if($template_config == "popup_level_three") {
			if($listing_obj && $listing_obj->count() > 0) {
				$session_payload = Session::get('enquiry_data', []);

				if(Auth::guest()) {
					$lead_obj = Lead::where([['email', $request->email], ['mobile', $request->contact_locality . '-' . $request->contact]])->get();
					$lead_type = "App\Lead";
					if($lead_obj->count() > 0) {
						$lead_obj = $lead_obj->first();
					} else {
						$lead_obj = null;
					}
				} else {
					$lead_obj = Auth::user();
					$lead_type = "App\User";
				}

				$create_enq_response = null;

				if(!Auth::guest()) { // If logged In user, then Save the Primary Enquiry Data
					/*** 1st Enquiry flow ***/
					if(sizeof($session_payload) > 0) {
    					$enquiry_data = ["user_object_id" => $lead_obj->id, "user_object_type" => $lead_type, "enquiry_device" => $this->isMobile() ? "mobile" : "desktop", "enquiry_to_id" => $session_payload["enquiry_to_id"], "enquiry_to_type" => $session_payload["enquiry_to_type"], "enquiry_message" => $session_payload["enquiry_message"]];

    					$enquiry_sent = ["enquiry_type" => "direct", "enquiry_to_id" => $session_payload["enquiry_to_id"], "enquiry_to_type" => $session_payload["enquiry_to_type"]];

    					$create_enq_response = $this->createEnquiry($enquiry_data, $enquiry_sent, [], []);
					}
					/*** End of 1st Enquiry flow ***/
				}

				/*** 2nd Enquiry flow ***/
				if($create_enq_response) {
					$enquiry_data = ["enquiry_id" => $create_enq_response["enquiry"]['id']];
				} else if(isset($session_payload["enquiry_id"]) && $session_payload["enquiry_id"] > 0) {
					$enquiry_data = ["enquiry_id" => $session_payload["enquiry_id"]];
				} else {
					$enquiry_data = ["user_object_id" => isset($lead_obj['id']) ? $lead_obj->id : '', "user_object_type" => $lead_type, "enquiry_device" => $this->isMobile() ? "mobile" : "desktop", "enquiry_to_id" => $session_payload["enquiry_to_id"], "enquiry_to_type" => $session_payload["enquiry_to_type"], "enquiry_message" => $session_payload["enquiry_message"]];
				}

				$enquiry_sent = ["enquiry_type" => "shared", "enquiry_to_id" => $session_payload["enquiry_to_id"], "enquiry_to_type" => $session_payload["enquiry_to_type"]];

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
				
				if($listing_obj->first()->premium || !Auth::guest()) { // If premium or (not guest User) then save the data
					$listing_operations_ids = ListingAreasOfOperation::whereIn('area_id', $enquiry_areas)->distinct('listing_id')->pluck('listing_id')->toArray();

					if(isset($enquiry_sent['enquiry_to_id']) && $enquiry_sent['enquiry_to_id'] > 0) { // Remove the Primary Enquiry's Listing ID if the Listing ID exist in the Array
						$pos = array_search($enquiry_sent['enquiry_to_id'], $listing_operations_ids);
						unset($session_payload[$pos]);
					}

					foreach ($listing_operations_ids as $op_key => $op_value) {
						$enquiry_sent["enquiry_to_id"] = $op_value;
						$enq_objs = $this->createEnquiry($enquiry_data, $enquiry_sent, $enquiry_categories, $enquiry_areas);
					}
					unset($session_payload["enquiry_id"]);
					unset($session_payload["enquiry_to_id"]);
					unset($session_payload["enquiry_to_enquiry"]);
				} else {
					Session::put('second_enquiry_data', ["enquiry_data" => $enquiry_data, "enquiry_sent" => $enquiry_sent, "enquiry_category" => $enquiry_categories, "enquiry_area" => $enquiry_areas]);
				}

				/*** End of 2nd Enquiry flow ***/

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

    	if($request->has('listing_slug') && $request->has('contact') && strlen($request->contact) > 0) {
	    	$session_id = Cookie::get('laravel_session');
	    	$template_type = $request->has('enquiry_level') && strlen($request->enquiry_level) > 0 ? $request->enquiry_level : 'step_1';

	    	if($request->has('new_contact') && isset($request->new_contact["country_code"]) && isset($request->new_contact["contact"])) { // New Contact Number
    			$session_payload = Session::get('enquiry_data', []);
    			$session_payload["contact_code"] = $request->new_contact["country_code"];
    			$session_payload["contact"] = $request->new_contact["contact"];

    			Session::flush('enquiry_data'); // Delete the Old enquiry_data
				Session::put('enquiry_data', $session_payload); // Create new Enquiry Data
	    		//$this->generateContactOtp('+' . $request->new_contact["country_code"] . $request->new_contact["contact"], "contact"); // Generate OTP
	    		$modal_template_html = $this->getEnquiryTemplate($template_type, $request->listing_slug, $session_id);

    			$status = 200;
    		} else if($request->has('regenerate') && $request->regenerate == "true") { // Regenerate OTP
    			$modal_template_html = $this->getEnquiryTemplate($template_type, $request->listing_slug, $session_id);
    			$status = 200;
    		} else if($request->has('otp')) {
	    		$contact_data = ["contact" => $request->contact, "otp" => $request->otp];
	    		$validation_status = $this->validateContactOtp($contact_data, "contact_info");

	    		if($validation_status["status"] == 200) {
	    			$status = 200;
	    			$session_payload = Session::get('enquiry_data', []);
    				$secondary_enquiry_data = Session::get('second_enquiry_data', []);
	    			
	    			if(sizeof($session_payload) > 0) {
	    				if(Auth::guest()) {
	    					$lead_obj = Lead::create(["name" => $session_payload["name"], "email" => $session_payload["email"], "mobile" => $session_payload["contact_code"] . '-' . $session_payload["contact"], "user_details_meta" => serialize(["describes_best" => $session_payload["describes_best"]]), "is_verified" => true, "lead_creation_date" => date("Y-m-d H:i:s")]);
	    					$lead_type = "App\Lead";
	    				} else {
	    					$lead_obj = Auth::user();//Lead::create(["name" => $session_payload["name"], "email" => $session_payload["email"], "mobile" => $session_payload["contact"], "is_verified" => true, "lead_creation_date" => date("Y-m-d H:i:s"), "user_id" => Auth::user()->id]);
	    					$lead_type = "App\User";
	    				}

	    				/*** 1st Enquiry flow ***/
	    				if(sizeof($session_payload) > 0) {
	    					$enquiry_data = ["user_object_id" => $lead_obj->id, "user_object_type" => $lead_type, "enquiry_device" => $this->isMobile() ? "mobile" : "desktop",  "enquiry_to_id" => $session_payload["enquiry_to_id"], "enquiry_to_type" => $session_payload["enquiry_to_type"], "enquiry_message" => $session_payload["enquiry_message"]];

	    					$enquiry_sent = ["enquiry_type"=> "direct", "enquiry_to_id" => $session_payload["enquiry_to_id"], "enquiry_to_type" => $session_payload["enquiry_to_type"]];
	    					$enq_obj = $this->createEnquiry($enquiry_data, $enquiry_sent, [], []);

	    					$session_payload["enquiry_id"] = $enq_obj["enquiry"]->id;
	    					$session_payload["user_object_id"] = $enquiry_data["user_object_id"];
	    					$session_payload["user_object_type"] = $enquiry_data["user_object_type"];
	    					
	    					Session::flush('enquiry_data'); // Delete the Old enquiry_data
	    					Session::put('enquiry_data', $session_payload); // Create new Enquiry Data
	    				} else {
	    					$enq_obj = null;
	    				}
	    				/*** End of 1st Enquiry flow ***/
	    			
	    				Session::put('otp_verified', ['mobile' => true, "contact" => $session_payload["contact"]]); // Add the OTP verified flag to Session

	    				/*** 2nd Enquiry flow ***/
	    				if(sizeof($secondary_enquiry_data) > 0) { // If the key exist & value is not NULL
	    					if($enq_obj && isset($enq_obj["enquiry"])) {
	    						$secondary_enquiry_data['enquiry_data']['enquiry_id'] = $enq_obj["enquiry"]->id;
	    					} else if(isset($session_payload['enquiry_id']) && $session_payload['enquiry_id'] > 0) {
	    						$secondary_enquiry_data['enquiry_data']['enquiry_id'] = $session_payload['enquiry_id'];
	    					}

	    					$secondary_enquiry_data['enquiry_data']["user_object_id"] = $lead_obj->id;
	    					$secondary_enquiry_data['enquiry_data']["user_object_type"] = $lead_type;

	    					$listing_operations_ids = ListingAreasOfOperation::whereIn('area_id', $secondary_enquiry_data['enquiry_area'])->distinct('listing_id')->pluck('listing_id')->toArray();

							if(isset($secondary_enquiry_data['enquiry_sent']['enquiry_to_id']) && $secondary_enquiry_data['enquiry_sent']['enquiry_to_id'] > 0) { // Remove the Primary Enquiry's Listing ID if the Listing ID exist in the Array
								$pos = array_search($secondary_enquiry_data['enquiry_sent']['enquiry_to_id'], $listing_operations_ids);
								unset($listing_operations_ids[$pos]);
							}

							foreach ($listing_operations_ids as $op_key => $op_value) {
								$secondary_enquiry_data['enquiry_sent']["enquiry_to_id"] = $op_value;
								$this->createEnquiry($secondary_enquiry_data['enquiry_data'], $secondary_enquiry_data['enquiry_sent'], $secondary_enquiry_data['enquiry_category'], $secondary_enquiry_data['enquiry_area']);
							}

	    					unset($session_payload["enquiry_id"]); // Remove the Enquiry ID after save of the data
	    					unset($session_payload["enquiry_to_id"]);
							unset($session_payload["enquiry_to_enquiry"]);
	    					Session::flush('second_enquiry_data'); // Delete this key from the session
	    				}
	    				/*** End of 2nd Enquiry flow ***/

	    			}
	    			// $next_template_type = "step_" . strVal(intVal(explode('step_', $template_type)[1]) + 1);
	    			$modal_template_html = $this->getEnquiryTemplate($template_type, $request->listing_slug, $session_id);


	    		} else {
	    			$status = $validation_status["status"];
	    			$modal_template_html = "";
	    		}
	    	}
	    } else {
	    	$modal_template_html = "";
	    }

	    return response()->json(["popup_template" => $modal_template_html], $status);
    }

    /**
    * This function is used to Get all the Children of a category
    */
    public function getCategories($type='listing', $parent_values = [], $column_search = 'id', $statuses=[]) {
    	$parent_array = [];
    	$parents = [];

    	if($column_search !== "id") {
    		$parents = Category::whereIn('slug', $parent_values)->pluck('id')->toArray();
    	} else {
    		$parents = $parent_values;
    	}

        foreach ($parents as $parent) {
            if(sizeof($statuses) > 0) {
            	$children = Category::where('type', $type)->where('parent_id', $parent)->whereIn('status', $statuses)->orderBy('order')->orderBy('name')->get();
            } else {
            	$children = Category::where('type', $type)->where('parent_id', $parent)->where('status', 1)->orderBy('order')->orderBy('name')->get();
            }
            
            $child_array = array();

            foreach ($children as $child_index => $child) {
            	//$child_array[$child->id] = array('id' => $child->id, 'name' => $child->name, 'order' => $child->order, 'slug' => $child->slug);
            	array_push($child_array, array('id' => $child->id, 'name' => $child->name, 'order' => $child->order, 'slug' => $child->slug));
            }

            $parent_obj = Category::find($parent);

            if ($parent_obj->parent_id != null) {
                $grandparent = Category::findorFail($parent_obj->parent_id);
            } else {
                $grandparent = new Category;
            }

            //$parent_array[$parent_obj->id] = array('name' => $parent_obj->name, 'children' => $child_array, 'parent' => $grandparent);
            array_push($parent_array, array('id' => $parent_obj->id, 'name' => $parent_obj->name, 'slug' => $parent_obj->slug, 'children' => $child_array, 'parent' => $grandparent));
        }
        return $parent_array;
    }

    /**
    * This function will return a DOM having Branch & node categories
    */
    public function getListingCategories(Request $request) {
    	$this->validate($request, [
            'category' => 'required',
        ]);

    	$sub_categories = [];
    	$statuses = $request->has('statuses') ? $request->statuses : [];

    	if(is_array($request->category)) {
        	$sub_categories = $this->getCategories('listing', $request->category, 'slug', $statuses);
        } else if(strpos(" " . $request->category, '[')){ // Adding <space> before the string coz if the indexOf '[' == 0, then it returns index i.e. '0' & if not found, then 'false' i.e. 0 { 'true' => 1, 'false' => 0)
        	$sub_categories = $this->getCategories('listing', json_decode($request->category), 'slug', $statuses);
        } else {
        	$sub_categories = $this->getCategories('listing', [$request->category], 'slug', $statuses);
        }

        // Take the 1st Parent Category
        $sub_categories = $sub_categories[0];

        // If Children (Branch) Category exist, then get the child of that 1st Branch category i.e. Grand child of parent Category
        if(isset($sub_categories["children"]) && sizeof($sub_categories["children"]) > 0) {
        	$node_children = $this->getCategories('listing', [$sub_categories["children"][0]["id"]], []);
        	if(sizeof($node_children) > 0 && isset($node_children[0]["children"])) {
        		$sub_categories["children"][0]["node_children"] = $node_children[0]["children"];
        	} else {
        		$sub_categories["children"][0]["node_children"] = [];
        	}
        }

        $view_blade = View::make('modals.category_selection.level_two')->with(compact('sub_categories'))->render();

        return response()->json(array("modal_template" => $view_blade), 200);
    }

    /**
    * This function will return an array of children (node) of a Branch category
    */
    public function getNodeCategories(Request $request) {
    	$this->validate($request, [
            'branch' => 'required',
        ]);

        $node_categories = [];
        $statuses = $request->has('statuses') ? $request->statuses : [];

    	if(is_array($request->branch)) {
        	$node_categories = $this->getCategories('listing', $request->branch, 'slug', $statuses);
        } else if(strpos(" " . $request->branch, '[')){ // Adding <space> before the string coz if the indexOf '[' == 0, then it returns index i.e. '0' & if not found, then 'false' i.e. 0 { 'true' => 1, 'false' => 0)
        	$node_categories = $this->getCategories('listing', json_decode($request->branch), 'slug', $statuses);
        } else {
        	$node_categories = $this->getCategories('listing', [$request->branch], 'slug', $statuses);
        }

        //$node_categories = $node_categories[0];

        return response()->json(array("data" => $node_categories), 200);
    }

    public function getCategoryModalDom(Request $request) {
		$this->validate($request, [
            'level' => 'required',
        ]);
		$modal_template = "";
		$parents  = Category::where('type', 'listing')->whereNull('parent_id')->where('status', '1')->orderBy('order')->orderBy('name')->get();

		if($request->level == "level_1") {
			$modal_template = View::make('modals.category_selection.level_one')->with(compact('parents'))->render();
		}
		return response()->json(array("modal_template" => $modal_template), 200);
    }
}