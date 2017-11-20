<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\ListingCommunication;
use App\UserCommunication;
use App\City;
use Spatie\Permission\Traits\HasRoles;
use App\Notifications\CustomResetPassword as ResetPasswordNotification;
use Ajency\FileUpload\FileUpload;

use Ajency\User\Ajency\userauth\UserAuth;

class User extends Authenticatable
{
    use Notifiable, HasRoles, FileUpload;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $dates = ['created_at', 'updated_at', 'last_login' ];

    public static function findUsingEmail($email_id){
        return UserCommunication::where('value', $email_id)->where('type','email')->where('is_primary',1)->where('object_type','App\\User')->first()->object()->first();
    }

    public function listing()
    {
        return $this->hasMany('App\Listing', 'owner_id');
    }
    public function jobs()
    {
        return $this->hasMany('App\Job', 'job_creator');
    }
    public function lastUpdatedListings()
    {
        return $this->hasMany('App\Listing', 'last_updated_by');
    }

	public function getUserDetails() { 
		return $this->hasOne('App\UserDetail', 'user_id');
	}

 
    public function setNameAttribute( $value ) { 
        $this->attributes['name'] = title_case( $value );

    }

    public function setEmailAttribute( $value ) { 
        $this->attributes['email'] = strtolower( $value );

    }

    public function getUserCommunications() { // Get all the communication related to that user
        return $this->hasMany('App\UserCommunication', 'object_id')->where('object_type', 'App\User');
    }

    public function getPrimaryEmail($return_array = false) { // Get the primary Email
        $comm_obj = $this->hasMany('App\UserCommunication', 'object_id')->where([['object_type','App\User'], ['type', 'email'], ['is_primary', true]])->first();
        if($comm_obj) {
            return (!$return_array)? $comm_obj->value : ['email' => $comm_obj->value, 'is_verified' => $comm_obj->is_verified];
        } else {
            return null;
        }
    }

    public function applications()
    {
        return $this->hasMany('App\JobApplicant');
    }

    public function jobApplications()
    {
        $applications = $this->applications()->get(); 
        $jobs = [];
        foreach ($applications as $key => $application) {
            $job = $application->job;
            $job['application'] = $application;
            $jobs[] = $job;
        }
        return collect($jobs);
    }

    public function jobPosted()
    {
        return $this->hasMany('App\Job','job_creator');
    }

    public function getPrimaryContact() { // Get the Primary Contact No
        $comm_obj = $this->hasMany('App\UserCommunication', 'object_id')->where([['object_type','App\User'], ['is_primary', true]])->whereIn('type', ["telephone", "mobile"])->first();
        if ($comm_obj) {
            //return $comm_obj->value;
            return array("contact_region" => $comm_obj->country_code, "contact" => $comm_obj->value, "is_verified" => $comm_obj->is_verified);
        } else {
            $comm_obj = $this->hasMany('App\UserCommunication', 'object_id')->where([['object_type','App\User']])->whereIn('type', ["telephone", "mobile"])->first();
            if ($comm_obj) {
                return array("contact_region" => $comm_obj->country_code, "contact" => $comm_obj->value, "is_verified" => $comm_obj->is_verified);
            } else {
                return null;
            }
        }
    }

    public function saveContactDetails($data,$type){
       
        if($type=='listing'){
            if ($data['id'] == null) {
                $object = new ListingCommunication;
            } else {
                $object = ListingCommunication::findorFail($data['id']);
            }
            $object->value              =  $data['value'] ;
            $object->communication_type = $data['type'];
            $object->save();
        }
        else{

            if ($data['id'] == null) {
                $object = new UserCommunication;
            } else {
                $object = UserCommunication::find($data['id']);

                if($data['contact_value'] == ""){
                    $object->delete();
                }
            }

            if($data['contact_value'] != ""){
                $countryCode = (isset($data['country_code'])) ? $data['country_code'] : '';
                $object->object_type  =  $data['object_type'] ;

                if(!isset($data['action']))
                    $object->object_id  =  $data['object_id'] ;

                $object->value  =  $data['contact_value'] ;
                $object->type  =  $data['contact_type'] ;
                $object->is_primary = 0;
                $object->is_communication = 1;
                $object->is_visible = $data['is_visible'] ;

                if(($data['contact_type'] == 'mobile' || $data['contact_type'] == 'landline') && $countryCode!="")
                    $object->country_code = $countryCode;

                $object->save();
            }
            

        }

        return $object;
    }

    /**
    * This function is used to return the list of User Account Status
    *
    * @return array
    */
    public static function userStatuses() {
        return  ["active" => "Active", "inactive" => "Inactive", "suspended" => "Suspended"];
    }

 
 
    public Function uploadUserResume($file){
        $id = $this->uploadFile($file,false);
        $this->remapFiles([$id]);

         return $id;
    }

    public function getUserProfileDetails(){
        $user = $this;
        // $userDetails = $userAuth->getUserData($this);
       
        $user['email'] = '';
        $user['city'] = '';
        $user['phone'] = '';
     
        if((!empty($this->getUserDetails()->first())) && !empty($this->getUserDetails()->first()->city)){
            $city = $this->getUserDetails()->first()->city;
            $user['city'] = $city;
        }

        if((!empty($this->getUserCommunications()->where('type','mobile')->first()->value))){
            $mobile = $this->getUserCommunications()->where('type','mobile')->first();
            $user['phone'] = $mobile->value;
            $user['phone_code'] = $mobile->country_code;
        }

        if((!empty($this->getUserCommunications()->where('type','email')->first()->value))){
            $email = $this->getUserCommunications()->where('type','email')->first()->value;
            $user['email'] = $email;
        }
       
        return $user;
    }

     


    public Function getUserResume(){
        $userResumeUrl  ='';
        $userResume = $this->getFiles(); 
        foreach ($userResume as $key => $resume) {
            $url = $resume['url'];
        }
        return $url;

    }

    public function getUserJobLastApplication(){
         
        $userDetails = $this->getUserDetails;
        $resumeId = $userDetails->resume_id;
        $lastUpdated = $userDetails->resumeUpdated();

        $application['resume_id'] = $resumeId;
        $application['resume_url'] = getUploadFileUrl($resumeId);
        $application['resume_updated_on'] = $lastUpdated;

        return $application;
    }

 
    public function userCreated($format=1){
        $date = '';

        if(!empty($this->created_at)){

            if($format==1)
                $date = date('F j, Y', strtotime(str_replace('-','/', $this->created_at)));
            elseif($format==2){
                $dateFormat = date('d-m-Y ~*~ h:i A', strtotime(str_replace('-','/', $this->created_at)));
                $splitDate = explode('~*~', $dateFormat);
                $date = $splitDate[0].'<br>'.$splitDate[1];

            }
            else
                $date = date('d-m-Y h:i A', strtotime(str_replace('-','/', $this->created_at)));

        }

        return $date;
      
    }
 
    /* Refer Illuminate\Auth\Passwords\CanResetPassword.php */
    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token) {
        $this->notify(new ResetPasswordNotification($token));
    }
}
