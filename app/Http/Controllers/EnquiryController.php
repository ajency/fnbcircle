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

use App\User;
use App\UserCommunication;
use App\Category;
use App\City;
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
use App\Http\Controllers\ListViewController;
use App\Http\Controllers\CookieController;
use App\Http\Controllers\Auth\RegisterController;
use Ajency\User\Ajency\userauth\UserAuth;
use Spatie\Activitylog\Models\Activity;

use App\Jobs\ProcessEnquiry;

class EnquiryController extends Controller {
	/**
	* This function checks if the device the Session is active on is Mobile or Desktop
	*/
	public function isMobile() {
    	return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
	}

	public function setOtpVerified($is_mobile_verified, $contact_no) {
		$otp_verified_json = ['mobile' => $is_mobile_verified, "contact" => $contact_no];
		Session::put('otp_verified', $otp_verified_json); // Add the OTP verified flag to Session
		return $otp_verified_json;
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
        
        if(isset($contact_values['otp']) && strlen($contact_values['otp']) < 0) { // If OTP value not passed
        	$status = 404;
        	$message = 'no_otp';
        } else if(isset($contact_values['otp']) && (intval($contact_values['otp']) >= 1000 && intval($contact_values['otp']) <= 9999)) { // If value passed & is within the range [1000, 9999]
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
	public function generateContactOtp($key_value, $key = 'id',$country = "", $phone = "") {
		$OTP = rand(1000, 9999);
        $timestamp = Carbon::now()->timestamp;
        $json = json_encode(array($key => $key_value, "OTP" => $OTP, "timestamp" => $timestamp, 'country_code' => $country,'phone_no' => $phone));
        error_log($json); //send sms or email here
        Session::put('contact_info', $json);

        if($key == "contact") {
	        $sms = [
	            'to' => $key_value,
	            'message' => "Use " . $OTP . " to verify your phone number. This code can be used only once and is valid for 15 mins."//'Hi ' .  . ', ' . $OTP . ' is your OTP for Phone verification. Do not share OTP for security reasons.'
	        ];

	        $sms["priority"] = "high";
        	sendSms('verification', $sms);
    	}
        
        if(in_develop()) { // Store OTP in Cookie, if in DEV mode
        	error_log('in develop set cookie');
        	$cookie_cont_obj = new CookieController;
        	$other_cookie_params = ["path" => "/", "domain" => sizeof(explode('://', env('APP_URL'))) > 1 ? (explode('://', env('APP_URL'))[1]) : (explode('://', env('APP_URL'))[0]), "http_only" => true];
        	$cookie_cont_obj->set('mobile_otp', strVal($OTP), $other_cookie_params);
        }

        //return ['keyword' => $key, 'value' => $key_value, 'OTP' => $OTP];
        return $json;
	}

	/**
	* This function is used to Send Enquiry Emails
	*/
	public function sendEnquiryEmail($enquiry_type=’direct’, $is_premium=false, $email_details = [], $email_content=[], $send_seeker_email = true, $send_owner_email = true) {
		$data = [];
		$data['from'] = config('constants.email_from');
		$data['name'] = config('constants.email_from_name');
		$data['to'] = $email_details['to'];

		$data['cc'] = isset($email_details['cc']) ? $email_details['cc'] : [];
		$data['bcc'] = isset($email_details['bcc']) ? $email_details['bcc'] : [];
		$data['subject'] = 'Your enquiry has been sent successfully';
		
		$short_listing_url = urlShortner($email_content["listing_url"], true)["id"];
		$short_customer_dashboard_url = urlShortner($email_details['dashboard_url'], true)["id"];

		/* Email to Seeker / Enquired Person */
		if($send_seeker_email) { // Send Seeker, the mail only if the Flag is true
			if($is_premium) { // Send mail to the seeker with only that enquiry
				$data['template_data'] = ["name" => $email_details['name'], "customer_dashboard_url" => $short_customer_dashboard_url, "listing_url" => $short_listing_url, "listing_name" => $email_content['listing_name'], "listing_data" => $email_content['listing_data'], "is_premium" => true];
			}  else { // Send email to the seeker with other enquiries
				$data['template_data'] = ["name" => $email_details['name'], "customer_dashboard_url" => $short_customer_dashboard_url, "listing_url" => $short_listing_url, "listing_name" => $email_content['listing_name'], "listing_data" => $email_content['listing_data'], "cancel_other_enquiry_contacts" => "", "is_premium" => false];
			}
			$data['priority'] = 'default';
			sendEmail("seeker-email-enquiry", $data);

		}

		if($send_owner_email) {
			/* Email & SMS to Listing owners */
			$data['to'] = $email_content["listing_owner"]["email"];//$email_details['listing_to'];
			$sms['to'] = $email_content["listing_owner"]["mobile"];

			if($enquiry_type == 'direct') { // If listing enquiry type is DIRECT, then
				/* Send Email */
				// $data['to'] = $email_content["listing_owner"]["email"];//$email_details['listing_to'];
				$data['subject'] = 'You just received an enquiry for your listing';
				$data["template_data"] = ["name" => $email_content["listing_owner"]["name"], "listing_name" => $email_content["listing_name"], "listing_url" => $short_listing_url, "customer_name" => $email_details['name'], "customer_email" => $email_details['email'], "customer_contact" => $email_details['contact'], "customer_describes_best" => $email_details['describes_best'], "customer_message" => $email_details['message'], "customer_dashboard_url" => $short_customer_dashboard_url, "is_user" => (isset($email_details["seeker"]) && $email_details["seeker"] === "user") ? true : false];
				
				if(!$is_premium) { // If listing is not PREMIUM, then send an mail after 60 mins
					$data['delay'] = 60;
				}

				$data['priority'] = 'low';
				sendEmail('direct-listing-email', $data);//->delay(Carbon::now()->addHours(1));
				
				/* Send SMS */
				$sms ['message'] = "Hi " . $email_content["listing_owner"]["name"] . ",\nThere is an enquiry for " . $email_content["listing_name"] . " (" . $short_listing_url . ") on FnB Circle.\nDetails of the seeker:\nName: " . $email_details['name'] . "\nEmail:  " . $email_details['email'] . "\nPhone Number: " . $email_details['contact'] . "\n\nClick " . $short_customer_dashboard_url . " to view the enquiry.";

		        if(!$is_premium) { // If listing is not PREMIUM, then send an mail after 60 mins
					$sms['delay'] = 60;
				}

		        $sms["priority"] = "default";
	        	sendSms('verification', $sms);

			} else { // if listing enquiry is SHARED, then
				/* Send Email */
				// $data['to'] = $email_content["listing_owner"]["email"];//$email_details['listing_to'];
				$data['subject'] = 'Enquiry matching your listing on FnB Circle.';

				$data["template_data"] = ["name" => $email_content["listing_owner"]["name"], "listing_name" => $email_content["listing_name"], "listing_url" => $short_listing_url, "customer_name" => $email_details['name'], "customer_email" => $email_details['email'], "customer_contact" => $email_details['contact'], "customer_describes_best" => $email_details['describes_best'], "customer_message" => $email_details['message'], "customer_dashboard_url" => $short_customer_dashboard_url];

				$data['priority'] = 'low';
				sendEmail('shared-listing-email', $data);

				/* Send SMS */
				$sms['message'] = "Hi " . $email_content["listing_owner"]["name"] . ",\nWe have received an enquiry matching " . $email_content["listing_name"] . " ( " . $short_listing_url . " ) on FnB Circle,\nDetails of the seeker:\nName: " . $email_details['name'] . "\nEmail:  " . $email_details['email'] . "\nPhone Number: " . $email_details['contact'] . "\nClick " . $short_customer_dashboard_url . " to view the enquiry.";

		        $sms["priority"] = "default";
	        	sendSms('verification', $sms);
			}
		}
	}

	/**
	* This function is used to update Enquiry Table with the all the Enquiry details of the specific user
	*/
	public function secondaryEnquiryQueue($enquiry_data, $enquiry_sent, $listing_final_ids, $send_email=false) {
		// $output = new ConsoleOutput;
		
		foreach ($listing_final_ids as $op_key => $op_value) {
			$enquiry_sent["enquiry_to_id"] = $op_value;
			if(in_develop()) { // If in Dev mode
				if($op_key === 0) { // If 1st Enq
					$enq_objs = $this->createEnquiry($enquiry_data, $enquiry_sent, [], [], false, true);
				} else { // Else just save the Enq
					$enq_objs = $this->createEnquiry($enquiry_data, $enquiry_sent, [], [], false, false);
					
					if($send_email && $op_key === sizeof($listing_final_ids) - 1) { // Else if on Last Enq -> Send a Dump
						$listing_enq_obj = Listing::whereIn('id', $listing_final_ids);
						$owner_ids = array_unique($listing_enq_obj->distinct('owner_id')->get()->pluck('owner_id')->toArray());
						$email_ids = array_unique(UserCommunication::where([['object_type', 'App\User'], ['type', 'email']])->whereIn('object_id', $owner_ids)->get()->pluck('value')->toArray());

						$data['to'] = $email_ids;
						$data['cc'] = [];
						$data['subject'] = "Found " . strVal(sizeof($listing_final_ids)) . " listings matching the enquiry";

						$data["content"] = $listing_enq_obj->get()->pluck('title')->toArray();

						$data["data"] = $data;
						$data_content = ["to" => $data["to"], "cc" => $data["cc"], "subject" => $data["subject"], "template_data" => $data];

						sendEmail('dev-dump', $data_content);
					}
				}
			} else {
				$enq_objs = $this->createEnquiry($enquiry_data, $enquiry_sent, [], [], false, true);
			}
			
		}

		$enquiry_obj = Enquiry::find($enquiry_data["enquiry_id"]);
		if($enquiry_obj->user_object_type == "App\User") { // If logged In user
			$userauth_obj = new UserAuth;
			$customer_data = $userauth_obj->getUserData($enquiry_obj->user_object_id, true);
			$email_details = [
				"name" => $customer_data["user"]->name, 
				"email" => ($customer_data["user_comm"]->where('type', 'email')->where('is_primary', 1)->count() > 0) ? $customer_data["user_comm"]->where('type', 'email')->where('is_primary', 1)->first()->value : $customer_data["user_comm"]->where('type', 'email')->first()->value, 
				"contact" => ($customer_data["user_comm"]->where('type', 'mobile')->where('is_primary', 1)->count() > 0) ? '+' . $customer_data["user_comm"]->where('type', 'mobile')->where('is_primary', 1)->first()->country_code . $customer_data["user_comm"]->where('type', 'mobile')->where('is_primary', 1)->first()->value : '+' . $customer_data["user_comm"]->where('type', 'mobile')->first()->country_code . $customer_data["user_comm"]->where('type', 'mobile')->first()->value, 
				"describes_best" => unserialize($customer_data["user_details"]->first()->subtype), 
				"message" => $enquiry_obj->enquiry_message,
				"dashboard_url" => "",
				"seeker" => "user",
			];
			
			$email_details["dashboard_url"] = config('app')['url'] . "/profile/activity/" . $email_details['email'];

			$email_details["to"] = $email_details["email"];
			$email_details["listing_to"] = $email_details["email"];
		} else { // If Guest User
			$lead_obj = Lead::find($enquiry_obj->user_object_id);
			$email_details = [
				"name" => $lead_obj->name, 
				"email" => $lead_obj->email, 
				"contact" => '+' . implode(explode("-", $lead_obj->mobile)), 
				"describes_best" => unserialize($lead_obj->user_details_meta)["describes_best"], 
				"message" => $enquiry_obj->enquiry_message,
				"dashboard_url" => "",
				"to" => $lead_obj->email,
				"seeker" => "lead",
			];
			
			$email_details["dashboard_url"] = config('app')['url'] . "/profile/activity/" . $email_details['email'];
		}

		if($enquiry_obj->enquiry_to_type === "App\Listing") {
			$listing_obj = Listing::find($enquiry_obj->enquiry_to_id);
		} else {
			$listing_obj = NULL;
		}

		if($listing_obj)
			$email_content = ["listing_name" => $listing_obj->title, "listing_owner" => [], "listing_url" => $this->getListingUrl($listing_obj, false), "listing_data" => []];
		else
			$email_content = ["listing_name" => "", "listing_owner" => [], "listing_url" => "", "listing_data" => []];
		
		$enq_data_obj = Listing::whereIn('id', $listing_final_ids)->orderBy('premium', 'desc')->orderBy('updated_at', 'desc')->get()->each(function($list) use (&$email_content) {
			$listing_content = array("name" => $list["title"], "type" => "", "cores" => [], "operation_areas" => [], "ratings" => "", "link" => $this->getListingUrl($list["id"], true));
			$listing_content["type"] = ['name' => Listing::listing_business_type[$list["type"]], 'slug' => Listing::listing_business_type_slug[$list["type"]]];
			
			$areas_operation_id = ListingAreasOfOperation::where("listing_id", $list->id)->pluck('area_id')->toArray();
    		$city_areas = Area::whereIn('id', $areas_operation_id)->get(['id', 'name', 'slug', 'city_id'])->groupBy('city_id');

    		$areas_operation = [];
    		foreach ($city_areas as $city_id => $city_areas) { // Get City & areas that the Listing is under operation
    			array_push($areas_operation, 
    				array("city" => City::where("id", $city_id)->get(['id', 'name', 'slug'])->first()->toArray(),
    				"areas" => $city_areas->toArray()
    			));
    		}

    		$listing_content["operation_areas"] = $list["areas_operation"] = $areas_operation; // Array of cities & areas under that city
    		$listing_content["cores"] = $list["cores"] = Category::whereIn('id', ListingCategory::where([['listing_id', $list->id],['core',1]])->pluck('category_id')->toArray())->get(['id', 'name', 'slug', 'level', 'order'])->each(function($cat_obj) {
					$listViewCont_obj = new ListViewController;
                    $cat_obj["node_categories"] = $listViewCont_obj->getCategoryNodeArray($cat_obj, "slug", false);
            });

    		array_push($email_content["listing_data"], $listing_content);
		});

		// Send a shared Enquiry Email to the Customer / Seeker
		$this->sendEnquiryEmail('shared', false, $email_details, $email_content, true, false);
	}

	/**
	* This function is used to generate the Single Listing URL
	*/
	public function getListingUrl($listing_obj, $is_id=false) {
		if ($is_id) {
			$listing_obj = Listing::find($listing_obj);
		}

		// return env('APP_URL') . "/" . Area::find($listing_obj->locality_id)->city()->first()->slug . "/" . $listing_obj->slug;
		return config('app')['url'] . "/" . Area::find($listing_obj->locality_id)->city()->first()->slug . "/" . $listing_obj->slug;
	}

	/**
	* This function is used to create Enquiry data
	* This function will @return the following Enquiry objects
	*	Enquiry, EnquirySent, EnquiryCategory & EnquiryArea
	*/
	public function createEnquiry($enquiry_data=[], $enquiry_sent=[], $enquiry_categories=[], $enquiry_area=[], $send_seeker_email = false, $send_owner_mail = true) {

		if (sizeof($enquiry_data) > 0 && isset($enquiry_data["enquiry_id"]) && $enquiry_data["enquiry_id"] > 0) { // Get data if ID is passed
			$enquiry_obj = Enquiry::find($enquiry_data["enquiry_id"]);
		} else if(sizeof($enquiry_data) > 0) { // Create data if params are passed
			$enquiry_obj = Enquiry::create($enquiry_data);
			switch($enquiry_data['user_object_type']){
				case 'App\\User' : 
					$caused_by = User::find($enquiry_data['user_object_id']);
					break;
				case 'App\\Lead' : 
					$caused_by = Lead::find($enquiry_data['user_object_id']);
					break;
			}
			activity()
	           ->performedOn($enquiry_obj)
	           ->causedBy($caused_by)
	           ->log('enquiry-created');
		} else {
			$enquiry_obj = null;
		}

		if($enquiry_obj) { // If enquiry object exist, then add other data
			
			if(sizeof($enquiry_categories) > 0) {
				foreach ($enquiry_categories as $cat_key => $cat_value) {
					$category_obj = Category::where('id', $cat_value)->first();
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

			if (sizeof($enquiry_sent) > 0) {
				$enquiry_sent["enquiry_id"] = $enquiry_obj["id"];
				$enquiry_sent_obj = EnquirySent::create($enquiry_sent);

				$listing_obj = Listing::find($enquiry_sent["enquiry_to_id"]);
				
				if($listing_obj) {
					if($listing_obj->owner_id) { // If owner ID !== NULL
						$user_id = $listing_obj->owner_id;
					} else { // Else get Created_by's ID
						$user_id = $listing_obj->created_by;
					}
						
					$userauth_obj = new UserAuth;
					$owner_data = $userauth_obj->getUserData($user_id, true);

					$listing_owner = [
						"name" => $owner_data["user"]->name, 
						"email" => ($owner_data["user_comm"]->where('type', 'email')->where('is_primary', true)->count() > 0) ? $owner_data["user_comm"]->where('type', 'email')->where('is_primary', true)->first()->value : $owner_data["user_comm"]->where('type', 'email')->first()->value,
						"mobile" => ($owner_data["user_comm"]->where('type', 'mobile')->where('is_primary', true)->count() > 0) ? $owner_data["user_comm"]->where('type', 'mobile')->where('is_primary', true)->first()->value : ($owner_data["user_comm"]->where('type', 'mobile')->first() ? $owner_data["user_comm"]->where('type', 'mobile')->first()->value : null)
					];

					$listing_url = $this->getListingUrl($listing_obj, false);
					$email_content = ["listing_name" => $listing_obj->title, "listing_owner" => $listing_owner, "listing_url" => $listing_url, "listing_data" => []];

					if($listing_obj->premium && $enquiry_sent_obj->enquiry_type == "direct") { // If enquiry is of "Premium" listing & is Direct enquiry, then send that Mail to Customer regarding that Direct Enquiry
						$listing_content = array("name" => $listing_obj->title, "type" => "", "cores" => [], "operation_areas" => [], "ratings" => "", "link" => $this->getListingUrl($listing_obj, false));
						$listing_content["type"] = ['name' => Listing::listing_business_type[$listing_obj["type"]], 'slug' => Listing::listing_business_type_slug[$listing_obj["type"]]];

						$listing_content["cores"] = Category::whereIn('id', ListingCategory::where([['listing_id', $listing_obj->id],['core',1]])->pluck('category_id')->toArray())->get(['id', 'name', 'slug', 'level', 'order'])->each(function($cat_obj) {
								$listViewCont_obj = new ListViewController;
                        		$cat_obj["node_categories"] = $listViewCont_obj->getCategoryNodeArray($cat_obj, "slug", false);
                		})->toArray();

						$areas_operation_id = ListingAreasOfOperation::where("listing_id", $listing_obj->id)->pluck('area_id')->toArray();
			    		$city_areas = Area::whereIn('id', $areas_operation_id)->get(['id', 'name', 'slug', 'city_id'])->groupBy('city_id');

			    		$areas_operation = [];
			    		foreach ($city_areas as $city_id => $city_areas) { // Get City & areas that the Listing is under operation
			    			array_push($areas_operation, array("city" => City::where("id", $city_id)->get(['id', 'name', 'slug'])->first()->toArray(), "areas" => $city_areas->toArray()));
			    		}
			    		$listing_content["operation_areas"] = $areas_operation; // Array of cities & areas under that city
			    		array_push($email_content["listing_data"], $listing_content);

			    		$listing_ids = EnquirySent::where([['enquiry_to_type', 'App\Listing'], ['enquiry_to_id', $enquiry_obj->id]])->pluck('enquiry_to_id')->toArray();

			    		$enq_data_obj = Listing::whereIn('id', $listing_ids)->orderBy('premium', 'desc')->orderBy('updated_at', 'desc')->get()->each(function($list) use ($email_content) {
							$listing_content = array("name" => $list["name"], "type" => "", "cores" => [], "operation_areas" => [], "ratings" => "", "link" => $this->getListingUrl($list["id"], true));
							$listing_content["type"] = ['name' => Listing::listing_business_type[$list["type"]], 'slug' => Listing::listing_business_type_slug[$list["type"]]];
							
							$areas_operation_id = ListingAreasOfOperation::where("listing_id", $list->id)->pluck('area_id')->toArray();
				    		$city_areas = Area::whereIn('id', $areas_operation_id)->get(['id', 'name', 'slug', 'city_id'])->groupBy('city_id');

				    		$areas_operation = [];
				    		foreach ($city_areas as $city_id => $city_areas) { // Get City & areas that the Listing is under operation
				    			array_push($areas_operation, 
				    				array("city" => City::where("id", $city_id)->get(['id', 'name', 'slug'])->first()->toArray(),
				    				"areas" => $city_areas->toArray()
				    			));
				    		}

				    		$list["areas_operation"] = $areas_operation; // Array of cities & areas under that city
				    		$list["cores"] = Category::whereIn('id', ListingCategory::where([['listing_id', $list->id],['core',1]])->pluck('category_id')->toArray())->get(['id', 'name', 'slug', 'level', 'order'])->each(function($cat_obj) {
									$listViewCont_obj = new ListViewController;
			                        $cat_obj["node_categories"] = $listViewCont_obj->getCategoryNodeArray($cat_obj, "slug", false);
			                });

				    		// array_push($email_content["listing_data"], $listing_content);
						});

					} else {
						$listing_ids = EnquirySent::where([['enquiry_to_type', 'App\Listing'], ['enquiry_to_id', $enquiry_obj->id]])->pluck('enquiry_to_id')->toArray();

						$enq_data_obj = Listing::whereIn('id', $listing_ids)->orderBy('premium', 'desc')->orderBy('updated_at', 'desc')->get()->each(function($list) use ($email_content) {
							$listing_content = array("name" => $list["name"], "type" => "", "cores" => [], "operation_areas" => [], "ratings" => "", "link" => $this->getListingUrl($list["id"], true));
							$listing_content["type"] = ['name' => Listing::listing_business_type[$list["type"]], 'slug' => Listing::listing_business_type_slug[$list["type"]]];
							
							$areas_operation_id = ListingAreasOfOperation::where("listing_id", $list->id)->pluck('area_id')->toArray();
				    		$city_areas = Area::whereIn('id', $areas_operation_id)->get(['id', 'name', 'slug', 'city_id'])->groupBy('city_id');

				    		$areas_operation = [];
				    		foreach ($city_areas as $city_id => $city_areas) { // Get City & areas that the Listing is under operation
				    			array_push($areas_operation, 
				    				array("city" => City::where("id", $city_id)->get(['id', 'name', 'slug'])->first()->toArray(),
				    				"areas" => $city_areas->toArray()
				    			));
				    		}

				    		$list["areas_operation"] = $areas_operation; // Array of cities & areas under that city
				    		$list["cores"] = Category::whereIn('id', ListingCategory::where([['listing_id', $list->id],['core',1]])->pluck('category_id')->toArray())->get(['id', 'name', 'slug', 'level', 'order'])->each(function($cat_obj) {
									$listViewCont_obj = new ListViewController;
			                        $cat_obj["node_categories"] = $listViewCont_obj->getCategoryNodeArray($cat_obj, "slug", false);
			                });

				    		array_push($email_content["listing_data"], $listing_content);
						});
					}

					// $customer_dashboard_url = config('app')['url'] + "/profile/activity/";
					/* Get User / Customer (the guy who did enquiry) Details */
					if($enquiry_obj->user_object_type == "App\User") { // If logged In user
						$customer_data = $userauth_obj->getUserData($enquiry_obj->user_object_id, true);
						$email_details = [
							"name" => $customer_data["user"]->name, 
							"email" => ($customer_data["user_comm"]->where('type', 'email')->where('is_primary', 1)->count() > 0) ? $customer_data["user_comm"]->where('type', 'email')->where('is_primary', 1)->first()->value : $customer_data["user_comm"]->where('type', 'email')->first()->value, 
							"contact" => ($customer_data["user_comm"]->where('type', 'mobile')->where('is_primary', 1)->count() > 0) ? '+' . $customer_data["user_comm"]->where('type', 'mobile')->where('is_primary', 1)->first()->country_code . $customer_data["user_comm"]->where('type', 'mobile')->where('is_primary', 1)->first()->value : '+' . $customer_data["user_comm"]->where('type', 'mobile')->first()->country_code . $customer_data["user_comm"]->where('type', 'mobile')->first()->value, 
							"describes_best" => unserialize($customer_data["user_details"]->first()->subtype), 
							"message" => $enquiry_obj->enquiry_message,
							"dashboard_url" => "",
							"seeker" => "user",
						];
						
						$email_details["dashboard_url"] = config('app')['url'] . "/profile/activity/" . $email_details['email'];

						$email_details["to"] = $email_details["email"];
						$email_details["listing_to"] = $email_details["email"];
					} else { // If Guest User
						$lead_obj = Lead::find($enquiry_obj->user_object_id);
						$email_details = [
							"name" => $lead_obj->name, 
							"email" => $lead_obj->email, 
							"contact" => '+' . implode(explode("-", $lead_obj->mobile)), 
							"describes_best" => unserialize($lead_obj->user_details_meta)["describes_best"], 
							"message" => $enquiry_obj->enquiry_message,
							"dashboard_url" => "",
							"to" => $lead_obj->email,
							"seeker" => "lead",
						];
						
						$email_details["dashboard_url"] = config('app')['url'] . "/profile/activity/" . $email_details['email'];
					}

					if(!in_develop() || (in_develop() && $send_owner_mail)) { // If Prod Mode, then send Email else if in Dev MOde && The Send owner flag is true, then send the Email
						//if($listing_obj->premium && $enquiry_sent["enquiry_type"] == "direct") { // If Premium & Direct, then send a mail to the Seeker saying that specific Enquiry is sent
						/** Note: Direct Enquiry Mail is only sent for Premium, for Non-Premium the Email is merged with the 'Shared' Enquiry **/
						if($listing_obj->premium && $enquiry_sent["enquiry_type"] == "direct") { // If Direct & Premium, then send a mail to the Seeker saying that specific Enquiry is sent
							$this->sendEnquiryEmail($enquiry_sent['enquiry_type'], $listing_obj->premium, $email_details, $email_content, true);
						} else {
							$this->sendEnquiryEmail($enquiry_sent['enquiry_type'], $listing_obj->premium, $email_details, $email_content, $send_seeker_email);
						}
					}
				}

			} else {
				$enquiry_sent_obj = [];
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
   public function getEnquiryTemplate($template_type, $listing_slug="", $session_id = "", $multi_quote = false) {
   		$response_html = ''; $template_name = '';
   		$listing_view_controller = new ListingViewController;
   		// $output = new ConsoleOutput;
		
		$session_data = Session::get('enquiry_data');
		
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

   			if($listing->count() > 0) { // If listing count is > 0, then
   				$listing = $listing->first();
	   			$data = $listing_view_controller->getListingData($listing); // Get the data for the Enquiry Modal template

		   		if($template_config[$template_type] == 'popup_level_one' && strlen($session_id) > 0) { // Profile Enquiry Template
		   			$payload_data = Session::get('enquiry_data', []);

	   				if(sizeof($payload_data)) { // If "enquiry_data" is present in the Session's payload
	   					$enquiry_data = $payload_data;
	   					$response_html = View::make('modals.listing_enquiry_popup.popup_level_one')->with(compact('enquiry_data', 'data'))->render();
	   				} else {
	   					$response_html = View::make('modals.listing_enquiry_popup.popup_level_one')->with(compact('data'))->render();
	   				}
		   		} else if ($template_config[$template_type] == 'popup_level_two' && strlen($session_id) > 0) { // OTP template
		   			$next_template_type = "step_" . strVal(intVal(explode('step_', $template_type)[1]) + 1);

	   				$payload_data["enquiry_data"] = Session::get('enquiry_data', []); //unserialize(base64_decode($session_data));
	   				if(isset($payload_data["enquiry_data"]["contact"])) {
	   					$data['next_page'] = $next_template_type;
	   					$data['current_page'] = $template_type;
		   				$this->generateContactOtp('+' . $payload_data["enquiry_data"]["contact_code"] . $payload_data["enquiry_data"]["contact"], "contact",$payload_data["enquiry_data"]["contact_code"], $payload_data["enquiry_data"]["contact"]); // Generate OTP
		   				
		   				$data["contact_code"] = $payload_data["enquiry_data"]["contact_code"];
		   				$data["contact"] = $payload_data["enquiry_data"]["contact"];
			   			$response_html = View::make('modals.listing_enquiry_popup.popup_level_two')->with(compact('data'))->render();
			   		}
		   		} else if ($template_config[$template_type] == 'popup_level_three' && strlen($session_id) > 0) { // Extra Enquiry (Area + Category) Template
		   			$payload_data["enquiry_data"] = Session::get('enquiry_data', []);
		   			
		   			$data['current_page'] = $template_type;

		   			if(isset($payload_data["enquiry_data"]["contact"])) {
		   				$enquiry_data = $payload_data["enquiry_data"];
		   				$parents  = Category::where('type', 'listing')->whereNull('parent_id')->where('status', '1')->orderBy('order')->orderBy('name')->get();
            			$categories = ListingCategory::getCategories($listing->id);
		   				$response_html = View::make('modals.listing_enquiry_popup.popup_level_three')->with(compact('data', 'enquiry_data', 'parents', 'categories'))->render();
			   		}

		   		} else {
		   			if(isset($session_data["enquiry_id"])) {
		   				$enq_obj = Enquiry::find($session_data["enquiry_id"]);
		   				$area_ids = $enq_obj->areas()->pluck('area_id')->toArray();
		   				$core_ids = $enq_obj->categories()->pluck('category_id')->toArray();

		   				$listing_operations_ids = ListingAreasOfOperation::whereIn('area_id', $area_ids)->distinct('listing_id')->pluck('listing_id')->toArray();
						$listing_cat_ids = ListingCategory::whereIn('category_id', $core_ids)->distinct('listing_id')->pluck('listing_id')->toArray();

						/*if(sizeof($listing_operations_ids) > 0 && sizeof($listing_cat_ids) > 0) { // If both have value > 0, then
							$listing_final_ids = array_intersect($listing_operations_ids, $listing_cat_ids); // INTERSECTION of 2 Arrays
							if(sizeof($listing_final_ids) < 5) { // If size is < 5, then do UNION of 2 arrays
								$listing_final_ids = $listing_operations_ids;// array_unique(array_merge($listing_operations_ids, $listing_cat_ids)); // Get unique IDs of the Arrays
							}
						} else if (sizeof($listing_operations_ids) > 0 || sizeof($listing_cat_ids) > 0) { // If either 1 array is not Empty, then
							$listing_final_ids = $listing_operations_ids;// array_unique(array_merge($listing_operations_ids, $listing_cat_ids));
						} else {
							$listing_final_ids = [];
						}*/
						if(sizeof($listing_operations_ids) > 0 && sizeof($listing_cat_ids) > 0) { // If both have value > 0, then
							$listing_final_ids = array_intersect($listing_operations_ids, $listing_cat_ids); // INTERSECTION of 2 Arrays
						} else {
							$listing_final_ids = [];
						}

						if(isset($listing) && $listing->id > 0) {
							// Remove the Primary Enquiry's Listing ID if the Listing ID exist in the Array
							$pos = array_search($listing->id, $listing_final_ids);
							unset($listing_final_ids[$pos]);
						}

						if(Auth::user()) { // If User is logged In, check if s/he owns a listing, then exclude the listings from recommended Listings
							$user_id = Auth::user()->id;
							$owned_listing_ids = Listing::where('status', 1)->where(function ($query) use ($user_id) {
								return $query->where('owner_id', $user_id)->orWhere('created_by', $user_id); 
							})->pluck('id')->toArray();
							$listing_final_ids = array_diff($listing_final_ids, $owned_listing_ids); // exclude the owner's listings from the filtered Listings => (A = A - B)
						}

						if (sizeof($listing_final_ids) > 0)  {
							$temp_listing_ids = Listing::whereIn('id', $listing_final_ids)->where([['premium', 1], ['status', 1]])->pluck('id')->toArray();

							if(sizeof($temp_listing_ids) > 0) { // If premium account exist then
								$listing_final_ids = $temp_listing_ids;
							} else {
								$listing_final_ids = Listing::whereIn('id', $listing_final_ids)->where('status', 1)->pluck('id')->toArray(); // Filter out & get all listings of status 'published'
							}
						}

						$listviewObj = new ListViewController;
						$area_slugs = Area::whereIn('id', $area_ids)->pluck('slug')->toArray();
						$cat_slugs = Category::whereIn('id', $core_ids)->pluck('slug')->toArray();
						
						if(sizeof($listing_final_ids) > 0) {
							$filters = ["listing_ids" => $listing_final_ids];
						} else {
							$filters = ["categories" => $cat_slugs, "areas" => $area_slugs, "listing_ids" => $listing_final_ids];
						}

						$listing_data = $listviewObj->getListingSummaryData("", $filters, 1, 3, "updated_at", "desc")["data"];//Listing::whereIn('id', $listing_final_ids)->orderBy('premium', 'desc')->orderBy('updated_at', 'desc')->get();
						$listing_count = sizeof($listing_final_ids);
		   			} else {
		   				$listing_data = [];
		   				$listing_count = 0;
		   			}


		   			$is_premium = $listing->premium;
		   			$response_html = View::make('modals.listing_enquiry_popup.enquiry_success_message')->with(compact('listing_data', 'is_premium', 'listing_count'))->render();
		   		}
		   	} else { // Listing_Slug not found
		   		$response_html = abort(404);
		   	}
	   	} else if ($multi_quote) { // else if it is a MULTI quote enquiry, then
	   		$template_name = "multi_quote";

	   		/*if(Auth::guest()) { // If user is not Logged In
    			$template_name .= "_not_logged_in";
    		} else { // If user is Logged In
    			$template_name .= "_logged_in";
    		}*/
	    	$template_name .= "_not_logged_in";

	    	$template_config = config('enquiry_flow_config')[$template_name];

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
   				if(!Auth::guest()) { // If logged In User
					$auth_user_contact = Auth::user()->getPrimaryContact();
					if($auth_user_contact && isset($auth_user_contact["is_verified"]) && !$auth_user_contact["is_verified"]) { // If the Primary Contact No is not Verified
						$this->generateContactOtp('+' . $payload_data["enquiry_data"]["contact_code"] . $payload_data["enquiry_data"]["contact"], "contact",$payload_data["enquiry_data"]["contact_code"] , $payload_data["enquiry_data"]["contact"]); // Generate OTP
					}
				} else if(isset($payload_data["enquiry_data"]["contact"])) { // Else If the Enquiry Contact No is not Verified
	   				$this->generateContactOtp('+' . $payload_data["enquiry_data"]["contact_code"] . $payload_data["enquiry_data"]["contact"], "contact",$payload_data["enquiry_data"]["contact_code"] , $payload_data["enquiry_data"]["contact"]); // Generate OTP
		   		}
				
				$data['next_page'] = $next_template_type;
				$data['current_page'] = $template_type;	
   				$data["contact_code"] = $payload_data["enquiry_data"]["contact_code"];
   				$data["contact"] = $payload_data["enquiry_data"]["contact"];
	   			$response_html = View::make('modals.listing_enquiry_popup.popup_level_two')->with(compact('data'))->render();
	   		} else if ($template_config[$template_type] == 'popup_level_three' && strlen($session_id) > 0) {
	   			$payload_data["enquiry_data"] = Session::get('enquiry_data', []);
	   			
	   			$data['current_page'] = $template_type;

	   			$list_view_data = Session::get('list_view', []);
	   			if(sizeof($list_view_data) > 0) {
	   				if(isset($list_view_data["categories"]) && sizeof($list_view_data["categories"]) > 0) {
	   					$data["cores"] = Category::whereIn('slug', $list_view_data["categories"])->get();
	   				}

		   			if(isset($list_view_data["areas"]) && sizeof($list_view_data["areas"]) > 0) {
	   					$areas_selected = Area::whereIn('slug', $list_view_data["areas"])->get();
			    		$data["area_ids"] = $areas_selected->pluck('id')->toArray();
			    		$areas_selected = $areas_selected->groupBy('city_id');
	   					foreach ($areas_selected as $city_id => $city_areas) { // Get City & areas that the Listing is under operation
			    			$data = array_merge($data, array("city" => City::where("id", $city_id)->get(['id', 'name', 'slug'])->first()->toArray(), "areas" => $city_areas->toArray()));
			    		}

	   				} else if (isset($list_view_data["cities"]) && sizeof($list_view_data["cities"]) > 0) {
	   					$cities_selected = City::whereIn('slug', $list_view_data["cities"])->get();
			    		$data["city_ids"] = $cities_selected = $cities_selected->pluck('id')->toArray();
			    		
			    		foreach ($cities_selected as $index => $city_id) { // Get City & areas that the Listing is under operation
			    			$data = array_merge($data, array("city" => City::where("id", $city_id)->get(['id', 'name', 'slug'])->first()->toArray(), "areas" => []));
			    		}
	   				}
	   			}
	   			Session::forget('list_view');

	   			if(isset($payload_data["enquiry_data"]["contact"])) {
	   				$enquiry_data = $payload_data["enquiry_data"];
	   				$parents  = Category::where('type', 'listing')->whereNull('parent_id')->where('status', '1')->orderBy('order')->orderBy('name')->get();
	   				if(isset($listing)) {
        				$categories = ListingCategory::getCategories($listing->id);
	   				} else {
	   					$categories = [];
	   				}
	   				$data["premium"] = false;
	   				$response_html = View::make('modals.listing_enquiry_popup.popup_level_three')->with(compact('data', 'enquiry_data', 'parents', 'categories'))->render();
		   		}

	   		} else {

	   			if(isset($session_data["enquiry_id"])) {
	   				// $enq_obj = Enquiry::find($session_data["enquiry_id"]);
	   				$area_ids = EnquiryArea::where('enquiry_id', $session_data["enquiry_id"])->pluck('area_id')->toArray();// $enq_obj->areas()->pluck('area_id')->toArray();
	   				$core_ids = EnquiryCategory::where('enquiry_id', $session_data["enquiry_id"])->pluck('category_id')->toArray(); // $enq_obj->categories()->pluck('category_id')->toArray();


	   				$listing_operations_ids = ListingAreasOfOperation::whereIn('area_id', $area_ids)->distinct('listing_id')->pluck('listing_id')->toArray();
					$listing_cat_ids = ListingCategory::whereIn('category_id', $core_ids)->distinct('listing_id')->pluck('listing_id')->toArray();

					/*if(sizeof($listing_operations_ids) > 0 && sizeof($listing_cat_ids) > 0) { // If both have value > 0, then
						$listing_final_ids = array_intersect($listing_operations_ids, $listing_cat_ids); // INTERSECTION of 2 Arrays
						if(sizeof($listing_final_ids) < 5) { // If size is < 5, then do UNION of 2 arrays
							$listing_final_ids = $listing_operations_ids;// array_unique(array_merge($listing_operations_ids, $listing_cat_ids)); // Get unique IDs of the Arrays
						}
					} else if (sizeof($listing_operations_ids) > 0 || sizeof($listing_cat_ids) > 0) { // If either 1 array is not Empty, then
						$listing_final_ids = $listing_operations_ids; // array_unique(array_merge($listing_operations_ids, $listing_cat_ids));
					} else {
						$listing_final_ids = [];
					}*/


					if(sizeof($listing_operations_ids) > 0 && sizeof($listing_cat_ids) > 0) { // If both have value > 0, then
						$listing_final_ids = array_intersect($listing_operations_ids, $listing_cat_ids); // INTERSECTION of 2 Arrays => (A = A . B)
					} else {
						$listing_final_ids = [];
					}


					if(isset($listing_slug) && strlen($listing_slug) > 0) {
						// Remove the Primary Enquiry's Listing ID if the Listing ID exist in the Array
						$listing = Listing::where('slug',$listing_slug)->get();
						$pos = array_search($listing->id, $listing_final_ids);
						unset($listing_final_ids[$pos]);
					}


					if(Auth::user()) { // If User is logged In, check if s/he owns a listing, then exclude the listings from recommended Listings
						$user_id = Auth::user()->id;
						$owned_listing_ids = Listing::where('status', 1)->where(function ($query) use ($user_id) {
							return $query->where('owner_id', $user_id)->orWhere('created_by', $user_id); 
						})->pluck('id')->toArray();
						$listing_final_ids = array_diff($listing_final_ids, $owned_listing_ids); // exclude the owner's listings from the filtered Listings => (A = A - B)
					}


					if (sizeof($listing_final_ids) > 0)  {
						$temp_listing_ids = Listing::whereIn('id', $listing_final_ids)->where([['premium', 1], ['status', 1]])->pluck('id')->toArray();

						if(sizeof($temp_listing_ids) > 0) { // If premium account exist then
							$listing_final_ids = $temp_listing_ids;
						} else {
							$listing_final_ids = Listing::whereIn('id', $listing_final_ids)->where('status', 1)->pluck('id')->toArray();
						}
					}

					$listviewObj = new ListViewController;
					$area_slugs = Area::whereIn('id', $area_ids)->pluck('slug')->toArray();
					$cat_slugs = Category::whereIn('id', $core_ids)->pluck('slug')->toArray();
					if(sizeof($listing_final_ids) > 0) {
						$filters = ["listing_ids" => $listing_final_ids];
					} else {
						$filters = ["categories" => $cat_slugs, "areas" => $area_slugs, "listing_ids" => $listing_final_ids];
					}

					$listing_data = $listviewObj->getListingSummaryData("", $filters, 1, 3, "updated_at", "desc")["data"];//->where('premium', true);//Listing::whereIn('id', $listing_final_ids)->orderBy('premium', 'desc')->orderBy('updated_at', 'desc')->get();
					$listing_count = sizeof($listing_final_ids);

	   			} else {
	   				$listing_data = [];
	   				$listing_count = 0;
	   			}
	   			
	   			$is_premium = false;
	   			
	   			$response_html = View::make('modals.listing_enquiry_popup.enquiry_success_message')->with(compact('listing_data', 'is_premium', 'listing_count'))->render();
	   			
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
		} else if ($request->has('multi-quote') && $request["multi-quote"]) {
			$modal_template = $this->getEnquiryTemplate($request->enquiry_level, $request->listing_slug, $session_id, true);
		} else {
			$modal_template = $this->getEnquiryTemplate($request->enquiry_level, $request->listing_slug, $session_id);
		}

		return response()->json(["modal_template" => $modal_template], 200);
	}

	/**
	* This function is called by the AJAX to add new Listing Enquiries 
	*/
	public function getEnquiry(Request $request) {
		// $output = new ConsoleOutput;
		$status = 500; $template_name = '';$modal_template_html = '';
		$listing_obj_type = "App\Listing"; $listing_obj_id = 0; $listing_obj = null;
		$full_screen_display = false;
		$cookie_cont_obj = new CookieController;
		$signup_popup = false;
		
		$session_id = Cookie::get('laravel_session');

		$template_type = $request->has('enquiry_level') && strlen($request->enquiry_level) > 0 ? $request->enquiry_level : 'step_1';

		if(Auth::guest() && $request->has('email') && $request->email) {
			$userauth_obj = new UserAuth;
			$user_obj = $userauth_obj->checkIfUserExists(["email" => $request->email], false);
			if($user_obj) {
				$cookie_cont_obj->set('user_type', "user", ['http_only' => false], false);
				$cookie_cont_obj->set('user_id', $user_obj->id, ['http_only' => false], false);
				$signup_popup = true;
				$status = 403; // Forbidden

				if($request->has('name')) { // If user exist, then in order to prepopulate, save the user's data in the Session
					$payload_data["enquiry_data"]['name'] = $request->name;
					$payload_data["enquiry_data"]['email'] = $request->email;
					$payload_data["enquiry_data"]["contact_code"] = (($request->has('contact_locality')) ? $request->contact_locality : "");
					$payload_data["enquiry_data"]["contact"] = ($request->has('contact')) ? $request->contact : "";
					$payload_data["enquiry_data"]["describes_best"] = ($request->has('description')) ? $request->description : "";
					$payload_data["enquiry_data"]["enquiry_message"] = ($request->has('enquiry_message')) ? $request->enquiry_message : "";

					Session::put('enquiry_data', $payload_data["enquiry_data"]); // Update the session with New User details
				}
			}
		}
		
		if(!$signup_popup) { // if signup_popup == false
			if($request->has('listing_slug') && strlen($request->listing_slug) > 0) { // If listing_slug is passed, then it is a specific Enquiry
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
			} else if($request->has('multi-quote') && $request["multi-quote"]) { // Else If a 'multi-quote' flag is passed, then
				$template_name = "multi_quote";

		   		/*if(Auth::guest()) { // If user is not Logged In
	    			$template_name .= "_not_logged_in";
	    		} else { // If user is Logged In
	    			$template_name .= "_logged_in";
	    		}*/
				$template_name .= "_not_logged_in";
		    	
		    	$template_config = config('enquiry_flow_config')[$template_name][$template_type];
		    	$listing_obj = null;//Listing::where('slug', '')->get();

		    	$listing_cities = $request->has('cities') && $request->cities ? ((gettype($request->cities) == "array") ? $request->cities : [$request->cities]) : [];
		    	$listing_areas = $request->has('areas') && $request->areas ? $request->areas : [];
	    		$listing_categories = [];
		    	if($request->has('category') && $request->category) {
		    		$cat_obj = Category::where('slug', $request->category)->first();
		    		
		    		if($cat_obj->level > 1) {
		    			$listViewCont_obj = new ListViewController;
		    			$listing_categories = $listViewCont_obj->getCategoryNodeArray($cat_obj, "slug", false);
		    			$listing_categories = json_decode(explode("|", $listing_categories)[1]);
		    		}
		    	}

		    	if($listing_cities || $listing_areas || $listing_categories) {
		    		Session::put('list_view', ["cities" => $listing_cities, "areas" => $listing_areas, "categories" => $listing_categories]);
		    	}
			} else { // Else
				$template_config = "popup_level_one";
				$listing_obj = Listing::where('slug', '')->get();
			}

			$verified_session = Session::get('otp_verified', []); // Check if OTP_Verified flag exist, & if so, don't ask the Client to enter OTP till session expires

			// If the OTP_verified contact & the current Enquiry contact is not the same, then mark as "OTP_NOT_VERIFIED"
			if($verified_session && isset($verified_session["contact"]) && $request->contact && strpos($verified_session["contact"], strval($request->contact)) === false) {//$verified_session["contact"] !== strval($request->contact)) {
				$verified_session = [];
			}

			if ($template_config == 'popup_level_one' && strlen($session_id) > 0) {// && $listing_obj->count() == 0) {
				$session_obj = DB::table('sessions')->where('id', $session_id);
				if($request->has('email') && $request->email && $request->has('contact') && $request->contact && $request->has('name') && $request->name) {	
					$payload_data["enquiry_data"] = Session::get('enquiry_data', []); // Collect the old 'enquiry_data' from the 'Session' if exist, else empty ARRAY

					if(!Auth::guest()) {
						$lead_obj = Auth::user();
						$lead_type = "App\User";
					} else {
						if($request->has('email') && $request->has('contact')) {
							$lead_obj = Lead::where([['email', $request->email], ['mobile', $request->contact_locality . '-' . $request->contact]])->get();
							$lead_type = "App\Lead";
							if($lead_obj->count() > 0) { // Lead found
								$lead_obj = $lead_obj->first();
								$changes_made = false;

								if($lead_obj->name !== $request->name) {
									$lead_obj->name = $request->name;
									$changes_made = true;
								}

								if($request->has('description') && $lead_obj->user_details_meta !== serialize(["describes_best" => $request->description])) {
									$lead_obj->user_details_meta = serialize(["describes_best" => $request->description]);
									$changes_made = true;
								}

								if($changes_made) {
									$lead_obj->save();
								}
							} else { // Lead doesn't exist
								$lead_obj = null;
								// $verified_session = [];
								// Session::forget('otp_verified');
								
								if(isset($verified_session["mobile"]) && $verified_session["mobile"]) { // If Mobile no was verified, but email id has changed, then create new Lead
									$lead_type = "App\Lead";
									
									$lead_obj = Lead::create(["name" => $request->name, "email" => $request->email, "mobile" => (($request->has('contact_locality')) ? $request->contact_locality : "") . '-' . (($request->has('contact')) ? $request->contact : ""), "user_details_meta" => serialize(["describes_best" => (($request->has('description')) ? $request->description : "")]), "is_verified" => true, "lead_creation_date" => date("Y-m-d H:i:s")]);
								} else {
									$lead_type = null;
									$lead_obj = null;
								}
							}
						} else {
							$lead_obj = null;
							$lead_type = null;
							$verified_session = [];
							// Session::forget('otp_verified');
						}
					}

					if (isset($lead_obj) && $lead_obj) { // Update the Session with User Object Data
						$payload_data["enquiry_data"]["user_object_id"] = $lead_obj["id"];
						if($lead_type)
							$payload_data["enquiry_data"]["user_object_type"] = $lead_type;
					}

					if($session_obj->count() > 0) { // If the session exist, then
						if($request->has('name') && $request->has('email')) {
							$payload_data["enquiry_data"]['name'] = $request->name;
							$payload_data["enquiry_data"]['email'] = $request->email;
							$payload_data["enquiry_data"]["contact_code"] = (($request->has('contact_locality')) ? $request->contact_locality : "");
							$payload_data["enquiry_data"]["contact"] = ($request->has('contact')) ? $request->contact : "";
							$payload_data["enquiry_data"]["describes_best"] = ($request->has('description')) ? $request->description : "";
							$payload_data["enquiry_data"]["enquiry_message"] = ($request->has('enquiry_message')) ? $request->enquiry_message : "";
							
							if(isset($listing_obj_id)) { // Assign the New Listing ID & Listing Type
								$payload_data["enquiry_data"]["enquiry_to_id"] = $listing_obj_id;
								$payload_data["enquiry_data"]["enquiry_to_type"] = $listing_obj_type;
							}

							if(!($cookie_cont_obj->get('user_id') && $cookie_cont_obj->get('user_type'))) { // Set Cookie if it doesn't exist
								$cookie_cont_obj->generateDefaults();
							}

							if(!Auth::guest()) { // If logged In User
								$auth_user_contact = Auth::user()->getPrimaryContact();
								if($auth_user_contact && isset($auth_user_contact["is_verified"]) && $auth_user_contact["is_verified"]) { // If the Primary Contact No is not Verified
									$verified_session = $this->setOtpVerified(true, '+' . $payload_data["enquiry_data"]["contact_code"] . $payload_data["enquiry_data"]["contact"]);
								}
							}


							if(isset($payload_data["enquiry_data"]["user_object_id"]) && isset($verified_session["mobile"]) && $verified_session["mobile"]) { // IF user ID exist & Mobile is verified, then save the data in the Enquiry & ENquirySent Table
								$enquiry_data = ["user_object_id" => isset($payload_data["enquiry_data"]["user_object_id"]) ? $payload_data["enquiry_data"]["user_object_id"] : null, "user_object_type" => isset($payload_data["enquiry_data"]["user_object_type"]) ? $payload_data["enquiry_data"]["user_object_type"] : "App\Lead", "enquiry_device" => $this->isMobile() ? "mobile" : "desktop", "enquiry_to_id" => isset($payload_data["enquiry_data"]["enquiry_to_id"]) ? $payload_data["enquiry_data"]["enquiry_to_id"] : null, "enquiry_to_type" => isset($payload_data["enquiry_data"]["enquiry_to_type"]) ? $payload_data["enquiry_data"]["enquiry_to_type"] : "App\Listing", "enquiry_message" => $payload_data["enquiry_data"]["enquiry_message"]];

								if($listing_obj && $listing_obj->count() > 0 && $payload_data["enquiry_data"]["enquiry_to_id"]) {
									$enquiry_sent = ["enquiry_type" => "direct", "enquiry_to_id" => $payload_data["enquiry_data"]["enquiry_to_id"], "enquiry_to_type" => $payload_data["enquiry_data"]["enquiry_to_type"]];
								} else {
									$enquiry_sent = [];
								}

		    					$create_enq_response = $this->createEnquiry($enquiry_data, $enquiry_sent, [], []);
		    					$payload_data["enquiry_data"]["enquiry_id"] = $create_enq_response["enquiry"]->id;
		    				}

		    				if(isset($create_enq_response) && isset($create_enq_response["enquiry"])) {
		    				}

		    				Session::put('enquiry_data', $payload_data["enquiry_data"]); // Update the session with New User details

		    				/* DOM fetching Section */
		    				if($listing_obj && $listing_obj->count() > 0) { // If in single listing page
		    					if($listing_obj->first()->premium && isset($verified_session["mobile"]) && $verified_session["mobile"]) { // Premium & verified
									$modal_template_html = $this->getEnquiryTemplate("step_3", $listing_obj->first()->slug, $session_id, false);	
								} else { // Else take me to next page
									$next_template_type = "step_" . strVal(intVal(explode('step_', $template_type)[1]) + 1);
									$modal_template_html = $this->getEnquiryTemplate($next_template_type, $listing_obj->first()->slug, $session_id, false);
								}
		    				} else { // If listing_slug is not passed & is "multi_quote" form
		    					$modal_template_html = $this->getEnquiryTemplate("step_2", "", $session_id, true);
		    				}
		    				$status = 200;
		    			} else {
							$status = 400;
						}
					} else {
						$status = 404;
					}
				} else { // Email ID & other Personal details are not passed/filled
					if($session_obj->count() > 0) { // If session is passed / exist, then
						if($listing_obj && $listing_obj->count() > 0) { // If listing Slug is passed, then it's Single Quote Enquiry
							$modal_template_html = $this->getEnquiryTemplate("step_1", $listing_obj->first()->slug, $session_id, false);
						} else { // Else it's a Multi Quote Enquiry
							$modal_template_html = $this->getEnquiryTemplate("step_1", "", $session_id, true);
						}
						$status = 200;
					} else { 
						if($listing_obj && $listing_obj->count() > 0) { // If listing Slug is passed, then it's Single Quote Enquiry
							$modal_template_html = $this->getEnquiryTemplate("step_1", $listing_obj->first()->slug, "", false);
						} else { // Else it's a Multi Quote Enquiry
							$modal_template_html = $this->getEnquiryTemplate("step_1", "", "", true);
						}
						$status = 200;
					}
				}

				Session::forget('second_enquiry_data'); // Forget the 2nd enquiry after submit
			} else if($template_config == "popup_level_three") {
				$session_payload = Session::get('enquiry_data', []);


				if(!Auth::guest()) {
					$lead_obj = Auth::user();
					$lead_type = "App\User";
				} else if(isset($verified_session["mobile"]) && $verified_session["mobile"]) {
					$lead_obj = ["id" => $session_payload["user_object_id"]];
					$lead_type = $session_payload["user_object_type"];
				} else {
					$lead_obj = Lead::where([['email', $request->email], ['mobile', $request->contact_locality . '-' . $request->contact]])->get();
					$lead_type = "App\Lead";
					if($lead_obj->count() > 0) {
						$lead_obj = $lead_obj->first();
					} else {
						$lead_obj = null;
					}
				}


				$create_enq_response = null;

				/*if(!Auth::guest()) { // If logged In user, then Save the Primary Enquiry Data
					if(isset($session_payload['enquiry_id'])) { // if enquiry_id exist,
						$enq_sent_obj = EnquirySent::where([['enquiry_id', $session_payload['enquiry_id']], ['enquiry_to_id', $session_payload["enquiry_to_id"]], ['enquiry_to_type', $session_payload["enquiry_to_type"]], ['enquiry_type', 'direct']])->get();
					} else { // if enquiry_id doesn't exist
						$enq_sent_obj = null;
					}

					// 1st Enquiry flow
					if(sizeof($session_payload) > 0 && (($enq_sent_obj && $enq_sent_obj->count() <= 0) || (!$enq_sent_obj))) {
						$enquiry_data = ["user_object_id" => $lead_obj["id"], "user_object_type" => $lead_type, "enquiry_device" => $this->isMobile() ? "mobile" : "desktop", "enquiry_to_id" => $session_payload["enquiry_to_id"], "enquiry_to_type" => $session_payload["enquiry_to_type"], "enquiry_message" => $session_payload["enquiry_message"]];

						if($session_payload["enquiry_to_id"]) {
							$enquiry_sent = ["enquiry_type" => "direct", "enquiry_to_id" => $session_payload["enquiry_to_id"], "enquiry_to_type" => $session_payload["enquiry_to_type"]];
						} else {
							$enquiry_sent = [];
						}

						$create_enq_response = $this->createEnquiry($enquiry_data, $enquiry_sent, [], [], false);
					}
					// End of 1st Enquiry flow
				}*/

				/*** 2nd Enquiry flow ***/
				if($create_enq_response) {
					$enquiry_data = ["enquiry_id" => $create_enq_response["enquiry"]['id']];
				} else if(isset($session_payload["enquiry_id"]) && $session_payload["enquiry_id"] > 0) {
					$enquiry_data = ["enquiry_id" => $session_payload["enquiry_id"]];
				} else {
					$enquiry_data = ["user_object_id" => isset($lead_obj['id']) ? $lead_obj["id"] : null, "user_object_type" => $lead_type, "enquiry_device" => $this->isMobile() ? "mobile" : "desktop", "enquiry_to_id" => isset($session_payload["enquiry_to_id"]) ? $session_payload["enquiry_to_id"] : null, "enquiry_to_type" => isset($session_payload["enquiry_to_type"]) ? $session_payload["enquiry_to_type"] : "App\Listing", "enquiry_message" => $session_payload["enquiry_message"]];
				}


				$enquiry_sent = ["enquiry_type" => "shared", "enquiry_to_id" => isset($session_payload["enquiry_to_id"]) ? $session_payload["enquiry_to_id"] : null, "enquiry_to_type" => isset($session_payload["enquiry_to_type"]) ? $session_payload["enquiry_to_type"] : "App\Listing"];

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
				
				if(!Auth::guest() || isset($verified_session["mobile"]) && $verified_session["mobile"]) { // If premium or (not guest User) then save the data
					$listing_operations_ids = ListingAreasOfOperation::whereIn('area_id', $enquiry_areas)->distinct('listing_id')->pluck('listing_id')->toArray();
					$listing_cat_ids = ListingCategory::whereIn('category_id', $enquiry_categories)->distinct('listing_id')->pluck('listing_id')->toArray();

					/*if(sizeof($listing_operations_ids) > 0 && sizeof($listing_cat_ids) > 0) {
						$listing_final_ids = array_intersect($listing_operations_ids, $listing_cat_ids); // INTERSECTION of 2 Arrays
						if(sizeof($listing_final_ids) < 5) { // If size is < 5, then do UNION of 2 arrays
							$listing_final_ids = $listing_operations_ids;// array_unique(array_merge($listing_operations_ids, $listing_cat_ids)); // Get unique IDs of the Arrays
						}
					} else if (sizeof($listing_operations_ids) > 0 || sizeof($listing_cat_ids) > 0) { // If either 1 array is not Empty, then
						$listing_final_ids = $listing_operations_ids;// array_unique(array_merge($listing_operations_ids, $listing_cat_ids));
					} else {
						$listing_final_ids = [];
					}*/
					
					if(sizeof($listing_operations_ids) > 0 && sizeof($listing_cat_ids) > 0) {
						$listing_final_ids = array_intersect($listing_operations_ids, $listing_cat_ids); // INTERSECTION of 2 Arrays
					} else {
						$listing_final_ids = [];
					}

					if(isset($enquiry_sent['enquiry_to_id']) && $enquiry_sent['enquiry_to_id'] > 0) { // Remove the Primary Enquiry's Listing ID if the Listing ID exist in the Array
						$pos = array_search($enquiry_sent['enquiry_to_id'], $listing_final_ids);
						unset($listing_final_ids[$pos]);
					}

					if(Auth::user()) { // If User is logged In, check if s/he owns a listing, then exclude the listings from recommended Listings
						$user_id = Auth::user()->id;
						$owned_listing_ids = Listing::where(function ($query) use ($user_id) {
							return $query->where('owner_id', $user_id)->orWhere('created_by', $user_id); 
						})->where('status', 1)->pluck('id')->toArray();
						$listing_final_ids = array_diff($listing_final_ids, $owned_listing_ids); // exclude the owner's listings from the filtered Listings => (A = A - B)
					}


					$is_premium_listings = false;
					if (sizeof($listing_final_ids) > 0)  { // If 1 or more Listing is found, then
						$temp_listing_ids = Listing::whereIn('id', $listing_final_ids)->where([['premium', 1], ['status', 1]])->pluck('id')->toArray(); // filter the Listing which has status 'Premium' & 'Published'

						if(sizeof($temp_listing_ids) > 0) { // If premium account exist then
							$listing_final_ids = $temp_listing_ids;
							$is_premium_listings = true;
						} else { // If no premium found, then
							$listing_final_ids = Listing::whereIn('id', $listing_final_ids)->where('status', 1)->pluck('id')->toArray(); // Filter & Get the Listing that are of status 'Published', non 'Premium'
						}
						
						$listing_operations_ids_chunks = array_chunk($listing_final_ids, 5); // each array should have 5 IDs -> 5 is chosen to free the process faster, choosing 500, might take lot of time, which can block even 'high' priority tasks
						foreach ($listing_operations_ids_chunks as $listing_ids_id => $listing_ids_value) {
							/*if($is_premium_listings) {
								ProcessEnquiry::dispatch($enquiry_data, $enquiry_sent, $listing_ids_value, true)->delay(Carbon::now()->addMinutes(1 + $listing_ids_id))->onQueue("low");
							} else {
								if(in_develop()) {
									ProcessEnquiry::dispatch($enquiry_data, $enquiry_sent, $listing_ids_value, true)->delay(Carbon::now()->addMinutes(5 + $listing_ids_id))->onQueue("low");
								} else {
									ProcessEnquiry::dispatch($enquiry_data, $enquiry_sent, $listing_ids_value, true)->delay(Carbon::now()->addHours(1)->addMinutes(1 + $listing_ids_id))->onQueue("low");
								}
							}*/
							ProcessEnquiry::dispatch($enquiry_data, $enquiry_sent, $listing_ids_value, true)->delay(Carbon::now()->addMinutes(1 + $listing_ids_id))->onQueue("low");
							// $this->secondaryEnquiryQueue($enquiry_data, $enquiry_sent, $listing_ids_value, true);
						}
					}

					$this->createEnquiry($enquiry_data, [], $enquiry_categories, $enquiry_areas, false, false);

					/*unset($session_payload["enquiry_id"]);
					unset($session_payload["enquiry_to_id"]);
					unset($session_payload["enquiry_to_enquiry"]);*/
				} else {
					Session::put('second_enquiry_data', ["enquiry_data" => $enquiry_data, "enquiry_sent" => $enquiry_sent, "enquiry_category" => $enquiry_categories, "enquiry_area" => $enquiry_areas]);
				}
				/*** End of 2nd Enquiry flow ***/

				if(isset($verified_session["mobile"]) && $verified_session["mobile"]) { // If mobile verified
					/*if(Auth::guest()) {
						$next_template_type = "step_4";
					} else {
						$next_template_type = "step_" . strVal(intVal(explode('step_', $template_type)[1]) + 1);
					}*/
					$next_template_type = "step_4";

					if($listing_obj && $listing_obj->count() > 0) {
						// $modal_template_html = $this->getEnquiryTemplate($next_template_type, $listing_obj->first()->slug, $session_id, false);
						$modal_template_html = $this->getEnquiryTemplate($next_template_type, $listing_obj->first()->slug, $session_id, false);
					} else {
						$modal_template_html = $this->getEnquiryTemplate($next_template_type, "", $session_id, true);
					}

					$full_screen_display = true;
				} else {
					$next_template_type = "step_" . strVal(intVal(explode('step_', $template_type)[1]) + 1);

					if($listing_obj && $listing_obj->count() > 0) {
						$modal_template_html = $this->getEnquiryTemplate($next_template_type, $listing_obj->first()->slug, $session_id, false);
					} else {
						$modal_template_html = $this->getEnquiryTemplate($next_template_type, "", $session_id, true);
					}
				}
				$status = 200;
				$cookie_cont_obj->set('enquiry_modal_display_count', 0, ['http_only' => false]); // Set the Auto Enquiry Modal Popup count to ZERO, as the User did an Enquiry
			} else if($template_config == "popup_level_four") {
				$next_template_type = "step_" . strVal(intVal(explode('step_', $template_type)[1]) + 1);
				
				if($listing_obj && $listing_obj->count() > 0) {
					$modal_template_html = $this->getEnquiryTemplate($next_template_type, $listing_obj->first()->slug, $session_id, false);
				} else {
					$modal_template_html = $this->getEnquiryTemplate($next_template_type, "", $session_id, true);
				}

				$full_screen_display = true;

				$status = 200;
			}
		}

		if($full_screen_display == false) {
			return response()->json(["popup_template" => $modal_template_html], $status);
		} else {
			return response()->json(["popup_template" => $modal_template_html, "display_full_screen" => $full_screen_display], $status);
		}
	}

	/**
	* This function is used to verify the OTP
	*/
    public function verifyOtp(Request $request) {
    	$status = 400; $modal_template_html = '';
    	$full_screen_display = false;
    	// $output = new ConsoleOutput;

    	if($request->has('contact') && strlen($request->contact) > 0) {
	    	$session_id = Cookie::get('laravel_session');
	    	$template_type = $request->has('enquiry_level') && strlen($request->enquiry_level) > 0 ? $request->enquiry_level : 'step_1';

	    	if($request->has('new_contact') && isset($request->new_contact["country_code"]) && isset($request->new_contact["contact"])) { // New Contact Number
	    		$session_payload = Session::get('enquiry_data', []);
    			$session_payload["contact_code"] = $request->new_contact["country_code"];
    			$session_payload["contact"] = $request->new_contact["contact"];

    			if(!Auth::guest()) { // If logged In User, then update the new Contact number
					$auth_user_contact = Auth::user()->getPrimaryContact();
					if($auth_user_contact && isset($auth_user_contact["contact"]) && $auth_user_contact["contact"]) {
						$auth_user_comm = Auth::user()->getUserCommunications()->where([['object_type', "App\User"], ["object_id", Auth::user()->id], ['value', $auth_user_contact["contact"]]])->first();
						$auth_user_comm->country_code = $session_payload["contact_code"];
						$auth_user_comm->value = $session_payload["contact"];
						$auth_user_comm->save();
					}
				}

    			Session::forget('enquiry_data'); // Delete the Old enquiry_data
				Session::put('enquiry_data', $session_payload); // Create new Enquiry Data
	    		// $this->generateContactOtp('+' . $request->new_contact["country_code"] . $request->new_contact["contact"], "contact", $request->new_contact["country_code"] , $request->new_contact["contact"]); // Generate OTP
	    		if($request->has('listing_slug') && strlen($request->listing_slug) > 0) {
    				$modal_template_html = $this->getEnquiryTemplate($template_type, $request->listing_slug, $session_id, false);
    			} else {
    				$modal_template_html = $this->getEnquiryTemplate($template_type, '', $session_id, true);
    			}

    			$status = 200;
    		} else if($request->has('regenerate') && $request->regenerate == "true") { // Regenerate OTP
    			if($request->has('listing_slug') && strlen($request->listing_slug) > 0) {
    				$modal_template_html = $this->getEnquiryTemplate($template_type, $request->listing_slug, $session_id, false);
    			} else {
    				$modal_template_html = $this->getEnquiryTemplate($template_type, '', $session_id, true);
    			}
    			$status = 200;
    		} else if($request->has('otp') && $request->otp) { // Verify OTP
    			$contact_data = ["contact" => $request->contact, "otp" => $request->otp];
	    		$validation_status = $this->validateContactOtp($contact_data, "contact_info");
	    		
	    		if($validation_status["status"] == 200) {
	    			$status = 200;
	    			$session_payload = Session::get('enquiry_data', []);
    				$secondary_enquiry_data = Session::get('second_enquiry_data', []);
	    			
	    			if(sizeof($session_payload) > 0) {
	    				$cookie_cont_obj = new CookieController;
			        	$other_cookie_params = ["path" => "/", "domain" => sizeof(explode('://', env('APP_URL'))) > 1 ? (explode('://', env('APP_URL'))[1]) : (explode('://', env('APP_URL'))[0]), "http_only" => true];

	    				if(Auth::guest()) {
	    					$lead_obj = Lead::create(["name" => $session_payload["name"], "email" => $session_payload["email"], "mobile" => $session_payload["contact_code"] . '-' . $session_payload["contact"], "user_details_meta" => serialize(["describes_best" => $session_payload["describes_best"]]), "is_verified" => true, "lead_creation_date" => date("Y-m-d H:i:s")]);

	    					// $register_cont_obj = new RegisterController;
	    					$lead_data = array("id" => $lead_obj->id, "name" => $lead_obj->name, "email" => $lead_obj->email, "user_type" => "lead");
	    					// $register_cont_obj->confirmEmail('lead', $lead_data, 'welcome-lead');

	    					$lead_type = "App\Lead";


	    				} else {
	    					$lead_obj = Auth::user();//Lead::create(["name" => $session_payload["name"], "email" => $session_payload["email"], "mobile" => $session_payload["contact"], "is_verified" => true, "lead_creation_date" => date("Y-m-d H:i:s"), "user_id" => Auth::user()->id]);
	    					$lead_type = "App\User";
	    					$lead_comm_obj = $lead_obj->getUserCommunications()->where([['value', $request->contact], ['type', 'mobile']])->update(['is_verified' => 1]); // Update the mobile value to 'Verified'
	    				}

	    				/* Set UserID & User Type in the Cookie, once verified */
	    				$cookie_cont_obj->set('user_id', $lead_obj["id"], $other_cookie_params);
	    				$cookie_cont_obj->set('user_type', $lead_type, $other_cookie_params);
	    				$cookie_cont_obj->set('is_verified', true, $other_cookie_params);

	    				/*** 1st Enquiry flow ***/
	    				if(sizeof($session_payload) > 0) {
	    					$enquiry_data = ["user_object_id" => $lead_obj->id, "user_object_type" => $lead_type, "enquiry_device" => $this->isMobile() ? "mobile" : "desktop",  "enquiry_to_id" => isset($session_payload["enquiry_to_id"]) ? $session_payload["enquiry_to_id"] : null, "enquiry_to_type" => isset($session_payload["enquiry_to_type"]) ? $session_payload["enquiry_to_type"] : "App\Listing", "enquiry_message" => $session_payload["enquiry_message"]];
	    					if(isset($session_payload["enquiry_to_id"]) && $session_payload["enquiry_to_id"])
	    						$enquiry_sent = ["enquiry_type"=> "direct", "enquiry_to_id" => $session_payload["enquiry_to_id"], "enquiry_to_type" => $session_payload["enquiry_to_type"]];
	    					else
	    						$enquiry_sent = [];
	    					$enq_obj = $this->createEnquiry($enquiry_data, $enquiry_sent, [], []);

	    					$session_payload["enquiry_id"] = $enq_obj["enquiry"]->id;
	    					$session_payload["user_object_id"] = $enquiry_data["user_object_id"];
	    					$session_payload["user_object_type"] = $enquiry_data["user_object_type"];
	    					
	    					Session::forget('enquiry_data'); // Delete the Old enquiry_data
	    					Session::put('enquiry_data', $session_payload); // Create new Enquiry Data
	    				} else {
	    					$enq_obj = null;
	    				}
	    				/*** End of 1st Enquiry flow ***/
	    				
	    				//Session::put('otp_verified', ['mobile' => true, "contact" => $session_payload["contact"]]); // Add the OTP verified flag to Session
	    				if(!Auth::guest()) { // If logged In User, then update the new Contact number
							$auth_user_contact = Auth::user()->getPrimaryContact();
							if($auth_user_contact && isset($auth_user_contact["contact"]) && $auth_user_contact["contact"]) {
								$auth_user_comm = Auth::user()->getUserCommunications()->where([['object_type', "App\User"], ["object_id", Auth::user()->id], ['value', $auth_user_contact["contact"]]])->first();
								$auth_user_comm->is_verified = 1;
								$auth_user_comm->save();
							}
						}
	    				$this->setOtpVerified(true, '+' . $session_payload["contact_code"] . $session_payload["contact"]);
	    				
	    				/*** 2nd Enquiry flow ***/
	    				$full_screen_display = false;
	    				if(sizeof($secondary_enquiry_data) > 0) { // If the key exist & value is not NULL
	    					if($enq_obj && isset($enq_obj["enquiry"])) {
	    						$secondary_enquiry_data['enquiry_data']['enquiry_id'] = $enq_obj["enquiry"]->id;
	    					} else if(isset($session_payload['enquiry_id']) && $session_payload['enquiry_id'] > 0) {
	    						$secondary_enquiry_data['enquiry_data']['enquiry_id'] = $session_payload['enquiry_id'];
	    					}

	    					$secondary_enquiry_data['enquiry_data']["user_object_id"] = $lead_obj->id;
	    					$secondary_enquiry_data['enquiry_data']["user_object_type"] = $lead_type;

	    					$listing_operations_ids = ListingAreasOfOperation::whereIn('area_id', $secondary_enquiry_data['enquiry_area'])->distinct('listing_id')->pluck('listing_id')->toArray();
	    					$listing_cat_ids = ListingCategory::whereIn('category_id', $secondary_enquiry_data['enquiry_category'])->distinct('listing_id')->pluck('listing_id')->toArray();

							/*if(sizeof($listing_operations_ids) > 0 && sizeof($listing_cat_ids) > 0) { // If both have value > 0, then
								$listing_final_ids = array_intersect($listing_operations_ids, $listing_cat_ids); // INTERSECTION of 2 Arrays
								if(sizeof($listing_final_ids) < 5) { // If size is < 5, then do UNION of 2 arrays
									$listing_final_ids = $listing_operations_ids;// array_unique(array_merge($listing_operations_ids, $listing_cat_ids)); // Get unique IDs of the Arrays
								}
							} else if (sizeof($listing_operations_ids) > 0 || sizeof($listing_cat_ids) > 0) { // If either 1 array is not Empty, then
								$listing_final_ids = $listing_operations_ids; //array_unique(array_merge($listing_operations_ids, $listing_cat_ids));
							} else {
								$listing_final_ids = [];
							}*/
							
							if(sizeof($listing_operations_ids) > 0 && sizeof($listing_cat_ids) > 0) { // If both have value > 0, then
								$listing_final_ids = array_intersect($listing_operations_ids, $listing_cat_ids); // INTERSECTION of 2 Arrays
							} else {
								$listing_final_ids = [];
							}

							if(isset($secondary_enquiry_data['enquiry_sent']['enquiry_to_id']) && $secondary_enquiry_data['enquiry_sent']['enquiry_to_id'] > 0) { // Remove the Primary Enquiry's Listing ID if the Listing ID exist in the Array
								$pos = array_search($secondary_enquiry_data['enquiry_sent']['enquiry_to_id'], $listing_final_ids);
								unset($listing_final_ids[$pos]);
							}

							if (sizeof($listing_final_ids) > 0)  {
								$temp_listing_ids = Listing::whereIn('id', $listing_final_ids)->where([['premium', 1], ['status', 1]])->pluck('id')->toArray(); // Filter out & get all the listings that have status 'premium' & 'published'

								if(sizeof($temp_listing_ids) > 0) { // If premium account exist then
									$listing_final_ids = $temp_listing_ids;
								} else {
									$listing_final_ids = Listing::whereIn('id', $listing_final_ids)->where('status', 1)->pluck('id')->toArray(); // Filter out & get all listings of status 'published'
								}
							}

							$this->createEnquiry($secondary_enquiry_data['enquiry_data'], [], $secondary_enquiry_data['enquiry_category'], $secondary_enquiry_data['enquiry_area']);
							/*foreach ($listing_operations_ids as $op_key => $op_value) {
								$secondary_enquiry_data['enquiry_sent']["enquiry_to_id"] = $op_value;
								if($op_key === sizeof($listing_operations_ids)) {
									$this->createEnquiry($secondary_enquiry_data['enquiry_data'], $secondary_enquiry_data['enquiry_sent'], [], [], true);
								} else {
									$this->createEnquiry($secondary_enquiry_data['enquiry_data'], $secondary_enquiry_data['enquiry_sent'], [], [], false);
								}
							}*/
							// $this->secondaryEnquiryQueue($secondary_enquiry_data['enquiry_data'], $secondary_enquiry_data['enquiry_sent'], $listing_operations_ids, false);
							$listing_operations_ids_chunks = array_chunk($listing_final_ids, 5); // each array should have 5 IDs -> 5 is chosen to free the process faster, choosing 500, might take lot of time, which can block even 'high' priority tasks
							foreach ($listing_operations_ids_chunks as $listing_ids_id => $listing_ids_value) {
								ProcessEnquiry::dispatch($secondary_enquiry_data['enquiry_data'], $secondary_enquiry_data['enquiry_sent'], $listing_ids_value, false)->delay(Carbon::now()->addMinutes(1 + $listing_ids_id))->onQueue("low");
								/*if(in_develop()) {
									ProcessEnquiry::dispatch($secondary_enquiry_data['enquiry_data'], $secondary_enquiry_data['enquiry_sent'], $listing_ids_value, false)->delay(Carbon::now()->addMinutes(5 + $listing_ids_id))->onQueue("low");
								} else { // Process after 1 hour from now
									ProcessEnquiry::dispatch($secondary_enquiry_data['enquiry_data'], $secondary_enquiry_data['enquiry_sent'], $listing_ids_value, false)->delay(Carbon::now()->addHours(1)->addMinutes(1 + $listing_ids_id))->onQueue("low");
								}*/
							}

							$full_screen_display = true;
							// Session::forget('second_enquiry_data'); // Forget the 2nd enquiry after submit

							/*unset($session_payload["enquiry_id"]); // Remove the Enquiry ID after save of the data
	    					unset($session_payload["enquiry_to_id"]);
							unset($session_payload["enquiry_to_enquiry"]);*/
	    					//Session::flush('second_enquiry_data'); // Delete this key from the session
	    				}
	    				/*** End of 2nd Enquiry flow ***/

	    			}
	    			//$next_template_type = "step_" . strVal(intVal(explode('step_', $template_type)[1]) + 1);
	    			if($request->has('listing_slug') && strlen($request->listing_slug) > 0 && !$full_screen_display) {
	    				$modal_template_html = $this->getEnquiryTemplate($template_type, $request->listing_slug, $session_id, false);
	    			} else {
	    				$modal_template_html = $this->getEnquiryTemplate($template_type, '', $session_id, true);
	    			}
	    		} else {
	    			$status = $validation_status["status"];
	    			$modal_template_html = "";
	    		}
	    	} else {
	    		$status = 404;
	    	}
	    } else {
	    	$modal_template_html = "";
	    }

	    if(!Auth::guest()) {
	    	$user = Auth::user();
	    	Auth::login($user);
	    }

	    if($full_screen_display) {
	    	return response()->json(["popup_template" => $modal_template_html, 'display_full_screen' => $full_screen_display], $status);
	    } else {
	    	return response()->json(["popup_template" => $modal_template_html], $status);

	    }
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
            	array_push($child_array, array('id' => $child->id, 'name' => $child->name, 'order' => $child->order, 'slug' => $child->slug, 'icon_url' => $child->icon_url, "hierarchy" => generateCategoryHierarchy($child['id'])));
            }

            $parent_obj = Category::find($parent);

            if ($parent_obj->parent_id != null) {
                $grandparent = Category::findorFail($parent_obj->parent_id);
            } else {
                $grandparent = null;
            }

            //$parent_array[$parent_obj->id] = array('name' => $parent_obj->name, 'children' => $child_array, 'parent' => $grandparent);
            array_push($parent_array, array('id' => $parent_obj->id, 'name' => $parent_obj->name, 'slug' => $parent_obj->slug, 'icon_url' => $parent_obj->icon_url, 'children' => $child_array, 'parent' => $grandparent));
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
        	$sub_categories = $this->getCategories('listing', $request->category, 'id', $statuses);
        } else if(strpos(" " . $request->category, '[')){ // Adding <space> before the string coz if the indexOf '[' == 0, then it returns index i.e. '0' & if not found, then 'false' i.e. 0 { 'true' => 1, 'false' => 0)
        	$sub_categories = $this->getCategories('listing', json_decode($request->category), 'id', $statuses);
        } else {
        	$sub_categories = $this->getCategories('listing', [$request->category], 'id', $statuses);
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

        if($request->has('is_branch_select') && ($request->is_branch_select === "true" || $request->is_branch_select === true)) {
        	$is_branch_select = true;
        	$view_blade = View::make('modals.category_selection.level_two')->with(compact('sub_categories', 'is_branch_select'))->render();
        } else {
        	$view_blade = View::make('modals.category_selection.level_two')->with(compact('sub_categories'))->render();
        }

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
        	$node_categories = $this->getCategories('listing', $request->branch, 'id', $statuses);
        } else if(strpos(" " . $request->branch, '[')){ // Adding <space> before the string coz if the indexOf '[' == 0, then it returns index i.e. '0' & if not found, then 'false' i.e. 0 { 'true' => 1, 'false' => 0)
        	$node_categories = $this->getCategories('listing', json_decode($request->branch), 'id', $statuses);
        } else {
        	$node_categories = $this->getCategories('listing', [$request->branch], 'id', $statuses);
        }

        /*if(isset($node_categories["parent"]) && $node_categories["parent"]) {
        	$node_categories["parent"] = $node_categories["parent"]->toArray();
        }*/
        //$node_categories = $node_categories[0];

        return response()->json(array("data" => $node_categories), 200);
    }

    /**
    * This function will return a Template Modal based on Level
    */
    public function getCategoryModalDom(Request $request) {
		$this->validate($request, [
            'level' => 'required',
        ]);
		$modal_template = "";
		$parents  = Category::where('type', 'listing')->whereNull('parent_id')->where('status', '1')->orderBy('order')->orderBy('name')->get();

		if($request->level == "level_1") {
			if($request->has('is_parent_select') && ($request->is_parent_select === "true" || $request->is_parent_select === true)) {
				$is_parent_select = true;
				$modal_template = View::make('modals.category_selection.level_one')->with(compact('parents', 'is_parent_select'))->render();
			} else {
				$modal_template = View::make('modals.category_selection.level_one')->with(compact('parents'))->render();
			}
		}
		return response()->json(array("modal_template" => $modal_template), 200);
    }
	
	public function getCategoryHierarchy(Request $request) {
		$this->validate($request, [
	            'category_ids' => 'required',
	        ]);

		// $output = new ConsoleOutput;
		$category_hierarchy = array();
		foreach ($request->category_ids as $key => $category_id) {
			array_push($category_hierarchy, generateCategoryHierarchy($category_id));
		}
		return response()->json(array("data" => $category_hierarchy), 200);
	}
}
