<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Defaults;
use App\Area;
use App\Company;
use App\Category;
use App\UserCommunication;

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

    public function category() {
        return $this->belongsTo( 'App\Category');
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

    public function jobCategories(){
        // $status = ['1'=>'Draft','2'=>'In review','3'=>'Published','4'=>'Archived'];
        $jobCategories = Category::where("type","job")->get();

        $categories = [];
        $others = [];
        foreach ($jobCategories as $key => $jobCategory) {
            if(strtolower($jobCategory->name) == 'other')
                $others[$jobCategory->id] = $jobCategory->name;
            else
                $categories[$jobCategory->id] = $jobCategory->name;
        }
        $categories = $categories+$others;
        return $categories;
    }

    public function getJobCategoryName(){ 
        return ucwords($this->category->name);
    }

    public function getJobStatus(){
        $jobStatus = Defaults::find($this->status);
    	return ucwords($jobStatus->label);
    }

    public function jobTypes($jobTypeIds = []){
    	// $status = ['1'=>'Part-time','2'=>'Full-time','3'=>'Temporary'];
    	$jobTypeQry =  Defaults::where("type","job_type");

        if(!empty($jobTypeIds)){
            $jobTypeQry->whereIn("id",$jobTypeIds);
        }

        $jobTypes = $jobTypeQry->get();
        
    	$types = [];
    	foreach ($jobTypes as $key => $jobType) {
    		$types[$jobType->id] = $jobType->label;
    	}

    	return $types;
    }

    public function getJobTypes(){
        $jobMetaData = $this->meta_data;
        $jobTypeIds = (isset($jobMetaData['job_type'])) ? $jobMetaData['job_type'] :[];

        $jobTypes = $this->jobTypes($jobTypeIds);
         
    	return $jobTypes;
    }

    public function jobExperience(){
    	$experience = ['0-1','1-3','3-5','5-7','7-10','10+'];

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

    public function getCompanyContactEmail($id){
        $emails = UserCommunication::where(['object_type'=>'App\Job','object_id'=>$id,'type'=>'email'])->get();
        $companyEmails = [];
        if(!empty($emails)){
            foreach ($emails as $key => $email) {
                $companyEmails[] = ['id'=>$email->id,'email'=>$email->value,'visible'=>$email->is_visible,'verified'=>$email->is_verified];
            }
             
        }

        return $companyEmails;
    }

    public function getCompanyContactMobile($id){
        $mobilenos = UserCommunication::where(['object_type'=>'App\Job','object_id'=>$id,'type'=>'mobile'])->get();
        $companyMobile = [];
        if(!empty($mobilenos)){
            foreach ($mobilenos as $key => $mobileno) {
                $companyMobile[] = ['id'=>$mobileno->id,'mobile'=>$mobileno->value,'visible'=>$mobileno->is_visible,'verified'=>$mobileno->is_verified];
            }
             
        }

        return $companyMobile;
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

    public function  getJobLocationNames(){
        $locations = $this->hasLocations()->get()->toArray(); 
        $savedLocation = [];
        $cityNames = [] ;
        $areas = [] ;
        foreach ($locations as $key => $location) {
            if(!isset($cityNames[$location['city_id']])){
                $city = City::find($location['city_id'])->name;
                $cityNames[$location['city_id']] = $city;
            }
            else
                $city = $cityNames[$location['city_id']];

            if(!isset($areas[$location['area_id']])){
                $area = Area::find($location['area_id'])->name;
                $areas[$location['area_id']] = $area;
            }
            else
                $area = $areas[$location['area_id']];

            $savedLocation[$city][] = $area;
   
        }

        return $savedLocation;
    }
}
