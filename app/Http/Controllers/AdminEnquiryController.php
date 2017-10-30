<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Listing;
use App\Category;
use App\City;
use App\Enquiry;
use App\EnquiryCategory;

class AdminEnquiryController extends Controller
{
    public function manageEnquiries(Request $request){
        $parent_categ = Category::whereNull('parent_id')->orderBy('order')->orderBy('name')->where('status','1')->where('type','listing')->get();
        $cities       = City::where('status', '1')->get();
        return view('admin-dashboard.manage_enquiries')->with('parents', $parent_categ)->with('cities', $cities);
    }
    public function displayEnquiriesDum(Request $request)
    {
        $filters  = $request->filters;
        $order   = $request->order['0']['dir'];
        $response = $this->displayEnquiries($request->length, $request->start, $order, $filters);
        foreach ($response['data'] as &$listing) {
            //get data in correct text format here
        }
        return response()->json($response);
    }

    public function displayEnquiries($display_limit, $start, $order, $filters)
    {
    	$listing = new Listing();

    	$enquiries = Enquiry::where('enquiry_to_type',get_class($listing))->get();
    	// dd($enquiries);
    	$response = [];
    	foreach($enquiries as $enquiry){
            $response[$enquiry->id] = [];
    		if($enquiry->sentTo()->count() > 1) $response[$enquiry->id]['type'] = 'shared';
            else $response[$enquiry->id]['type'] = 'direct';

            $response[$enquiry->id]['request_date'] = $enquiry->created_at;

            $response[$enquiry->id]['enquirer_type'] = $enquiry->user_object_type;

            $response[$enquiry->id]['enquirer_name'] = $enquiry->user_object()->first()->name;
            $response[$enquiry->id]['enquirer_email'] = $enquiry->user_object()->first()->getPrimaryEmail(true);
            $response[$enquiry->id]['enquirer_phone'] = $enquiry->user_object()->first()->getPrimaryContact(true);
            if($enquiry->user_object_type == 'App\\User'){
                $response[$enquiry->id]['enquirer_details'] = unserialize($enquiry->user_object()->first()->getUserDetails()->first()->subtype);
            }else{
                $response[$enquiry->id]['enquirer_details'] = unserialize($enquiry->user_object()->first()->user_details_meta); 
            }

            $response[$enquiry->id]['message'] = $enquiry->enquiry_message;
            $response[$enquiry->id]['areas'] = $enquiry->areas()->with('area')->with('city')->get()->groupBy('city_id');
            $response[$enquiry->id]['categories'] = EnquiryCategory::getCategories($enquiry->id);
            $response[$enquiry->id]['made_against'] = $enquiry->enquiry_to()->first();
            $response[$enquiry->id]['sent_to'] = [];
            $sentTo = $enquiry->sentTo()->get();

            foreach ($sentTo as $to) {
                $object = $to->enquiry_to()->first();
                $response[$enquiry->id]['sent_to'][$object->id] = $object;
            }


    	}
        return $response;
    }
}
