<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Defaults;

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
    	$experience = ['1 - 2','3 - 4','5 - 8'];
    	 
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

	public function company() {
        return $this->belongsTo('App\Company');
    }
}
