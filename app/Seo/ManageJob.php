<?php

namespace App\Seo;

use Illuminate\Database\Eloquent\Model;
use App\Job;
use Illuminate\Support\Facades\Input;

class ManageJob extends Model
{
    public $job;

    public function __construct($additionaldata){
    	$job = $additionaldata['job'];
        $this->job = $job;
    }


    public function getMetaData(){

    	 

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
 
        $singViewUrl = ($this->job->id && ($this->job->status==4 || $this->job->status==3)) ? url('job/'.$this->job->slug) : '';

    	$breadcrumbs = [];
        $breadcrumbs[] = ['url'=>url('/'), 'name'=>"Home"];
        if($this->job->id){
            $breadcrumbs[] = ['url'=> $singViewUrl, 'name'=> $this->job->title];
            $breadcrumbs[] = ['url'=>'', 'name'=> 'Edit Job'];
        }
        else{
            $breadcrumbs[] = ['url'=>'', 'name'=> 'Add a Job'];
        }
        

        return $breadcrumbs;
    }

    /**
	will return array of ld-json data required on page
    */
    public function getLdJson(){
    	$ldJson['job_posting'] = '';

    	return $ldJson;
    }

 
    public function jobPostingLdJson(){
    	 
    }
}
