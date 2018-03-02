<?php

namespace App\Seo;

use Illuminate\Database\Eloquent\Model;
use App\Category;
use App\Area;
class ListingListView extends Model
{
    public $state;
    public $currentUrl;
    public $category;
    public $city;
    public $type;
    public $status;

    public function __construct($additionaldata){
        if(isset($additionaldata['urlFilters'])){
            $urlFilters = $additionaldata['urlFilters'];
            $this->urlFilters = $urlFilters;
            if(isset($urlFilters['state'])){
                $state = $urlFilters['state'];
                $this->state = ucwords($state);
            }
            $this->category = "food and beverage ";
            if(isset($urlFilters['category'])) $this->setCategoryFromFilter($urlFilters['category']);
            $this->status = "";
            if(isset($urlFilters['listing_status'])) $this->setStatusFromFilter($urlFilters['listing_status']);
            $this->type = "suppliers ";
            if(isset($urlFilters['business_type'])) $this->setTypeFromFilter($urlFilters['business_type']);
            $this->city = $this->state.' ';
            if(isset($urlFilters['areas_selected'])) $this->setCityFromFilter($urlFilters['areas_selected']);
        }
        if(isset($additionaldata['currentUrl'])){
            $currentUrl = $additionaldata['currentUrl'];
            $this->currentUrl = $currentUrl;
        }
    }

    public function setCategoryFromFilter($categ_filter){
        if(isset($categ_filter['slug']) and $categ_filter['slug'] != '' ){
            $this->category = Category::where('slug',$categ_filter['slug'])->pluck('name')->first();
            if($this->category == '' or $this->category == null) $this->category = 'food and beverage';
            $this->category .= ' ';
        }else{
            $this->category = 'food and beverage ';
        }
    }
    public function setStatusFromFilter($status_filter){
        if(isset($status_filter[0])) $this->status = ucfirst($$status_filter[0]);
        else{ 
            $this->status = "";
            return;
        }
        if(isset($status_filter[1])) $this->status .= " and ".ucfirst($$status_filter[1]);
        $this->status .= ' ';
    }

    public function setTypeFromFilter($type_filter){
        if(empty($type_filter)){
            $this->type = "suppliers ";
            return;
        }
        foreach ($type_filter as &$value) {
            $value= ucwords(str_replace('-', ' ', $value));
        }
        $this->type = implode(', ', $type_filter).' ';
    }

    public function setCityFromFilter($area_filter){
        $areas = Area::whereIn('slug',$area_filter)->pluck('name')->toArray();
        if(empty($areas) or $areas == null){
            $this->city = $this->state.' ';
            return;
        }
        $this->city = implode(', ', $areas).' ';
    }

    public function getMetaData(){

    	$ogTag = [];
    	$ogTag['title'] =  $this->getTitle();
    	$ogTag['description'] =  $this->getDescription();
    	$ogTag['image'] =  $this->getImageUrl();
    	$ogTag['url'] =  $this->getPageUrl();
    	$ogTag['type'] =  $this->getOgType();
    	$ogTag['site_name'] =  $this->getSiteName();

    	$twitterTag = [];
    	$twitterTag['card'] =  $this->twitterCard();
    	$twitterTag['site'] =  $this->twitterHandle();
    	$twitterTag['creator'] =  $this->getImageUrl();
    	$twitterTag['title'] =  $this->getTitle();
    	$twitterTag['description'] =  $this->getDescription();
    	$twitterTag['image'] =  $this->getImageUrl();
    	$twitterTag['image_alt'] =  $this->getImageUrl();
    	$twitterTag['url'] =  $this->getPageUrl();

    	$itemPropTag = [];
    	$itemPropTag['name'] =  $this->getTitle();
    	$itemPropTag['description'] =  $this->getDescription();
    	$itemPropTag['image'] =  $this->getImageUrl();
    	$itemPropTag['url'] =  $this->getPageUrl();

    	$tags = [];
        $tags['title'] =  $this->getTitle();
    	$tags['keywords'] =  $this->getKeywords();
    	$tags['description'] =  $this->getDescription();

        $page = [];
        $page['title'] =  $this->getTitle();

 		

 		return ['ogTag'=>$ogTag,'twitterTag'=>$twitterTag,'itemPropTag'=>$itemPropTag,'tags'=>$tags,'page'=>$page];

    }


    public function getTitle(){
        $filters = $this->urlFilters;
        $title = 'List of best '.$this->status.''.$this->category.''.$this->type.'for the hospitality industry in '.$this->city;
        $title .= ' | Fnb Circle ';
    	return $title;
    } 

    public function getDescription(){
    	$filters = $this->urlFilters;
        $desc = 'Find a directory of best '.$this->status.''.$this->category.''.$this->type.' in '.$this->city.'only on FnB Circle. We give you a complete list of the nearest '.$this->type.'in the hospitality industry for '.$this->category.'businesses.';
        return $desc;
    }

    public function getKeywords(){
        $filters = $this->urlFilters;
        $keywords = 'Best '.$this->status.'food and beverage vendors in '.$this->state.', Top food and beverage suppliers in '.$this->state.', Find best '.$this->status.'retailers, Maps for top suppliers in '.$this->state.' on FnB Circle, '.$this->status.' Food and beverages distribution in '.$this->state.', Food products manufacturers in '.$this->state.', List of top '.$this->status.'beverages companies in '.$this->state.', food and beverage products, '.$this->status.'food and beverage products distributors, food and beverage products vendors, list of top '.$this->status.'food and beverage suppliers in '.$this->state.', list of top food and beverage distributors in '.$this->state.'';
        if($this->category != "food and beverage "){
            $keywords .= ', Best '.$this->category.'vendors in '.$this->state.', Top '.$this->category.'suppliers in '.$this->state.', Find best retailers, Maps for top suppliers in '.$this->state.' on FnB Circle, '.$this->category.'distribution in '.$this->state.', Food products manufacturers in '.$this->state.', List of top beverages companies in '.$this->state.', '.$this->category.'products, '.$this->category.'products distributors, '.$this->category.'products vendors, list of top '.$this->category.'suppliers in '.$this->state.', list of top '.$this->category.'distributors in '.$this->state.', Best '.$this->category.'vendors in '.$this->state.', Wholesale distributors of '.$this->category.'in '.$this->state.'';
        }
        if($this->city != $this->state.' '){
            $areas = Area::whereIn('slug',$filters['areas_selected'])->pluck('name','slug')->toArray();
            foreach ($filters['areas_selected'] as $value) {
                $area = $areas[$value];
                $keywords .= ', Best food and beverage vendors in '.$area.', Top food and beverage suppliers in '.$area.', Find best retailers, Maps for top suppliers in '.$area.' on FnB Circle, Food and beverages distribution in '.$area.', Food products manufacturers in '.$area.', List of top beverages companies in '.$area.', food and beverage products, food and beverage products distributors, food and beverage products vendors, list of top food and beverage suppliers in '.$area.', list of top food and beverage distributors in '.$area.'';
            }
        }
        if($this->type != "suppliers "){
            foreach ($filters['business_type'] as &$value) {
                $value= ucwords(str_replace('-', ' ', $value));
                $keywords .= ', Best food and beverage '.$value.' in '.$this->state.', Top food and beverage '.$value.' in '.$this->state.', Find best '.$value.', Maps for top '.$value.' in '.$this->state.' on FnB Circle, Food products '.$value.' in '.$this->state.',   food and beverage products '.$value.', list of top food and beverage '.$value.' in '.$this->state.', list of top food and beverage '.$value.' in '.$this->state.'';
            }
        }
        if($this->type != "suppliers " and $this->category != "food and beverage "){
            $keywords .= ', list of top '.$this->status.''.$this->category.''.$this->type.'in '.$this->city;
        }
    	return $keywords;
    }

    public function getImageUrl(){
    	return url('img/logo-fnb.png');
    }

    public function getPageUrl(){
    	return $this->currentUrl;
    }

    public function getOgType(){
    	return 'website';
    }

    public function getSiteName(){
    	return 'fnbcircle';
    }

    public function twitterHandle(){
    	return '@fnbcircle';
    }

    public function twitterCard(){
    	return '@fnbcircle';
    }

    public function getBreadcrum(){
 
    	$breadcrumbs = [];
        $breadcrumbs[] = ['url'=>url('/'), 'name'=>"Home"];
        $breadcrumbs[] = ['url'=>url($this->state.'/job-listings?state='.$this->state), 'name'=>  $this->state];
        if(!$this->category)
            $breadcrumbs[] = ['url'=>'', 'name'=> 'All Jobs In '.ucwords($this->state)];
        else{
            $breadcrumbs[] = ['url'=>'', 'name'=> 'Jobs for '.$this->category];
        }

        return $breadcrumbs;
    }

    
}
