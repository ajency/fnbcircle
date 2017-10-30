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
        $enquirer_type = [
            'App\\User' => 'User',
            'App\\Lead' => 'Lead',
        ];
        foreach ($response['data'] as &$enquiry) {
            //get data in correct text format here
            $enquiry['enquirer_type'] = $enquirer_type[$enquiry['enquirer_type']];
            $enquiry['request_date'] = $enquiry['request_date']->toDateString();
            if($enquiry['enquirer_email']['is_verified']){
                $enquiry['enquirer_email'] = $enquiry['enquirer_email']['email'].' <i class="fa fa-check"></i>';
            }else{
                $enquiry['enquirer_email'] = $enquiry['enquirer_email']['email'].' <i class="fa fa-times"></i>';
            }
            if($enquiry['enquirer_phone']['is_verified']==1){
                $enquiry['enquirer_phone'] = $enquiry['enquirer_phone']['contact'].' <i class="fa fa-check"></i>';
            }else{
                $enquiry['enquirer_phone'] = $enquiry['enquirer_phone']['contact'].' <i class="fa fa-times"></i>';
            }
            $enquiry['enquirer_details'] = implode(', ',$enquiry['enquirer_details']);
            $categories = [];
            foreach($enquiry['categories'] as $branch){
                $category = $branch['parent'].' > '.$branch['branch'].' > ';
                $nodes = [];
                foreach ($branch['nodes'] as $node) {
                    $nodes[] = $node['name'];
                }
                $category .= implode(', ',$nodes);
                $categories[] = $category;
            }
            $enquiry['categories'] = implode('<br/>',$categories);

            $areas = [];
            foreach($enquiry['areas'] as $city_id => $cities){
                $city = $cities[0]->city()->first()->name.' > ';
                $area = [];
                foreach($cities as $city_area_ref){
                    $city_area = $city_area_ref->area()->first();
                    $area[] = $city_area->name; 
                }
                $city .= implode(', ',$area);
                $areas[] = $city;               
            }
            $enquiry['areas'] = implode('<br/>',$areas);

            $enquiry['made_against'] = $enquiry['made_against']->title;
            $sendTo = [];
            foreach ($enquiry['sent_to'] as $listing) {
                $sendTo[] = $listing->title;
            }
            $enquiry['sent_to'] = implode('<br/>',$sendTo);


        }
        return response()->json($response);
    }

    public function displayEnquiries($display_limit, $start, $order, $filters)
    {
    	$listing = new Listing();

    	$enquiries = Enquiry::where('enquiry_to_type',get_class($listing));
        $filtered = $enquiries->count();
        $enquiries = $enquiries->get();
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
                $response[$enquiry->id]['enquirer_details'] = unserialize($enquiry->user_object()->first()->user_details_meta)['describes_best']; 
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
        // dd($response);
        $response1 = array();
        foreach ($response as $resp) {
            $response1[] = $resp;
        }
        $all = Enquiry::where('enquiry_to_type',get_class($listing))->count();
        return array('draw' => "1", 'sEcho' => 0, "recordsTotal" => $all, "recordsFiltered" => $filtered, 'data' => $response1);
    }
}
