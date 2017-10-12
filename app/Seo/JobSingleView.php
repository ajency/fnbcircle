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
    	$tags['keywords'] =  $this->getKeywords();
    	$tags['description'] =  $this->getDescription();

 		

 		return ['ogTag'=>$ogTag,'twitterTag'=>$twitterTag,'itemPropTag'=>$itemPropTag,'tags'=>$tags];

    }

    public function getTitle(){

    	$cities = $this->job->getJobLocationNames('city');
    	$jobCompany = $this->job->getJobCompany();
        $metaData = $this->job->meta_data;
        $jobExperience = (isset($metaData['experience'])) ? $metaData['experience'] :[];

        $experienceStr = (!empty($jobExperience)) ? ' | '. implode(', ', $jobExperience) .' years of experience':''; 
    	return $this->job->title .' | '.implode(', ', $cities).' | '. $jobCompany ->name.' | '. $this->job->getJobCategoryName().$experienceStr.'| Fnb Circle ';
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
    	return url('jobs/'.$this->job->slug);
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
        $breadcrumbs[] = ['url'=>url($jobState.'/job-listings/'), 'name'=> breadCrumbText($this->job->getJobCategoryName()) .' Jobs'];
        $breadcrumbs[] = ['url'=>'', 'name'=> $this->job->title];

        return $breadcrumbs;
    }
}
