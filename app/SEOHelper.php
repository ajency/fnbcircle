<?php

use App\Listing;
use App\Area;
use App\ListingCategory;

/**
* generate facebook tags for a single listing
*
* @param $listing = listing object
* 
*/

function singleListingOgTags($listing_ref){
	$listing = Listing::where('reference',$listing_ref)->firstorfail();
	$ogtags = [];
	$ogtags['url'] = url()->current();
	$ogtags['siteName'] = env('APP_NAME');
	$ogtags['title'] = getSingleListingTitle($listing);
	$photo = json_decode($listing->photos,true);
	if(isset($photo['url'])) $ogtags['image']= $photo['url'];
	$ogtags['description'] = getSingleListingDescription($listing);
	$ogtags['type']='website';
	return $ogtags;

}
function singleListingTags($listing_ref){
	$listing = Listing::where('reference',$listing_ref)->firstorfail();
	$tags = [];
	$tags['description'] = getSingleListingDescription($listing);
	$tags['keywords'] = getSingleListingKeywords($listing);
	return $tags;

}
function singleListingTwitterTags($listing_ref){
	$listing = Listing::where('reference',$listing_ref)->firstorfail();
	$tags = [];
	$tags['description'] = getSingleListingDescription($listing);
	$tags['card'] = 'summary';
	$tags['handle'] = config('tempconfig.twitterHandle');
	$tags['title'] = getSingleListingTitle($listing);
	$photo = json_decode($listing->photos,true);
	if(isset($photo['url'])) $tags['image']= $photo['url'];
	if(isset($photo['url'])) $tags['imageAlt']= $listing->name;
	return $tags;

}

function getSingleListingTitle($listing){
	$title = $listing->title;
	$area = Area::with('city')->find($listing->locality_id);
	// dd($area);
	$title .= ' |';
	$categories = ListingCategory::getCategories($listing->id);
	// dd($categories);
	$temp = [];
	foreach($categories as $category){
		$temp[] = $category['branch'];
	}
	$title .= ' '. implode(',',$temp);
	$listing_type = config('tempconfig.listing-type')[$listing->type];
	$title .= ' '.$listing_type. ' | '.$area->name.', '.$area->city['name'].' | FnBCircle';

	return $title;
}
function getSingleListingDescription($listing){
	$description = $listing->title.' in ';
	$area = Area::with('city')->find($listing->locality_id);
	$description .= $area->name.', '.$area->city['name'].' listed under';
	$categories = ListingCategory::getCategories($listing->id);
	$temp = [];
	foreach($categories as $category){
		$temp[] = $category['branch'];
	}
	$description .= ' '. implode(',',$temp);
	$listing_type = config('tempconfig.listing-type')[$listing->type];
	$description .= ' '.$listing_type.' with Updates, Address, Contact Number, Ratings, Photos, Maps. Visit Fnb Circle for ';
	$description .= $listing->title.', '.$area->name.', '.$area->city['name'];
	return $description;
}

function getSingleListingKeywords($listing){
	$keywords = [];
	$area = Area::with('city')->find($listing->locality_id);
	$keywords[] = $listing->title;
	$keywords[] = $listing->title.' '.$area->city['name'];
	$keywords[] = 'Contact Number';
	$keywords[] = 'Updates';
	$keywords[] = 'Phone Number';
	$keywords[] = 'Address';
	$keywords[] = 'Map';
	$keywords[] = 'Directions';
	$keywords[] = 'Rating';
	$keywords[] = 'Official website Link';
	$keywords[] = 'Working Hours';
	$keywords[] = 'Highlights';
	$keywords[] = 'Photos';
	$keywords[] = 'Catalogue';
	return implode(',', $keywords);
}