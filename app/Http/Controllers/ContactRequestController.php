<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Session;
use View;
use App\Listing;
use App\User;

class ContactRequestController extends Controller
{
    public function getNumberFromSession($request){
        $session_data = Session::get('contact');
        if ($session_data == null){ // generate OTP for first time
            $session_data = Session::get('enquiry_data');
            if ($session_data == null) return response()->json(['html'=>$this->displayLoginPopup($request), 'step' => 'get-details']);
            $number = $this->generateOTP();
        }else{ //generate otp for otp timeout and edit number

            $number = $session_data['contact']; 
        }
        return $number;
    }
    public function getContactRequest(Request $request){
    	$this->validate($request,[
    		'id' => 'required'
    	]);
    	if(Auth::guest()){
    		$otp = Session::get('otp_verified', []);
    		if(!empty($otp)){
    			return response()->json(['html'=> $this->displayContactInformation($request), 'step'=>'contact-info']);
    		}else{
                $number = $this->getNumberFromSession($request);
                if(!is_numeric($number)) return $number;
                $listing = Listing::where('reference',$request->id)->firstorfail();
                $html = View::make('modals.listing_contact_request.verification')->with('listing',$listing)->with('number',$number)->render();
                return response()->json(['html'=> $html, 'step'=>'verification']);
    		}
    	}elseif(!Auth::user()->getPrimaryContact()['is_verified']){
    		return response()->json(['Display verification popup']);
    	}else{
    		return response()->json(['html'=> $this->displayContactInformation($request), 'step'=>'contact-info']);
    	}
    }

    public function displayLoginPopup(Request $request){
    	$listing = Listing::where('reference',$request->id)->firstorfail();
    	return View::make('modals.listing_contact_request.get_details')->with('listing',$listing)->render();
    }

    public function displayContactInformation(Request $request){
    	$listing = Listing::where('reference',$request->id)->firstorfail();
    	//send email to the lead/user with the contact details
    	if($listing->premium){
    		if($listing->owner != null){
    			$user = $listing->owner()->first();
    			// Send email to listing owner
    		}
    		return View::make('modals.listing_contact_request.contact-details-premium')->with('listing',$listing)->render();
    	}else{
    		return View::make('modals.listing_contact_request.contact-details-non-premium')->with('listing',$listing)->render();
    	}
    }

    public function getDetails(Request $request){
        $this->validate($request,[
            'id' => 'required',
            'name' => 'required',
            'email' => 'required|email',
            'mobile' => 'required|numeric',
            'mobile_region' => 'required|numeric',
            'description' => 'required',
        ]);

        $user = User::findUsingEmail($request->email);
        $listing = Listing::where('reference',$request->id)->firstorfail();

        if($user != null){
            $html = View::make('modals.listing_contact_request.get_details')->with('listing',$listing)->with('error','Account already exists. Please login to continue.')->render();
            return response()->json(['html'=> $html, 'step' => 'get-details']);
        }


        $session_data = Session::get('enquiry_data', []); // Collect the old 'enquiry_data' from the 'Session' if exist, else empty ARRAY
        $session_data['name'] = $request->name;
        $session_data['email'] = $request->email;
        $session_data["contact_code"] = $request->mobile_region;
        $session_data["contact"] = $request->mobile;
        $session_data["describes_best"] = json_decode($request->description,true);
        $session_data["enquiry_to_id"] = $listing->id;
        $session_data["enquiry_to_type"] = get_class($listing);

        Session::put('enquiry_data', $session_data); // Update the session with New User details
        Session::forget('contact');

        $number = $this->generateOTP();

        $html = View::make('modals.listing_contact_request.verification')->with('listing',$listing)->with('number',$number)->render();
        
        return response()->json(['html'=> $html, 'step'=>'verification']);
    }	

    public function generateOTP(){
        $enq_cont_obj = new EnquiryController;
        if(Auth::guest()){
            $session_data = Session::get('contact');
            if ($session_data == null){ // generate OTP for first time
                $session_data = Session::get('enquiry_data');
                if ($session_data == null) return false;
                $number = $session_data["contact_code"].$session_data["contact"];
            }else{ //generate otp for otp timeout and edit number
                $number = $session_data['contact']; 
            }
        }else{
            $data = Auth::user()->getPrimaryContact();
            if($data['is_verified'] == 0){
                $number = $data['contact_region'].$data['contact'];
            }else{
                return $data['contact_region'].$data['contact'];
            }
        }
        $enq_cont_obj->generateContactOtp($number, 'contact');

        return $number;
    }

    public function verifyOTP(Request $request){
        $this->validate($request,[
            'id' => 'required',
            'otp' => 'required|numeric'
        ]);
        $enq_cont_obj = new EnquiryController;
        $validate = $enq_cont_obj->validateContactOtp(['otp'=>$request->otp]);
        if($validate[status] == 200) {
            
        }
    }

    public function resendOTP(){

    }
}
