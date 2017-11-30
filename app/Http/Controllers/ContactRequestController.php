<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Session;
use View;
use App\Listing;

class ContactRequestController extends Controller
{
    public function getContactRequest(Request $request){
    	$this->validate($request,[
    		'id' => 'required'
    	]);
    	if(Auth::guest()){
    		$otp = Session::get('otp_verified', []);
    		if(!empty($otp)){
    			return $this->displayContactInformation($request);
    		}else{
				return $this->displayLoginPopup($request);	    				
    		}
    	}elseif(!Auth::user()->getPrimaryContact()['is_verified']){
    		return response()->json(['Display verification popup']);
    	}else{
    		return $this->displayContactInformation($request);
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
}
