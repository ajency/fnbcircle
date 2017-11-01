<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Listing;
use App\Category;
use App\City;
use App\Enquiry;
use App\EnquirySent;
use App\EnquiryCategory;
use App\EnquiryArea;
use App\User;
use App\Lead;
use App\UserCommunication;
use App\Area;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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
        $enquiry_type = [
            'direct' => 'Direct Enquiry',
            'shared' => 'Shared Enquiry',
        ];
        $enquirer_type = [
            'App\\User' => 'User',
            'App\\Lead' => 'Lead',
        ];
        foreach ($response['data'] as &$enquiry) {
            //get data in correct text format here
            $enquiry['type'] = $enquiry_type[$enquiry['type']];
            $enquiry['enquirer_type'] = $enquirer_type[$enquiry['enquirer_type']];
            $enquiry['request_date'] = $enquiry['request_date']->toDateString();
            if($enquiry['enquirer_email']['is_verified']){
                $enquiry['enquirer_email'] = $enquiry['enquirer_email']['email'].' <i class="fa fa-check"></i>';
            }else{
                $enquiry['enquirer_email'] = $enquiry['enquirer_email']['email'].' <i class="fa fa-times"></i>';
            }
            if($enquiry['enquirer_phone']['is_verified']==1){
                $enquiry['enquirer_phone'] = $enquiry['enquirer_phone']['contact_region'].'-'.$enquiry['enquirer_phone']['contact'].' <i class="fa fa-check"></i>';
            }else{
                $enquiry['enquirer_phone'] = $enquiry['enquirer_phone']['contact_region'].'-'.$enquiry['enquirer_phone']['contact'].' <i class="fa fa-times"></i>';
            }
            $config = config('helper_generate_html_config.enquiry_popup_display');
            foreach ($enquiry['enquirer_details'] as &$detail) {
                $detail = $config[$detail]['title'];
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
            $against_city = Area::with('city')->find($enquiry['made_against']->locality_id);
            $enquiry['made_against'] = '<a href="'.url('/'.$against_city->city['slug'].'/'.$enquiry['made_against']->slug).'"  target="_blank" >'.$enquiry['made_against']->title;
            $sendTo = [];
            foreach ($enquiry['sent_to'] as $listing) {
                // $sendTo[] = $listing->title;
                $sendTo[] = '<a href="'.url('/'.$listing->location()->first()->city()->first()->slug.'/'.$listing->slug).'"  target="_blank" >'.$listing->title;
            }
            $enquiry['sent_to'] = implode('<br/>',$sendTo);


        }
        return response()->json($response);
    }


    public function displaylistingEnquiries(Request $request)
    {
        $this->validate($request,[
            'listing_id' => 'required',
        ]);
        $filters  = $request->filters;
        $order   = $request->order['0']['dir'];
        $listing = Listing::where('reference', $request->listing_id)->first();
        $response = $this->displayEnquiries($request->length, $request->start, $order, $filters, 'listing', $listing->id);
        $enquiry_type = [
            'direct' => '<label class="fnb-label text-secondary m-b-5">Direct Enquiry</label><br>',
            'shared' => '<label class="fnb-label text-primary m-b-5">Shared Enquiry</label><br>',
        ];
        $enquirer_type = [
            'App\\User' => 'User',
            'App\\Lead' => 'Lead',
        ];
        foreach ($response['data'] as &$enquiry) {
            //get data in correct text format here
            $enquiry['type'] = $enquiry_type[$enquiry['type']].' Request sent '.$enquiry['request_date']->diffForHumans();
            if($enquiry['enquirer_email']['is_verified']){
                $enquiry['enquirer_email'] = $enquiry['enquirer_email']['email'].'<img src="/img/verified.png" class="lead-verify" width="12">';
            }else{
                $enquiry['enquirer_email'] = $enquiry['enquirer_email']['email'].' ';
            }
            if($enquiry['enquirer_phone']['is_verified']==1){
                $enquiry['enquirer_phone'] = $enquiry['enquirer_phone']['contact_region'].'-'.$enquiry['enquirer_phone']['contact'].' <img src="/img/verified.png" class="lead-verify" width="12">';
            }else{
                $enquiry['enquirer_phone'] = $enquiry['enquirer_phone']['contact_region'].'-'.$enquiry['enquirer_phone']['contact'].' ';
            }
            $config = config('helper_generate_html_config.enquiry_popup_display');
            foreach ($enquiry['enquirer_details'] as &$detail) {
                $detail = $config[$detail]['title'];
            }
            $enquiry['enquirer_details'] = implode(', ',$enquiry['enquirer_details']);
            // dd($enquiry);
            $categories = [];
            foreach($enquiry['categories'] as $branch){
                // $category = $branch['parent'].' > '.$branch['branch'].' > ';
                $category = '<div class="ca-holder m-b-10">
                                <div class="location flex-row align-top">
                                    <p class="m-b-0 text-color heavier default-size state-name">'.$branch['parent'].' <i class="fa fa-caret-right p-l-5 p-r-5" aria-hidden="true"></i>
                                    </p>
                                    <ul class="cities flex-row flex-wrap">
                                      <li>
                                          <p class="cities__title default-size m-b-0 text-color">'.$branch['branch'].'</p>
                                      </li>
                                     </ul>
                                </div>
                                <div class="ca-holder m-b-5">
                                    <ul class="cities flex-row flex-wrap m-t-5">';
                foreach ($branch['nodes'] as $node) {
                    $category .= '<li><p class="cities__title default-size m-b-0 text-color">'.$node['name'].'</p></li>';
                }
                $category .= '</ul></div></div>';
                $categories[] = $category;
            }
            $enquiry['categories'] = implode('',$categories);

            $areas = [];
            foreach($enquiry['areas'] as $city_id => $cities){
                // $city = $cities[0]->city()->first()->name.' > ';
                $city = '<div class="ca-holder">
                          <div class="location flex-row align-top">
                              <p class="m-b-0 text-color heavier default-size state-name"><i class="fa fa-map-marker text-lighter" aria-hidden="true"></i> '.$cities[0]->city()->first()->name.' <i class="fa fa-caret-right p-l-5 p-r-5" aria-hidden="true"></i>
                              </p>
                              <ul class="cities flex-row flex-wrap">';
                $area = [];
                foreach($cities as $city_area_ref){
                    $city_area = $city_area_ref->area()->first();
                    $city .= '<li><p class="cities__title default-size m-b-0">'.$city_area->name.'</p></li>';
                }
                $city .= '</ul></div></div>';
                $areas[] = $city;               
            }
            $enquiry['areas'] = implode('',$areas);
        }
        return response()->json($response);
    }
    public function displayEnquiries($display_limit, $start, $order, $filters, $type="admin",$listing_id = '')
    {
    	$listing = new Listing();

    	if($type=='admin') $enquiries = Enquiry::where('enquiry_to_type',get_class($listing));
        else {
            if($listing_id!=''){
                $listing_enquiry = EnquirySent::where('enquiry_to_id',$listing_id)->pluck('enquiry_id')->toArray();
                $enquiries = Enquiry::where('enquiry_to_type',get_class($listing))->whereIn('id',$listing_enquiry);
            }
        }
        if(isset($filters['categories'])){
            $filter_nodes = [];
            foreach($filters['categories'] as $category_id){
                $category = Category::find($category_id);
                if($category->level == 3){
                    $filter_nodes[] = $category->id;
                }else{
                    $nodes = Category::where('path',$category->path.str_pad($category->id, 5, '0', STR_PAD_LEFT))->pluck('id')->toArray();
                    $filter_nodes = array_merge($filter_nodes,$nodes);
                }
            }
            $filter_enquiries = array_unique(EnquiryCategory::whereIn('category_id',$filter_nodes)->pluck('enquiry_id')->toArray());
            $enquiries = $enquiries->whereIn($filter_enquiries);
        }
        if(isset($filters['city']) or isset($filters['area'])){
            if(!isset($filters['city'])) $filters['city'] = [];
            if(!isset($filters['area'])) $filters['area'] = [];
            $filter_cities = [];
            $filter_areas = [];
            if(isset($filters['city'])) $filter_cities = EnquiryArea::whereIn('city_id',$filters['city'])->pluck('enquiry_id')->toArray();
            if(isset($filters['area'])) $filter_areas = EnquiryArea::whereIn('area_id',$filters['area'])->pluck('enquiry_id')->toArray();
            $filter_enquiries1 = array_unique(array_merge($filter_cities,$filter_areas));
            $enquiries = $enquiries->whereIn('id',$filter_enquiries1);
        }
        if(isset($filters['request_date']) and isset($filters['request_date']['start']) and isset($filters['request_date']['end'])){
            $end = new Carbon($filters['request_date']['end']);
            $start_date = new Carbon($filters['request_date']['start']);
            $enquiries = $enquiries->where('created_at', '>', $start_date->toDateTimeString())->where('created_at', '<', $end->addDay()->toDateTimeString());
        }
        if(isset($filters['enquiry_type'])){
            if(count($filters['enquiry_type']) == 1){
                if($type=='admin') {
                    $direct = EnquirySent::select('enquiry_id',DB::raw('count(*) as count'))->groupBy('enquiry_id')->having('count',1)->pluck('enquiry_id')->toArray();
                    if($filters['enquiry_type'][0] == 'direct')   $enquiries = $enquiries->whereIn('id',$direct);
                    else $enquiries = $enquiries->whereNotIn('id',$direct);
                }
                else {
                    if($listing_id!=''){
                        $direct = EnquirySent::where('enquiry_type','direct')->pluck('enquiry_id')->toArray();
                        if($filters['enquiry_type'][0] == 'direct')   $enquiries = $enquiries->whereIn('id',$direct);
                        else $enquiries = $enquiries->whereNotIn('id',$direct);
                    }
                }
               
            }
        }
        if(isset($filters['enquirer_type'])){
            if(count($filters['enquirer_type']) == 1){
                if($filters['enquirer_type'][0] == 'user') $enquiries = $enquiries->where('user_object_type','App\\User');
                if($filters['enquirer_type'][0] == 'lead') $enquiries = $enquiries->where('user_object_type','App\\Lead');
            }
        }
        if(isset($filters['enquirer_details'])){
            $enquiries->where(function ($sql) use ($filters) {
                $users = UserDetail::where(function ($sql) use ($filters) {
                    $i=0;
                    foreach ($filters['enquirer_details'] as $detail) {
                        if($i!=0)$sql->orWhere('subtype','like','%'.$detail.'%');
                        else $sql->where('subtype','like','%'.$detail.'%');
                        $i++;
                    }
                })->pluck('user_id')->toArray();
                $leads = Leads::where(function ($sql) use ($filters) {
                    $i=0;
                    foreach ($filters['enquirer_details'] as $detail) {
                        if($i!=0)$sql->orWhere('user_details_meta','like','%'.$detail.'%');
                        else $sql->where('user_details_meta','like','%'.$detail.'%');
                        $i++;
                    }
                })->pluck('id')->toArray();
                $sql->where(function ($sql) use ($users) {
                   $sql->where('user_object_type','App\\User')->whereIn('user_object_id',$users); 
                });
                $sql->orWhere(function ($sql) use ($leads) {
                   $sql->where('user_object_type','App\\Lead')->whereIn('user_object_id',$leads); 
                });       
            });
        }
        if(isset($filters['enquirer_name'])){
            $enquiries->where(function ($sql) use ($filters) {
                $users = User::where('name','like','%'.$filters['enquirer_name'].'%')->pluck('id')->toArray();
                $leads = Lead::where('name','like','%'.$filters['enquirer_name'].'%')->pluck('id')->toArray();
                $sql->where(function ($sql) use ($users) {
                   $sql->where('user_object_type','App\\User')->whereIn('user_object_id',$users); 
                });
                $sql->orWhere(function ($sql) use ($leads) {
                   $sql->where('user_object_type','App\\Lead')->whereIn('user_object_id',$leads); 
                });       
            });
        }
        if(isset($filters['enquirer_email'])){
            $enquiries->where(function ($sql) use ($filters) {
                $users = UserCommunication::where('value','like','%'.$filters['enquirer_email'].'%')->where('is_primary',1)->where('type','email')->where('object_type','App\\User')->pluck('object_id')->toArray();
                $leads = Lead::where('email','like','%'.$filters['enquirer_email'].'%')->pluck('id')->toArray();
                $sql->where(function ($sql) use ($users) {
                   $sql->where('user_object_type','App\\User')->whereIn('user_object_id',$users); 
                });
                $sql->orWhere(function ($sql) use ($leads) {
                   $sql->where('user_object_type','App\\Lead')->whereIn('user_object_id',$leads); 
                });       
            });

        }
        if(isset($filters['enquirer_contact'])){
            $enquiries->where(function ($sql) use ($filters) {
                $phone_no = explode('-',$filters['enquirer_contact']);
                if(count($phone_no)==1){
                    $users = UserCommunication::where(function($sql) use ($phone_no){
                        $sql->where('country_code','like','%'.$phone_no[0].'%')->orWhere('value','like', '%'.$phone_no[0].'%');
                    })->where('is_primary',1)->where('type','mobile')->where('object_type','App\\User')->pluck('object_id')->toArray();
                }else{
                    $users = UserCommunication::where(function($sql) use ($phone_no){
                        $sql->where('country_code','like','%'.$phone_no[0])->where('value','like', $phone_no[1].'%');
                    })->where('is_primary',1)->where('type','mobile')->where('object_type','App\\User')->pluck('object_id')->toArray();
                }
                $leads = Lead::where('mobile','like','%'.$filters['enquirer_contact'].'%')->pluck('id')->toArray();
            
                $sql->where(function ($sql) use ($users) {
                   $sql->where('user_object_type','App\\User')->whereIn('user_object_id',$users); 
                });
                $sql->orWhere(function ($sql) use ($leads) {
                   $sql->where('user_object_type','App\\Lead')->whereIn('user_object_id',$leads); 
                });       
            });
        }
        if(isset($filters['enquiree'])){
            $listings = Listing::where('title','like','%'.$filters['enquiree'].'%')->pluck('id')->toArray();
            $enquiries->whereIn('enquiry_to_id',$listings);
        }
        if(isset($filters['sent_to'])){
            $listings1 = Listing::where('title','like','%'.$filters['sent_to'].'%')->pluck('id')->toArray();
            $enquiry_ids = EnquirySent::whereIn('enquiry_to_id',$listings1)->pluck('enquiry_id')->toArray();
            $enquiries->whereIn('id',$enquiry_ids);
        }
        $enquiries = $enquiries->skip($start)->take($display_limit)->orderBy('created_at',$order);
        $filtered = $enquiries->count();
        $enquiries = $enquiries->get();
    	// dd($enquiries);
    	$response = [];
    	foreach($enquiries as $enquiry){
            $response[$enquiry->id] = [];
            if($type=='admin') {
                if($enquiry->sentTo()->count() > 1) $response[$enquiry->id]['type'] = 'shared';
                else $response[$enquiry->id]['type'] = 'direct';
            }
            else {
                if($listing_id!=''){
                    $response[$enquiry->id]['type'] = $enquiry->sentTo()->where('enquiry_to_id',$listing_id)->first()->enquiry_type;
                }
            }

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
        if($type=='admin') $all = Enquiry::where('enquiry_to_type',get_class($listing))->count();
        else {
            if($listing_id!=''){
                $listing_enquiry = EnquirySent::where('enquiry_to_id',$listing_id)->pluck('enquiry_id')->toArray();
                $all = Enquiry::where('enquiry_to_type',get_class($listing))->whereIn('id',$listing_enquiry)->count();
            }
        }
        return array('draw' => "1", 'sEcho' => 0, "recordsTotal" => $all, "recordsFiltered" => $filtered, 'data' => $response1);
    }
}
