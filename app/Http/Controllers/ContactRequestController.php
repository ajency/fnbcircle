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
    			return response()->json(['Display contact request popup']);
    		}else{
    			// session(['otp_verified' => ['value']]);
    			// return response()->json(['Display login popup']);
				return $this->displayLoginPopup($request);	    				
    		}
    	}elseif(!Auth::user()->getPrimaryContact()['is_verified']){
    		return response()->json(['Display verification popup']);
    	}else{
    		return response()->json(['Display contact request popup']);
    	}
    }

    public function displayLoginPopup(Request $request){
    	$listing = Listing::where('reference',$request->id)->firstorfail();
    	return View::make('modals.listing_contact_request.get_details')->with('listing',$listing)->render();
    }	
}
