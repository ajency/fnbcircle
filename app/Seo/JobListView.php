<?php

namespace App\Seo;

use Illuminate\Database\Eloquent\Model;

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

            $state = $urlFilters['city'];
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
        $text = 'Jobs in '.$this->state;

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
 
        $title = $this->getJobNameFilterText($filters); 
        $title .= $this->getStateFilterText(); 
        $title .= $this->getCategoryFilterText($filters);
        $title .= $this->getKeywordsFilterText($filters);
        $title .= ' | Fnb Circle ';
    	return $title;
    } 

    public function getDescription(){
    	$filters = $this->urlFilters;
 
        $desc = $this->getJobNameFilterText($filters); 
        $desc .= $this->getStateFilterText(); 
        $desc .= $this->getCategoryFilterText($filters);
        $desc .= $this->getKeywordsFilterText($filters);
        $desc .= ' | Find Latest Job vacancies for Freshers & Experienced across Top Companies. | Fnb Circle ';
        return $desc;
    }

    public function getKeywords(){
        $filters = $this->urlFilters;
    	$keywords = 'fnb,fnbcircle,jobs,job,job opening,interview';
    	$keywords .= ','.$this->getStateFilterText(); 
        if(isset($filters['category_name']))
    	   $keywords .= ','. $filters['category_name'];

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
        $breadcrumbs[] = ['url'=>url($this->state.'/job-listings/'), 'name'=>  $this->state];
        if(!$this->category)
            $breadcrumbs[] = ['url'=>'', 'name'=> 'all Jobs'];
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
