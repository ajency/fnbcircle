<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

use Symfony\Component\Console\Output\ConsoleOutput;

use App\Listing;
use App\Http\Controllers\ListingViewController;

class EnquiryController extends Controller {
	/**
	* This function is used to get respective Modal templates for the Enquiry with data pre-populated if any value found
	*/
   public function getEnquiryTemplate($template_type, $listing_slug="", $session_id = "") {
   		$response_html = '';
   		$listing_view_controller = new ListingViewController;

   		if(strlen($listing_slug) > 0) {
   			$listing = Listing::where('slug',$listing_slug)->get();
   			if($listing->count() > 0) {
   				$listing = $listing->first();
	   			$data = $listing_view_controller->getListingData($listing); // Get the data for the Enquiry Modal template

		   		if($template_type == 'enquiry_template_one' && strlen($session_id) > 0) {
		   			$value = session($session_id, 'default');
		   			$session_data = DB::table('sessions')->where('id', $session_id)->get();
		   			if($session_data->count() > 0) {
		   				$session_data = $session_data->first()->payload;
		   				$payload_data = unserialize(base64_decode($session_data));


		   				if(isset($payload_data["enquiry_data"])) {
		   					$enquiry_data = $payload_data["enquiry_data"];
		   					$response_html = View::make('modals.listing_enquiry')->with(compact('enquiry_data', 'data'))->render();
		   				} else {
		   					$response_html = View::make('modals.listing_enquiry')->with(compact('data'))->render();
		   				}
		   			}
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
	   		if($request->has('template')) {
	   			$modal_template = $this->getEnquiryTemplate($request->template, $request->listing_slug, $session_id);
	   		} else {
	   			$modal_template = $this->getEnquiryTemplate('enquiry_template_one', $request->listing_slug, $session_id);
	   		}
	   	} else {
	   		$modal_template = '';
	   	}

   		return response()->json(["modal_template" => $modal_template], 200);
   }

    public function getPrimaryEnquiry($request) {
    	$output = new ConsoleOutput;

    	$output->writeln(json_encode($request));

    	return response()->json([], 200);
    }
}