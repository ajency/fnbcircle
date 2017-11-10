<?php

namespace App\Seo;

use Illuminate\Database\Eloquent\Model;
use App\Job;
use Illuminate\Support\Facades\Input;

class JobSingleView extends Model
{
    public $job;

    public function __construct($additionaldata){
    	$job = $additionaldata['job'];
        $this->job = $job;
    }


    public function getMetaData(){

    	$ogTag = [];
    	$ogTag['title'] =  $this->getOgTitle();
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

    public function getOgTitle(){
    	return $this->job->title;
    }

    public function getTitle(){
        return $this->job->getPageTitle();
    } 

    public function getDescription(){
    	return $this->job->getMetaDescription();
    }

    public function getKeywords(){
    	$keywords = 'fnb,fnbcircle,jobs,job,job opening,interview';
    	$keywords .= ','.$this->job->title;
    	$keywords .= ','.$this->job->getJobCategoryName();
    	$keywords .= ','.$this->job->getAllJobKeywords();
    	return $keywords;
    }

    public function getImageUrl(){
    	return $this->job->getSeoImage();
    }

    public function getPageUrl(){
    	return url('job/'.$this->job->slug);
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
    	$jobState = $this->job->getJobSingleState();


    	$breadcrumbs = [];
        $breadcrumbs[] = ['url'=>url('/'), 'name'=>"Home"];
        $breadcrumbs[] = ['url'=>url(getSinglePopularCity()->slug.'/job-listings') .'?state='.getSinglePopularCity()->slug.'&business_type='.$this->job->category->slug, 'name'=> breadCrumbText($this->job->getJobCategoryName()) .' Jobs'];
        $breadcrumbs[] = ['url'=>'', 'name'=> $this->job->title];

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

        if(!empty($jobCompany)){
            $organizationData['@type'] = "Organization";
            if(!empty($jobCompany->website)){
                $organizationData['url'] = $jobCompany->website;
            }
            $organizationData['name'] = $jobCompany->title;
            $data['hiringOrganization'] = $organizationData;
        }
    	


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
    	
    	$data['occupationalCategory'] = $this->job->getJobCategoryName();
    	$data['skills'] = $this->job->getAllJobKeywords();
    	$data['title'] = $this->job->title;

    	return $data;
    }
}
