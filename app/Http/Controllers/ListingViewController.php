<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Listing;
use App\ListingCategory;
use App\Area;
use App\ListingAreasOfOperation;
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

    	$pagedata['']

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
