<?php

namespace App\Seo;

use Illuminate\Database\Eloquent\Model;
use App\Category;
use App\Area;
class JobListView extends Model
{
    public $state;
    public $urlFilters;
    public $currentUrl;
    public $job;
    public $category;

    public function __construct($additionaldata){
        
        $this->category = null;
        if(isset($additionaldata['city'])){
            
        }

        if(isset($additionaldata['urlFilters'])){
            $urlFilters = $additionaldata['urlFilters'];
            $this->urlFilters = $urlFilters;

            if(isset($urlFilters['category_name']))
                $this->category = breadCrumbText($urlFilters['category_name']);

            $state = $urlFilters['state'];
                $this->state = ucwords($state);
        }
 
        if(isset($additionaldata['currentUrl'])){
            $currentUrl = $additionaldata['currentUrl'];
            $this->currentUrl = $currentUrl;
        }
 
        if(isset($additionaldata['job']))
            $this->job = $additionaldata['job'];
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

    public function getStateFilterText(){
        $text = 'Best matching hospitality job vacancies in '.$this->state;

        return $text;
    }

    public function getJobNameFilterText($filters){
        $text = '';
        if(isset($filters['job_name'])){
            $text = $filters['job_name'] .' | ';
        }

        return $text;
    }

    public function getCategoryFilterText($filters){
        $text = '';
        if(isset($filters['category_name'])){
            $text = ' | Job openings for '.$filters['category_name'];
        }

        return $text;
    }

    public function getKeywordsFilterText($filters){
        $text = '';
        if(isset($filters['keywords'])){
            $text = ' | Job roles in '. implode(',', $filters['keywords']);
        }

        return $text;
    }

    public function getTitle(){
        $filters = $this->urlFilters;
        // dd($filters);
        if(isset($filters['job_roles'])){

            $title = 'Top '.implode(', ', $filters['job_roles']).' job openings in '.$this->state;
            if(isset($filters['experience']) and $filters['experience'][0] == '0-1'){
                $title = 'Job vacancies for freshers for '.implode(', ', $filters['job_roles']).' in '.$this->state;
            }
        }elseif (isset($filters['job_type'])) {
            foreach ($filters['job_type'] as &$value) {
                $value = ucwords(str_replace('-', ' ', $value));
            }
            $title = "Top ".implode(', ',$filters['job_type']).' job vacancies in '.$this->state;
            if(isset($filters['business_type'])){
                $categories = Category::where('type','job')->pluck('name','slug')->toArray();
                $title = "Top ".implode(', ',$filters['job_type']).' job vacancies in '.$categories[$filters['business_type']].' in '.$this->state;
            }
        }elseif(isset($filters['area'])){
            $areas = Area::where('status','1')->pluck('name','slug')->toArray();
            foreach ($filters['area'] as &$value) {
                $value = $areas[$value];
            }
            $title = 'Best matching hospitality job vacancies in '.implode(', ', $filters['area']);
        }elseif(isset($filters['business_type'])){
            $categories = Category::where('type','job')->pluck('name','slug')->toArray();
            $title = 'Best Matching Jobs for '.$categories[$filters['business_type']].' in '.$this->state;
        }elseif(isset($filters['experience']) and $filters['experience'][0] == '0-1'){
            $title = 'Job vacancies for freshers in '.$this->state;
        }else{
            $title = $this->getStateFilterText();
        }
        // $title = $this->getJobNameFilterText($filters); 
        // $title .= $this->getStateFilterText(); 
        // $title .= $this->getCategoryFilterText($filters);
        // $title .= $this->getKeywordsFilterText($filters);
        $title .= ' | Fnb Circle ';
    	return $title;
    } 

    public function getDescription(){
    	$filters = $this->urlFilters;
        if(isset($filters['area']) and isset($filters['job_roles']) and isset($filters['job_type'])){
            $areas = Area::where('status','1')->pluck('name','slug')->toArray();
            foreach ($filters['area'] as &$value) {
                $value = $areas[$value];
            }
            $desc = 'Find jobs in '.implode(', ', $filters['area']).' that best match your skills and your personality. FnB Circle lists job openings in '.implode(', ', $filters['area']).' - '.$this->state.' for '.implode(', ', $filters['job_type']).' vacancies in '.implode(', ', $filters['job_roles']).'. View and apply online.';
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
        if(isset($filters['area'])){
            $areas = Area::where('status','1')->pluck('name','slug')->toArray();
            foreach ($filters['area'] as &$value) {
                $value = $areas[$value];
                $keywords .= ', Hotel and restaurant jobs in '.$value.', Restaurant staff, wait staff required in '.$value.', Openings for Cleaning Jobs in '.$value.', Job vacancies for housekeeping staff in '.$value.', Apply for hospitality jobs in '.$value.' online, Apply for hospitality jobs in '.$value.' online, Best matching jobs in '.$value.', Jobs in '.$value.', Careers in '.$value.', Latest available jobs in '.$value.', Job vacancies in '.$value.', Job openings in '.$value.', '.$value.' job openings, Private jobs in '.$value.', Job search '.$value.', Best jobs in '.$value.', Job in '.$value.' hotel';   
            } 
        }
        if(isset($filters['business_type'])){
                $categories = Category::where('type','job')->pluck('name','slug')->toArray();
                $keywords .= ', Jobs for '.$categories[$filters['business_type']].'in '.$this->state;    
           
        }
        if(isset($filters['job_roles'])){
           foreach ($filters['job_roles'] as $key => $value) {
                $keywords .= ', Job vacancies for '.$value.' in '.$this->state;
                $keywords .= ', Hot jobs in '.$this->state.' for '.$value.'s';
           }
        }
        if(isset($filters['job_type'])){
           foreach ($filters['job_type'] as $key => $value) {
                $value = ucwords(str_replace('-', ' ', $value));
                $keywords .= ', '.$value.' jobs in '.$this->state;
           }
        }
        if(isset($filters['experience']) and $filters['experience'][0] == '0-1'){
            $keywords .= ', Job vacancies for freshers in '.$this->state;
            $keywords .= ', Job vacancies for freshers';
            $keywords .= ', Entry-level jobs in '.$this->state;
            if(isset($filters['job_roles'])){
                foreach ($filters['job_roles'] as $key => $value) {
                    $keywords .= ', Job vacancies for freshers for '.$value.' in '.$this->state;
                    $keywords .= ', Entry-level jobs for '.$value.' in '.$this->state;
                }
            }
        }
        if(isset($filters['keywords']))
           $keywords .= ','. implode(',', $filters['keywords']);

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

    /**
	will return array of ld-json data required on page
    */
    public function getLdJson(){
    	$ldJson['job_posting'] = $this->jobPostingLdJson();

    	return $ldJson;
    }

 
    public function jobPostingLdJson(){
    	$jobExperience =  $this->job->getJobExperience();
    	$cities = $this->job->getJobLocationNames('city');
    	$jobCompany = $this->job->getJobCompany();


    	$organizationData['@type'] = "Organization";
    	if(!empty($jobCompany->website)){
    		$organizationData['url'] = $jobCompany->website;
    	}
    	$organizationData['name'] = $jobCompany->title;


    	$data['@context'] = 'http://schema.org';
    	$data['@type'] = 'JobPosting';
    	$data['datePosted'] = $this->job->jobPublishedOn(1);
    	$data['description'] = $this->job->getMetaDescription();

    	if(!empty($jobExperience)){
    		$experienceStr = implode('years, ', $jobExperience);
    		$data['experienceRequirements'] = $experienceStr;
    	}

    	$data['industry'] = $this->job->getJobCategoryName();
    	$data['jobLocation'] = ['@type' => "Place",
    							'address' => ['@type'=> "PostalAddress",
    										  'addressLocality'=> implode(', ', $cities),
    										  'addressRegion'=> 'IN',
    										  'addressCountry'=> 'IN',
    										]
    							];
    	$data['hiringOrganization'] = $organizationData;
    	$data['occupationalCategory'] = $this->job->getJobCategoryName();
    	$data['skills'] = $this->job->getAllJobKeywords();
    	$data['title'] = $this->job->title;

    	return $data;
    }
}
