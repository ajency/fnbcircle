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
        $title = 'List of best '.$this->status.''.$this->category.''.$this->type.' for the hospitality industry in '.$this->city;
        $title .= ' | Fnb Circle ';
    	return $title;
    } 

    public function getDescription(){
    	$filters = $this->urlFilters;
        if(isset($filters['area']) and isset($filters['job_roles']) and isset($filters['job_type'])){
            
            $desc = 'Find jobs in '.implode(', ', $filters['area']).' that best match your skills and your personality. FnB Circle lists '.implode(', ', $filters['job_type']).' job openings for '.implode(', ', $filters['area']).' in '.$this->state.'. View and apply online.';
        }else{
            $desc = 'Find jobs in '.$this->state.' that best match your skills and your personality. FnB Circle lists job openings for vacancies in hotels and restaurants. View and apply online.';
        }
        // $desc = $this->getJobNameFilterText($filters); 
        // $desc .= $this->getStateFilterText(); 
        // $desc .= $this->getCategoryFilterText($filters);
        // $desc .= $this->getKeywordsFilterText($filters);
        // $desc .= ' | Find Latest Job vacancies for Freshers & Experienced across Top Companies. | Fnb Circle ';
        $desc .= ' | Fnb Circle ';
        return $desc;
    }

    public function getKeywords(){
        $filters = $this->urlFilters;
    	// $keywords = 'fnb,fnbcircle,jobs,job,job opening,interview';
    	// $keywords .= ','.$this->getStateFilterText(); 
     //    if(isset($filters['category_name']))
    	//    $keywords .= ','. $filters['category_name'];
        $keywords = 'Hotel and restaurant jobs in '.$this->state.', Restaurant staff, wait staff required in '.$this->state.', Openings for Cleaning Jobs in '.$this->state.', Job vacancies for housekeeping staff in '.$this->state.', Apply for hospitality jobs in '.$this->state.' online, Best matching jobs in '.$this->state.', Jobs in '.$this->state.', Careers in '.$this->state.', Latest available jobs in '.$this->state.', Job vacancies in '.$this->state.', Job openings in '.$this->state.', '.$this->state.' job openings, Private jobs in '.$this->state.', Job search '.$this->state.', Best jobs in '.$this->state.', Job in '.$this->state.' hotel';
        
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
