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
 
    	// $statuses =  getDefaultValues("job_status",2);
        $statuses = ['1'=>'Draft','2'=>'Pending Review','3'=>'Published','4'=>'Archived','5'=>'Rejected'];
    	return $statuses;
    }

    public function jobStatusesToChange(){
 

        $statuses = ['1'=>'Draft','2'=>'Submit for review','3'=>'Publish','4'=>'Archive','5'=>'Reject'];
        return $statuses;
    }

    public function jobCategories(){
        // $status = ['1'=>'Draft','2'=>'In review','3'=>'Published','4'=>'Archived'];
        $jobCategories = Category::where("type","job")->where('status',1)->orderBy('name')->get();

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
        // $jobStatus = Defaults::find($this->status); 
        // $jobStatus = strtolower($jobStatus->label);
        $jobStatuses = $this->jobStatuses();
        $jobStatus = $jobStatuses[$this->status]; 
        
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

    public function getSalaryTypeShortForm(){
        $salaryType = Defaults::find($this->salary_type);
        return salarayTypeText($salaryType->label);
    }


    public function getInterviewLocationLat() { 
		$value = ($this->interview_location_lat) ? $this->interview_location_lat :"28.7040592";
		 
		return $value;
	}

    public function getInterviewLocationLong() { 
        $value =($this->interview_location_long) ? $this->interview_location_long : "77.10249019999992";
         
        return $value;
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

    public function getSeoImage(){
        $jobCompany = $this->jobCompany()->first();
        $company = null;
        $seoImage = url('img/logo-fnb.png');
        if(!empty($jobCompany)){
            if(($jobCompany->logo))
                $seoImage = $jobCompany->getCompanyLogo('company_logo');
              
        } 

        return $seoImage;
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

    public function jobPostedOn($format=1){
        $date = '';

        if(!empty($this->date_of_submission)){

            if($format==1)
                $date = date('F j, Y', strtotime(str_replace('-','/', $this->date_of_submission)));
            elseif($format==2){
                $dateFormat = date('d-m-Y ~*~ h:i A', strtotime(str_replace('-','/', $this->date_of_submission)));
                $splitDate = explode('~*~', $dateFormat);
                $date = $splitDate[0].'<br>'.$splitDate[1];

            }
            else
                $date = date('d-m-Y h:i A', strtotime(str_replace('-','/', $this->date_of_submission)));

        }

        return $date;
      
    }

    public function setStatusAttribute( $value ) { 

        if($value == 3){
            $this->publishJob();
        }
        
        $this->attributes['status'] = $value; 

    }

    public function jobPublishedOn($format=1){
        $date = '';
        if(!empty($this->published_on)){

            if($format==1)
                $date = date('F j, Y', strtotime(str_replace('-','/', $this->published_on)));
            elseif($format==2){
                $dateFormat = date('d-m-Y ~*~ h:i A', strtotime(str_replace('-','/', $this->date_of_submission)));
                $splitDate = explode('~*~', $dateFormat);
                $date = $splitDate[0].'<br>'.$splitDate[1];

            }
            else
                $date = date('d-m-Y h:i A', strtotime(str_replace('-','/', $this->published_on)));

        }
        return $date;

    }

    public function jobUpdatedOn($format=1){
        $date = '';
        if(!empty($this->updated_at)){

            if($format==1)
                $date = date('F j, Y', strtotime(str_replace('-','/', $this->updated_at)));
            elseif($format==2){
                $dateFormat = date('d-m-Y ~*~ h:i A', strtotime(str_replace('-','/', $this->date_of_submission)));
                $splitDate = explode('~*~', $dateFormat);
                $date = $splitDate[0].'<br>'.$splitDate[1];

            }
            else
                $date = date('d-m-Y h:i A', strtotime(str_replace('-','/', $this->updated_at)));

        }
        return $date;

    }

    public function canEditJob(){
        if(isAdmin() || (Auth::check() && $this->job_creator == Auth::user()->id))
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
            $this->published_on = date('Y-m-d H:i:');
            $this->published_by = Auth::user()->id;
        $this->save();

        if(!empty($this->getJobCompany())){
            $company = $this->getJobCompany();
            $company->status = 2;
            $company->save();
        }
        

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
        $companySlug = (!empty($this->getJobCompany())) ? $this->getJobCompany()->slug :'';

        if(empty($this->slug))
            $slug = $titleSlug.'-'.$this->category->slug.'-'.$companySlug.'-'.$this->reference_id;
        else
            $slug = $this->slug;

        return  $slug;
    }


    public function getSimilarJobs(){

        //, 'status'=>3  
        $jobs = Job::where(['category_id' => $this->category_id])->where('id', '<>',$this->id)->where('status', 3)->orderBy('published_on','desc')->get()->take(4);
        return $jobs;
    }


    public function jobAvailabeStatus(){
        if(isAdmin()){
            $status[1] = [2]; 
            $status[2] = [3,5];
            $status[3] = [4]; 
            $status[4] = [3]; 
            $status[5] = [2]; 
        }
        else{
            $status[1] = [2]; 
            $status[2] = []; 
            $status[3] = [4]; 
            $status[4] = [3]; 
        }
 
        return $status;
        
    }

    public function jobChangeStatus(){
        if(isAdmin()){
            $status[1] = 2; 
            $status[2] = 3;
            $status[3] = 4; 
            $status[4] = 3; 
            $status[5] = 2; 
        }
        else{
            $status[1] = 2; 
            $status[3] = 4; 
            $status[4] = 3; 
            $status[5] = 2; 
        }
 
        return $status;
        
    }

   public function getNextActionButton(){
        $statusChange = $this->jobChangeStatus();
        $status = $this->status;

        if(isset($statusChange[$status]) && $status>2){
            $statusToChangeId = $statusChange[$status];
            $jobStatusesToChange = $this->jobStatusesToChange();
            $statusToChange = ucwords($jobStatusesToChange[$statusToChangeId]);

            return ['id'=>$statusToChangeId,'status'=>$statusToChange];
        }
        else
          return false;  
        


   }

    
}
