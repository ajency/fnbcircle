<?php

namespace App\Http\Controllers;

use App\Listing;
use App\User;
use App\UserCommunication;
use App\Lead;
use App\ListingCategory;
use App\Area;
use App\Enquiry;
use App\EnquirySent;
use Auth;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Http\Request;
use Session;
use View;
use Carbon\Carbon;
use Spatie\Activitylog\Models\Activity;

class ContactRequestController extends Controller
{
    public function getNumberFromSession($request)
    {
        $session_data = json_decode(Session::get('contact_info'),true);
        if ($session_data == null) {/*Known bug: if lead is verified and then user logs in, Verification sms isnt sent */
            // generate OTP for first time
            if(Auth::guest()){
                $session_data = Session::get('enquiry_data');
                if ($session_data == null) {
                    return response()->json(['html' => $this->displayLoginPopup($request), 'step' => 'get-details']);
                }
            }

            $number = $this->generateOTP();
        } else {
            //generate otp for otp timeout and edit number

            $number = $session_data['contact'];
        }
        return $number;
    }

    public function displayVerificationPopup(Request $request){
        $number = $this->getNumberFromSession($request);
        if (!is_numeric($number)) {
            return $number;
        }

        $listing = Listing::where('reference', $request->id)->firstorfail();
        $html    = View::make('modals.listing_contact_request.verification')->with('listing', $listing)->with('number', $number)->render();
        if(in_develop()) return response()->json(['html' => $html, 'step' => 'verification', 'OTP' => json_decode(Session::get('contact_info',[]),true)['OTP']]);
        else return response()->json(['html' => $html, 'step' => 'verification']);
    }

    public function getContactRequest(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
        ]);
        if (Auth::guest()) {
            $otp = Session::get('otp_verified', []);
            if (!empty($otp)) {
                return response()->json(['html' => $this->displayContactInformation($request), 'step' => 'contact-info']);
            } else {

                return $this->displayVerificationPopup($request);
            }
        } elseif (!Auth::user()->getPrimaryContact()['is_verified']) {
            return $this->displayVerificationPopup($request);
        } else {
            return response()->json(['html' => $this->displayContactInformation($request), 'step' => 'contact-info']);
        }
    }

    public function displayLoginPopup(Request $request)
    {
        $listing = Listing::where('reference', $request->id)->firstorfail();
        $area = Area::with('city')->find($listing->locality_id);
        return View::make('modals.listing_contact_request.get_details')->with('listing', $listing)->with('area',$area)->render();
    }

    public function sendPremiumContact($listing){
        if(Auth::guest()){
            $session = Session::get('enquiry_data', ["name"=>""]);
            $name =  $session['name'];
            $email = $session["email"];
            $email_verified = false; 
            $mobile = '+('.Session::get('enquiry_data')['contact_code'].')'.Session::get('enquiry_data')['contact'];
            $mobile_verified = true;
        }else{
            $name = Auth::user()->name;
            $email = Auth::user()->getPrimaryEmail();
            $email_verified = true;
            $contact = Auth::user()->getPrimaryContact();
            $mobile = '+('.$contact['contact_region'].')'.$contact['contact'];
            $mobile_verified = true;
        }
        
        //send email to the lead/user with the contact details
        $area = Area::with('city')->find($listing->locality_id);
        $email_data = [
            'to' => $email,
            'subject' => "Contact Details of ".$listing->title,
            'priority' =>'low',
            'template_data' => [
                'listing_url' => url('/'.$area->city['slug'].'/'.$listing->slug),
                'listing' => $listing,
                'name'=>$name,
            ],
        ];
        sendEmail('contact-request-seeker-premium',$email_data);

        //send sms to lead/user
        $sms_contacts = $listing->getAllContacts(true);
        $message = "Hi ".$name." \nPlease find below contact details of the listing. \nListing Name: ".$listing->title;
        if($sms_contacts['email'] !="")$message.= "\nEmail: ".$sms_contacts['email'];
        if($sms_contacts['mobile'] !="")$message.= "\nPhone: ".$sms_contacts['mobile'];
        if($sms_contacts['landline'] !="")$message.= "\nLandline: ".$sms_contacts['landline'];
        $message.= "\nWe have shared your contact details with the owner of ".$listing->title;
        $sms_data = [
            'to' => $mobile,
            'message' => $message,
            'priority' => 'low'

        ];
        sendSms('contact-request-seeker-premium',$sms_data);

        if ($listing->owner != null) {
            $user = $listing->owner()->first();
            
            // Send email to listing owner
            $email_data = [
                'to' => $user->getPrimaryEmail(),
                'subject' => 'Contact details of '.$listing->title.' shared with a seeker',
                'priority' => 'low',
                'template_data' => [
                    'listing_url' => url('/'.$area->city['slug'].'/'.$listing->slug),
                    'listing_name' => $listing->title,
                    'name' => $user->name,
                    'customer_name' => $name,
                    'customer_email' => $email,
                    'email_verified' => $email_verified,
                    'customer_contact' => $mobile,
                    'contact_verified' => $mobile_verified,
                ],
            ];
            if(!Auth::guest()){
                $email_data['template_data']['customer_dashboard_url'] = url('/profile/basic-details/'.$email);
            }
            sendEmail('contact-request-owner-premium',$email_data);
            
            //send sms to owner
            $owner_cont = $user->getPrimaryContact();
            $message = "Hi ".$user->name.", \n We have shared the contact details of ".$listing->title." with a seeker interested in your listing. \nPlease find below details of the seeker: \nName: ".$name." \nEmail: ".$email." \nPhone: ".$mobile;
            if(!Auth::guest()) $message.= " \nGo to ".urlShortner(url('/profile/basic-details/'.$email))['id']." to view the profile of ".$name;
            $sms_data = [
                'to' => $owner_cont['contact_region'].$owner_cont['contact'],
                'message' => $message,
                'priority' => 'low'
            ];
            sendSms('contact-request-owner-premium',$sms_data);
        }
    }

    public function sendNonPremiumContact($listing,$ld){
        if(Auth::guest()){
            $session = Session::get('enquiry_data', ["name"=>""]);
            $name =  $session['name'];
            $email = $session["email"]; 
            $mobile = Session::get('otp_verified')['contact'];

        }else{
            $name = Auth::user()->name;
            $email = Auth::user()->getPrimaryEmail();
            $mobile = Auth::user()->getPrimaryContact();
        }
        //send email to the lead/user with the contact details
        $area = Area::with('city')->find($listing->locality_id);
        $email_data = [
            'to' => $email,
            'subject' => "Contact Details of ".$listing->title,
            'priority' =>'low',
            'template_data' => [
                'listing_url' => url('/'.$area->city['slug'].'/'.$listing->slug),
                'listing' => $listing,
                'name'=>$name,
                'listing_data' => $ld,
            ],
        ];
        sendEmail('contact-request-seeker-non-premium',$email_data);
        //send sms to lead/user
        $sms_contacts = $listing->getAllContacts(true);
        $message = "Hi ".$name." \nPlease find below contact details of the listing. \nListing Name: ".$listing->title;
        if($sms_contacts['email'] !="")$message.= "\nEmail: ".$sms_contacts['email'];
        if($sms_contacts['mobile'] !="")$message.= "\nPhone: ".$sms_contacts['mobile'];
        if($sms_contacts['landline'] !="")$message.= "\nLandline: ".$sms_contacts['landline'];
        $sms_data = [
            'to' => $mobile,
            'message' => $message,
            'priority' => 'low'

        ];
        sendSms('contact-request-seeker-premium',$sms_data);
    }
    
    public function displayContactInformation(Request $request)
    {
        $listing = Listing::where('reference', $request->id)->firstorfail();
        if(Auth::guest()){
            $session = Session::get('enquiry_data');
            $user = Lead::find($session['user_object_id']);
        }else{
            $user = Auth::user();
        }
        
        $ec = new EnquiryController;

        $enquiry = new Enquiry;
        $enquiry->user_object_id = $user->id;
        $enquiry->user_object_type = get_class($user);
        $enquiry->enquiry_device = $ec->isMobile()? "mobile":'desktop'; 
        $enquiry->enquiry_to_id = $listing->id;
        $enquiry->enquiry_to_type = get_class($listing);
        $enquiry->type = 'contact-request';
        $enquiry->save();

        $sent = new EnquirySent;
        $sent->enquiry_id = $enquiry->id;
        $sent->enquiry_type = 'contact-request';
        $sent->enquiry_to_type = get_class($listing);
        $sent->enquiry_to_id = $listing->id;
        $sent->is_archived = 0;
        $sent->save();

        logActivity('contact-request-created',$enquiry,$user);
        // activity()
        //    ->performedOn($enquiry)
        //    ->causedBy($user)
        //    ->log('contact-request-created');
        
        if ($listing->premium) {
            $this->sendPremiumContact($listing);
            return View::make('modals.listing_contact_request.contact-details-premium')->with('listing', $listing)->render();
        } else {

            $ld = $this->similarBusinesses($listing);
            $this->sendNonPremiumContact($listing,$ld);
            return View::make('modals.listing_contact_request.contact-details-non-premium')->with('listing', $listing)->with('new_tab',true)->with('listing_data',$ld)->render();
        }
    }

    public function similarBusinesses($listing)
    {
        $similar_id = [$listing->id];
        $categories = ListingCategory::where('listing_id', $listing->id)->where('core', 1)->pluck('category_id')->toArray();
        $simCore    = array_unique(ListingCategory::whereIn('category_id', $categories)->where('core',1)->whereNotIn('listing_id', $similar_id)->pluck('listing_id')->toArray());

        //rule : At least 1 core category matching + type + locality
        $similar = Listing::whereNotIn('id', $similar_id)->whereIn('id', $simCore)->where('status', 1)->where('type', $listing->type)->where('locality_id', $listing->locality_id)->where('premium',1)->orderBy('updated_at')->take(3)->get();
        foreach ($similar as $sim) {
            $similar_id[] = $sim->id;

        }

        if (count($similar_id) < 4) {
            //rule : At least 1 core category matching + type
            $similar = Listing::whereNotIn('id', $similar_id)->whereIn('id', $simCore)->where('status', 1)->where('type', $listing->type)->where('premium',1)->orderBy('updated_at')->take(2)->get();
            foreach ($similar as $sim) {
                $similar_id[] = $sim->id;

            }
            if (count($similar_id) < 4) {
                //rule : At least 1 core category matching + location
                $similar = Listing::whereNotIn('id', $similar_id)->whereIn('id', $simCore)->where('status', 1)->where('premium',1)->orderBy('updated_at')->take(3)->get();
                foreach ($similar as $sim) {
                    $similar_id[] = $sim->id;

                }
                if (count($similar_id) < 4) {
                    //rule : At least 1 core category matching
                    $similar = Listing::whereNotIn('id', $similar_id)->whereIn('id', $simCore)->where('status', 1)->where('locality_id', $listing->locality_id)->where('premium',1)->orderBy('updated_at')->take(3)->get();
                    foreach ($similar as $sim) {
                        $similar_id[] = $sim->id;

                    }
                }
            }
        }
        unset($similar_id[0]);
        if(count($similar_id) == 0) return null;
        $filters = ["listing_ids" => $similar_id];
        $listviewObj = new ListViewController;
        $listing_data = $listviewObj->getListingSummaryData("", $filters, 1, 3, "updated_at", "desc")["data"];

        return $listing_data;
    }

    public function getDetails(Request $request)
    {
        $this->validate($request, [
            'id'            => 'required',
            'name'          => 'required',
            'email'         => 'required|email',
            'mobile'        => 'required|numeric',
            'mobile_region' => 'required|numeric',
            'description'   => 'required',
        ]);

        $user    = User::findUsingEmail($request->email);
        $listing = Listing::where('reference', $request->id)->firstorfail();
        $area = Area::with('city')->find($listing->locality_id);
        if ($user != null) {
            $html = View::make('modals.listing_contact_request.get_details')->with('listing', $listing)->with('area',$area)->with('error', 'Account already exists. Please login to continue.')->render();
            return response()->json(['html' => $html, 'step' => 'get-details']);
        }

        $session_data                    = Session::get('enquiry_data', []); // Collect the old 'enquiry_data' from the 'Session' if exist, else empty ARRAY
        $session_data['name']            = $request->name;
        $session_data['email']           = $request->email;
        $session_data["contact_code"]    = $request->mobile_region;
        $session_data["contact"]         = $request->mobile;
        $session_data["describes_best"]  = json_decode($request->description, true);
        $session_data["enquiry_to_id"]   = $listing->id;
        $session_data["enquiry_to_type"] = get_class($listing);
        $session_data["enquiry_message"] = "";

        Session::put('enquiry_data', $session_data); // Update the session with New User details
        Session::forget('contact_info');

        $number = $this->generateOTP();

        $html = View::make('modals.listing_contact_request.verification')->with('listing', $listing)->with('number', $number)->render();

        if(in_develop()) return response()->json(['html' => $html, 'step' => 'verification', 'OTP' => json_decode(Session::get('contact_info',[]),true)['OTP']]);
        else return response()->json(['html' => $html, 'step' => 'verification']);
    }

    public function generateOTP()
    {
        $enq_cont_obj = new EnquiryController;
        if (Auth::guest()) {
            $json = Session::get('contact_info');
            $session_data = json_decode($json,true);
            if ($session_data == null) {
                // generate OTP for first time
                $session_data = Session::get('enquiry_data');
                if ($session_data == null) {
                    return false;
                }
                $phone = $session_data["contact"];
                $country = $session_data["contact_code"];
                $number = $session_data["contact_code"] . $session_data["contact"];
            } else {
                //generate otp for otp timeout and edit number
                $number = $session_data['contact'];
                $country = $session_data['country_code'];
                $phone = $session_data['phone_no'];

            }
        } else {
            $data = Auth::user()->getPrimaryContact();
            if ($data['is_verified'] == 0) {
                $json = Session::get('contact_info');
                $session_data = json_decode($json,true);
                if ($session_data == null) {
                    // generate OTP for first time
                    $number = $data['contact_region'] . $data['contact'];
                    $country = $data['contact_region'];
                    $phone = $data['contact'];
                } else {
                    //generate otp for otp timeout and edit number
                    $number = $session_data['contact'];
                    $country = $session_data['country_code'];
                    $phone = $session_data['phone_no'];
                }
            } else {
                return $data['contact_region'] . $data['contact'];
            }
        }
        $enq_cont_obj->generateContactOtp($number, 'contact',$country,$phone);

        return $number;
    }

    public function verifyOTP(Request $request)
    {
        $this->validate($request, [
            'id'  => 'required',
            'otp' => 'required|numeric',
        ]);
        $listing = Listing::where('reference', $request->id)->firstorfail();
        $enq_cont_obj = new EnquiryController;
        $validate     = $enq_cont_obj->validateContactOtp(['otp' => $request->otp],'contact_info');
        // dd($validate);
        $session_payload = Session::get('enquiry_data', []);
        $json = Session::get('contact_info');
        $session_contact = json_decode($json,true);
        if ($validate['status'] == 200) {
            if (sizeof($session_payload) > 0 or !Auth::guest()) {
                $cookie_cont_obj     = new CookieController;
                $other_cookie_params = [
                    "path" => "/", 
                    "domain" => sizeof(explode('://', env('APP_URL'))) > 1 ? (explode('://', env('APP_URL'))[1]) : (explode('://', env('APP_URL'))[0]), "http_only" => true
                ];
                
                if (Auth::guest()) {
                    $lead_obj = Lead::create([
                        "name" => $session_payload["name"], 
                        "email" => $session_payload["email"], 
                        "mobile" => $session_contact["country_code"] . '-' . $session_contact["phone_no"], 
                        "user_details_meta" => serialize([
                            "describes_best" => $session_payload["describes_best"]
                        ]), 
                        "is_verified" => true, 
                        "lead_creation_date" => date("Y-m-d H:i:s")
                    ]);
                    $register_cont_obj = new RegisterController;
                    $lead_data         = array("id" => $lead_obj->id, "name" => $lead_obj->name, "email" => $lead_obj->email, "user_type" => "lead");
                    // $register_cont_obj->confirmEmail('lead', $lead_data, 'welcome-lead');
                    $lead_type = "App\\Lead";
                } else {
                    $lead_obj  = Auth::user();
                    $lead_type = "App\\User";
                    $lead_obj->getUserCommunications()->where('type','mobile')->delete();
                    $user_comm = new UserCommunication;
                    $user_comm->object_type = $lead_type;
                    $user_comm->object_id = $lead_obj->id;
                    $user_comm->type = 'mobile';
                    $user_comm->value = $session_contact["phone_no"];
                    $user_comm->country_code = $session_contact["country_code"];
                    $user_comm->is_primary = 1;
                    $user_comm->is_verified = 1;
                    $user_comm->is_communication = 1;
                    $user_comm->is_visible = 1;
                    $user_comm->save();
                }
                /* Set UserID & User Type in the Cookie, once verified */
                $cookie_cont_obj->set('user_id', $lead_obj["id"], $other_cookie_params);
                $cookie_cont_obj->set('user_type', $lead_type, $other_cookie_params);
                $cookie_cont_obj->set('is_verified', true, $other_cookie_params);
                // $enquiry_data = [
                //     "user_object_id" => $lead_obj->id, 
                //     "user_object_type" => $lead_type, 
                //     "enquiry_device" => $enq_cont_obj->isMobile() ? "mobile" : "desktop",
                //     "enquiry_to_id" => isset($session_payload["enquiry_to_id"]) ? $session_payload["enquiry_to_id"] : $request->id, 
                //     "enquiry_to_type" => isset($session_payload["enquiry_to_type"]) ? $session_payload["enquiry_to_type"] : "App\Listing", 
                //     "enquiry_message" => $session_payload["enquiry_message"]];
                $session_payload["user_object_id"] = $lead_obj->id;
                $session_payload["user_object_type"] = $lead_type;
                $session_payload["contact"] = $session_contact["phone_no"];;
                $session_payload["contact_code"] = $session_contact["country_code"];

                Session::put('enquiry_data',$session_payload);
                $enq_cont_obj->setOtpVerified(true, $session_contact["phone_no"]);
                return $this->getContactRequest($request);
            }
            else{
                $error = "Looks like your session expired. Please refresh your page";
                $html = View::make('modals.listing_contact_request.verification')->with('listing', $listing)->with('number', "xxxxxxxxxxxx")->with('error',$error)->render();
                return response()->json(['html' => $html, 'step' => 'verification']);
            }
        }elseif($validate['status'] == 400){
            $error = "Incorrect OTP. Please enter valid OTP";
            $html = View::make('modals.listing_contact_request.verification')->with('listing', $listing)->with('number', $session_contact["contact"])->with('error',$error)->render();
            if(in_develop()) return response()->json(['html' => $html, 'step' => 'verification', 'OTP' => $session_contact['OTP']]);
            else return response()->json(['html' => $html, 'step' => 'verification']);
        }else{

            return $this->resendOTP($request,true);
        }
    }

    public function resendOTP(Request $request,$expired = false)
    {
        $this->validate($request,[
            'id'=>'required',
        ]);
        $listing = Listing::where('reference', $request->id)->firstorfail();
        $session_data = json_decode(Session::get('contact_info'),true);
        $number = $session_data['contact'];
        if($expired){
            $error = "OTP expired. New OTP has been sent to you";
            $session_data['OTP'] = rand(1000, 9999);
        }else{
            $error = 'OTP sent again';
        }
        $session_data['timestamp'] = Carbon::now()->timestamp;
        Session::put('contact_info', json_encode($session_data));
        error_log(json_encode($session_data));
        $sms = [
            'to' => $session_data['contact'],
            'message' => "Use " . $session_data['OTP'] . " to verify your phone number. This code can be used only once and is valid for 15 mins.",
        ];
        $sms["priority"] = "high";
        sendSms('verification', $sms);
        $html = View::make('modals.listing_contact_request.verification')->with('listing', $listing)->with('number', $number)->with('error',$error)->render();
        if(in_develop()) return response()->json(['html' => $html, 'step' => 'verification', 'OTP' => $session_data['OTP']]);
        else return response()->json(['html' => $html, 'step' => 'verification']);
    }

    public function editNumber(Request $request){
        $this->validate($request,[
            'id' => 'required',
            'contact'=> 'required|numeric',
            'contact_region'=> 'required|numeric'
        ]);
        $listing = Listing::where('reference', $request->id)->firstorfail();
        $json = Session::get('contact_info',[]);
        $session_info = json_decode($json,true);
        $session_info['contact'] = $request->contact_region.$request->contact;
        $session_info['country_code'] = $request->contact_region;
        $session_info['phone_no'] = $request->contact;
        Session::forget('contact_info');
        Session::put('contact_info',json_encode($session_info));

        $number = $this->generateOTP();
        $error = "Otp is sent to your number";
        $html = View::make('modals.listing_contact_request.verification')->with('listing', $listing)->with('number', $number)->with('error',$error)->render();

        if(in_develop()) return response()->json(['html' => $html, 'step' => 'verification', 'OTP' => json_decode(Session::get('contact_info',[]),true)['OTP']]);
        else return response()->json(['html' => $html, 'step' => 'verification']);

    }
}
