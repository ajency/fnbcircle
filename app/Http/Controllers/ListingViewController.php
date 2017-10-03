<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Listing;
use App\ListingCategory;
use App\Category;
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
    	$pagedata['pagetitle'] = getSingleListingTitle($listing);
    	$area = Area::with('city')->find($listing->locality_id);
    	$pagedata['city'] = array('name'=>$area->city['name'],'url'=>'', 'alt'=>'');
    	$pagedata['title'] = ['name'=>$listing->title,'url'=>url()->current(),'alt'=>''];
        if($listing->status == 1){
            $pagedata['publish_date'] = $listing->published_on->format('jS F Y');
            $pagedata['rating'] = '50';
            $pagedata['views'] = $listing->views_count;
            $pagedata['verified'] = ($listing->verified == 1)? true : false;    
        }
    	
    	$pagedata['type'] = config('tempconfig.listing-type')[$listing->type];
        $pagedata['reference'] = $listing->reference;
    	$pagedata['operationAreas'] = ListingAreasOfOperation::city($listing->id);
        if(count($pagedata['operationAreas']) == 0) unset($pagedata['operationAreas']);
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
        if(count($pagedata['contact']['landline']) == 0) unset($pagedata['contact']['landline']);
    	$pagedata['categories'] = ListingCategory::getCategories($listing->id);
        if(count($pagedata['categories']) != 0){
        	$pagedata['cores'] = [];
        	foreach($pagedata['categories'] as $category){
        		foreach ($category['nodes'] as $node) {
        			if($node['core']=="1") $pagedata['cores'][] = $node;
        		}
        	}
        	$pagedata['brands'] = $listing->tagNames('brands');
        }else{
            unset($pagedata['categories']);
        }
    	$pagedata['highlights'] = json_decode($listing->highlights);
        if($pagedata['highlights'] == null) unset($pagedata['highlights']);
    	$pagedata['description'] = $listing->description;
        if($pagedata['description'] == null) unset($pagedata['description']);
        if($listing->other_details != null){
            $other_details = json_decode($listing->other_details);
            if(isset($other_details->established)) $pagedata['established'] = $other_details->established;
            if(isset($other_details->website)) $pagedata['website'] = $other_details->website;    
        }
        if($listing->show_hours_of_operation != null){
        	$pagedata['showHours'] = $listing->show_hours_of_operation;
        	$pagedata['hours'] = $listing->getHoursofOperation();
        	$pagedata['today'] = $listing->today();
        }
    	$pagedata['address'] = $listing->display_address;
        if($pagedata['address'] == null) unset($pagedata['address']);
    	$pagedata['payments'] = $listing->getPayments();
        if($pagedata['payments'] == null) unset($pagedata['payments']);
    	$pagedata['location'] = [
    		'lat' =>$listing->latitude,
    		'lng' =>$listing->longitude,
    	];
        if($pagedata['location']['lat'] == null or $pagedata['location']['lng'] == null) unset($pagedata['location']);
        $pagedata['images']=[];
        $images = $listing->getImages();
        if(count($images)!= 0){
            $list_photos = json_decode($listing->photos);
            if($list_photos != null) $order = explode(',',$list_photos->order);
            else $order = [];
            foreach($order as $img){
                $pagedata['images'][]=['full'=>$images[$img][config('tempconfig.listing-photo-full')], 'thumb'=>$images[$img][config('tempconfig.listing-photo-thumb')]];
            }    
        }else{
            unset($pagedata['images']);
        }
        $pagedata['files']= $listing->getFiles();
        if(count($pagedata['files']) != 0){
            foreach($pagedata['files'] as &$file){
                if($file['name']=="") $file['name'] = basename($file['url']);
            }
        } else unset($pagedata['files']);
        
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
        $pagedata['browse_categories'] = $this->getPopularParentCategories();
        if(isset($pagedata['highlights']) or isset($pagedata['description']) or isset($pagedata['established']) or isset($pagedata['website']) or isset($pagedata['hours']) or isset($pagedata['address']) or isset($pagedata['location'])) $pagedata['overview'] = true;
    	// dd($pagedata);
    	return view('single-view.listing')->with('data',$pagedata);
    }

    

    private function getPopularParentCategories(){
        $parents = Category::where('type','listing')->where('level','1')->where('status',1)->orderBy('order')->orderBy('name')->take(config('tempconfig.single-view-category-number'))->get();
        $categories = [];
        foreach ($parents as $category) {
            $categories[$category->id] = [
            'id'=>$category->id,
            'name'=>$category->name,
            'slug'=>$category->slug,
            'image'=>$category->icon_url,
            'count' =>count($category->getAssociatedListings()['data']['listings']),
        ];
        }
        return $categories;
    }
}
