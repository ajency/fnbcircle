<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Listing;
use App\ListingCategory;
use App\Area;
use App\ListingAreasOfOperation;
use App\User;
// use App\ListingCategory;
use Carbon\Carbon;

class ListingViewController extends Controller
{
    public function index($city_slug,$listing_slug){
    	$listing = Listing::where('slug',$listing_slug)->firstOrFail();
    	// dd($listing);

    	$pagedata = array();
    	$pagedata['pagetitle'] = $this->getPageTitle($listing);
    	$area = Area::with('city')->find($listing->locality_id);
    	$pagedata['city'] = array('name'=>$area->city['name'],'url'=>'', 'alt'=>'');
    	$pagedata['title'] = ['name'=>$listing->title,'url'=>url()->current(),'alt'=>''];
    	$pagedata['publish_date'] = $listing->published_on->format('jS F Y');
    	$pagedata['rating'] = '50';
    	$pagedata['views'] = $listing->views_count;
    	$pagedata['verified'] = ($listing->verified == 1)? true : false;
    	$pagedata['type'] = config('tempconfig.listing-type')[$listing->type];
    	$pagedata['operationAreas'] = ListingAreasOfOperation::city($listing->id);
    	$pagedata['contact'] = ['email'=>[],'mobile'=> [],'landline'=>[],'requests'=>$listing->contact_request_count];
    	if($listing->show_primary_email) $pagedata['contact']['email'][] = ['value'=>User::find($listing->owner_id)->getPrimaryEmail(), 'verified'=> true, 'type'=>'email'];
    	$contacts = $listing->contacts()->get();
    	foreach($contacts as $contact){
    		if($contact->type=='email'){
    			$pagedata['contact']['email'][] = ['value' => $contact->value, 'verified'=> ($contact->is_verified == 1)? true:false, 'type'=>'email'];
    		}
    		if($contact->type=='mobile'){
    			$pagedata['contact']['mobile'][] = ['value' => $contact->value, 'verified'=> ($contact->is_verified == 1)? true:false, 'type'=>'mobile'];
    		}
    		if($contact->type=='landline'){
    			$pagedata['contact']['landline'][] = ['value' => $contact->value, 'verified'=> ($contact->is_verified == 1)? true:false, 'type'=>'landline'];
    		}
    		
    	}
    	$pagedata['categories'] = ListingCategory::getCategories($listing->id);
    	$pagedata['cores'] = [];
    	foreach($pagedata['categories'] as $category){
    		foreach ($category['nodes'] as $node) {
    			if($node['core']=="1") $pagedata['cores'][] = $node;
    		}
    	}
    	$pagedata['brands'] = $listing->tagNames('brands');
    	$pagedata['highlights'] = json_decode($listing->highlights);
    	$pagedata['description'] = $listing->description;
    	$other_details = json_decode($listing->other_details);
    	$pagedata['established'] = $other_details->established;
    	$pagedata['website'] = $other_details->website;
    	$pagedata['showHours'] = $listing->show_hours_of_operation;
    	$pagedata['hours'] = $listing->getHoursofOperation();
    	$pagedata['today'] = $listing->today();
    	$pagedata['address'] = $listing->display_address;
    	$pagedata['payments'] = $listing->getPayments();
    	$pagedata['location'] = [
    		'lat' =>$listing->latitude,
    		'lng' =>$listing->longitude,
    	];
        $pagedata['images']=[];
        $images = $listing->getImages();
        $list_photos = json_decode($listing->photos);
        if($list_photos != null) $order = explode(',',$list_photos->order);
        else $order = [];
        foreach($order as $img){
            $pagedata['images'][]=['full'=>$images[$img][config('tempconfig.listing-photo-full')], 'thumb'=>$images[$img][config('tempconfig.listing-photo-thumb')]];
        }
        $pagedata['files']= $listing->getFiles();
        foreach($pagedata['files'] as &$file){
            if($file['name']=="") $file['name'] = basename($file['url']);
        }
        $pagedata['status']= [];
        if($listing->status=="3") {
            $pagedata['status']['text'] = "";
            $pagedata['status']['status']= 'Draft <i class="fa fa-info-circle text-color m-l-5 draft-status" data-toggle="tooltip" data-placement="top" title="Listing will remain in draft status till submitted for review."></i>';
        }
        elseif($listing->status=="2") {
            $pagedata['status']['text'] = "Your listing is submitted for approval";
            $pagedata['status']['status']= '<i class="fa fa-clock-o text-primary" aria-hidden="true"></i>Pending Approval ';
        }
        elseif($listing->status=="1") {
            $pagedata['status']['text'] = "";
            $pagedata['status']['status']= 'Published ';
        }
        elseif($listing->status=="4"){
            $pagedata['status']['text'] = "";
            $pagedata['status']['status']= 'Archived ';
        }
        elseif($listing->status=="5") {
            $pagedata['status']['text'] = "";
            $pagedata['status']['status']= 'Rejected';
        }
        
    	// dd($pagedata);
    	return view('single-view.listing')->with('data',$pagedata);
    }

    private function getPageTitle($listing){
    	$title = $listing->title;
    	$area = Area::with('city')->find($listing->locality_id);
    	// dd($area);
    	$title .= ' |';
    	$categories = ListingCategory::getCategories($listing->id);
    	// dd($categories);
    	foreach($categories as $category){
    		$title .= ' '.$category['branch'];
    	}
    	$listing_type = config('tempconfig.listing-type')[$listing->type];
    	$title .= ' '.$listing_type. ' | '.$area->name.' '.$area->city['name'].' | FnBCircle';

    	return $title;
    }
}
