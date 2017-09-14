<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Defaults;
use App\Area;
use App\Company;

class Job extends Model
{
    public function createdBy() {
        return $this->belongsTo( 'App\User' ,'job_creator');
    }

    public function updatedBy() {
        return $this->belongsTo( 'App\User' ,'job_modifier');
    }

    public function publishedBy() {
        return $this->belongsTo( 'App\User' ,'published_by');
    }

    public function jobStatuses(){
    	// $status = ['1'=>'Draft','2'=>'In review','3'=>'Published','4'=>'Archived'];
    	$jobStatuses = Defaults::where("type","job_status")->get();

    	$statuses = [];
    	foreach ($jobStatuses as $key => $jobStatus) {
    		$statuses[$jobStatus->id] = $jobStatus->label;
    	}

    	return $statuses;
    }

    public function getJobStatus($id){
    	$statuses = $this->jobStatuses();
    	$status = $statuses[$id];
    	return $status;
    }

    public function jobTypes(){
    	// $status = ['1'=>'Part-time','2'=>'Full-time','3'=>'Temporary'];
    	$jobTypes =  Defaults::where("type","job_type")->get();

    	$types = [];
    	foreach ($jobTypes as $key => $jobType) {
    		$types[$jobType->id] = $jobType->label;
    	}

    	return $types;
    }

    public function getJobTypes($id){
    	$jobTypes = $this->getJobTypes();
    	$jobType = $jobTypes[$id];
    	return $jobType;
    }

    public function jobExperience(){
    	$experience = ['1-2','3-4','5-8','8-10'];
    	 
    	return $experience;
    }

    public function getJobExperience($id){
    	$experienceData = $this->jobExperience();
    	$experience = $experienceData[$id];
    	return $experience;
    }

    public function salaryTypes(){
    	$salaryTypes =  Defaults::where("type","salary_type")->get();
    	 
    	$types = [];
    	foreach ($salaryTypes as $key => $salaryType) {
    		$types[$salaryType->id] = $salaryType->label;
    	}

    	return $types;
    }

    public function jobKeywords(){
        $jobKeywords =  Defaults::where("type","job_keyword")->get();
         
        $keywords = [];
        foreach ($jobKeywords as $key => $jobKeyword) {
            $keywords[$jobKeyword->id] = $jobKeyword->label;
        }

        return $keywords;
    }

    public function getSalaryType($id){
    	$salaryTypes = $this->salaryTypes();
    	$salaryType = $salaryTypes[$id];
    	return $salaryType;
    }


    public function getMetaDataAttribute( $value ) { 
		$value = unserialize( $value );
		 
		return $value;
	}

	public function setMetaDataAttribute( $value ) { 
		$this->attributes['meta_data'] = serialize( $value );

	}

	public function hasLocations(){
		return $this->hasMany('App\JobLocation');
	}

	public function hasKeywords(){
		return $this->hasMany('App\JobKeyword');
	}

	public function jobCompany() {
        return $this->hasOne('App\JobCompany');
    }

    public function getJobCompany(){
        $jobCompany = $this->jobCompany()->first();
        $company = null;
        if(!empty($jobCompany)){
 
            $company = $jobCompany->company()->first(); 
        }

        return $company;
    }

    public function  getJobLocation(){
    	$locations = $this->hasLocations()->get()->toArray(); 
    	$savedLocation = [];
    	$areas = [] ;
    	foreach ($locations as $key => $location) {
    		$savedLocation[$location['city_id']][] = $location['area_id'];

			if(!isset($areas[$location['city_id']])){
				$areas[$location['city_id']] = Area::where('status', 1)->where('city_id', $location['city_id'])->orderBy('name')->get()->toArray();
			}
    			
    		 
    	}

    	return ['savedLocation'=>$savedLocation,'areas'=>$areas];
    }
}
