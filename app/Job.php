<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Defaults;
use App\Area;
use App\Company;
use App\Category;
use App\UserCommunication;
use Auth;

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

    public function getTitleAttribute( $value ) { 
        $value = ucwords( $value );      
        return $value;
    }

    public function jobStatuses(){
    	// $status = ['1'=>'Draft','2'=>'In review','3'=>'Published','4'=>'Archived'];
    	$statuses =  getDefaultValues("job_status",2);

    	return $statuses;
    }

    public function jobCategories(){
        // $status = ['1'=>'Draft','2'=>'In review','3'=>'Published','4'=>'Archived'];
        $jobCategories = Category::where("type","job")->get();

        $categories = [];
        $others = [];
        foreach ($jobCategories as $key => $jobCategory) {
            $categoryName = strtolower($jobCategory->name);
            if($categoryName == 'other')
                $others[$jobCategory->id] = ucwords($jobCategory->name);
            else
                $categories[$jobCategory->id] = ucwords($jobCategory->name);
        }
        $categories = $categories+$others;
        return $categories;
    }

    public function getJobCategoryName(){ 
        $categoryName = strtolower($this->category->name);
        return ucwords($categoryName);
    }

    public function getJobStatus(){
        $jobStatus = Defaults::find($this->status);
        $jobStatus = strtolower($jobStatus->label);
        return ucwords($jobStatus);
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

        $jobTypes = (!empty($jobTypeIds)) ? $this->jobTypes($jobTypeIds) :[];
         
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
    	$types =  getDefaultValues("salary_type",2);  

    	return $types;
    }

    public function jobKeywords(){
        
        $keywords = getDefaultValues("job_keyword",2);
        
        return $keywords;
    }

    public function getSalaryType(){
        $salaryType = Defaults::find($this->salary_type);
        return ucwords($salaryType->label);
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

    public function getMetaDescription(){
       if(!empty($this->description)){            

        return strip_tags(trim($this->description));

        }else{
            return '';
        } 
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

    public function  getJobLocationNames($getData='all'){
        $locations = $this->hasLocations()->get()->toArray(); 
        $savedLocation = [];
        $cityNames = [] ;
        $areas = [] ;
        $cityId =  $area ='';
        foreach ($locations as $key => $location) {

            if($getData=='city' || $getData=='all'){

                if(!isset($cityNames[$location['city_id']])){
                    $city = City::find($location['city_id'])->name;
                    $cityNames[$location['city_id']] = $city;

                    if($getData=='city')
                        $savedLocation[] = $city;
                }
                else
                    $city = $cityNames[$location['city_id']];

                
            }
            
            if($getData=='area' || $getData=='all'){
                if(!isset($areas[$location['area_id']])){
                    $area = Area::find($location['area_id'])->name;
                    $areas[$location['area_id']] = $area;

                    if($getData=='area')
                        $savedLocation[] = $city;
                }
                else
                    $area = $areas[$location['area_id']];

            }

            if($getData=='all')
                $savedLocation[$city][] = $area;
             
        }

        return $savedLocation;
    }

    public function jobPostedOn(){
        return (!empty($this->date_of_submission)) ? date('F j, Y', strtotime(str_replace('-','/', $this->date_of_submission))): '';
    }

    public function jobPublishedOn(){
        return (!empty($this->published_on)) ? date('F j, Y', strtotime(str_replace('-','/', $this->published_on))) : '';
    }

    public function canEditJob(){
        if(Auth::check() && $this->job_creator == Auth::user()->id)
            return true;
        else
            return false;

    }

    public function isJobVisible(){

        if($this->canEditJob() && $this->isJobDataComplete())
            return true;
        elseif($this->status == 3 || $this->status == 4)
            return true;
        else
            return false;

    }

    public function isPublished(){
     
        if($this->status == 3)
            return true;
        else
            return false;

    }

    public function publishJob(){
        
        $this->status = 3;
        if($this->slug =="")
            $this->slug = $this->getJobSlug();
        $this->save();

        $company = $this->getJobCompany();
        $company->status = 2;
        $company->save();

        return true;

    }

    public function submitForReview(){
     
        if($this->status == 1 && $this->isJobDataComplete())
            return true;
        else
            return false;

    }

    public function isJobDataComplete(){

        if($this->title !="" && $this->description !="" && $this->category_id !="" &&  (isset($this->meta_data['job_keyword']) && !empty($this->meta_data['job_keyword'])) && (!empty($this->hasLocations())) && (!empty($this->getJobCompany()) && $this->getJobCompany()->title !=""))
            return true;
        else
            return false;
    }

    public function getJobSlug(){
        $titleSlug = str_slug($this->title);

        if(empty($this->slug))
            $slug = $titleSlug.'-'.$this->category->slug.'-'.$this->getJobCompany()->slug.'-'.$this->reference_id;
        else
            $slug = $this->slug;

        return  $slug;
    }


    public function getSimilarJobs(){

        //, 'status'=>3  
        $jobs = Job::where(['category_id' => $this->category_id])->where('id', '<>',$this->id)->orderBy('published_on','desc')->get()->take(4);
        return $jobs;
    }

    // private function getFilteredJobs($jobs,$filters){
     
    //     return $jobs;
    // }

    
}
