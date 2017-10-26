<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\ListingCommunication;
use App\UserCommunication;
use App\City;
use Spatie\Permission\Traits\HasRoles;
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

    public function listing()
    {
        return $this->hasMany('App\Listing', 'owner_id');
    }
    public function lastUpdatedListings()
    {
        return $this->hasMany('App\Listing', 'last_updated_by');
    }

	public function getUserDetails() { 
		return $this->hasOne('App\UserDetail', 'user_id');
	}

    public function getUserCommunications() { // Get all the communication related to that user
        return $this->hasMany('App\UserCommunication', 'object_id')->where('object_type', 'App\User');
    }

    public function getPrimaryEmail() { // Get the primary Email
        $comm_obj = $this->hasMany('App\UserCommunication', 'object_id')->where([['object_type','App\User'], ['type', 'email'], ['is_primary', true]])->first();

        if($comm_obj) {
            return $comm_obj->value;
        } else {
            return null;
        }
    }

    public function applications()
    {
        return $this->hasMany('App\JobApplicant');
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
            $user['city'] = City::find($city)->name;
        }

        if((!empty($this->getUserCommunications()->where('type','mobile')->first()->value))){
            $mobile = $this->getUserCommunications()->where('type','mobile')->first()->value;
            $user['phone'] = $mobile;
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
        $application = $this->applications()->orderBy('resume_updated_on','desc')->first(); 
        if(!empty($application))
            $application['resume_url'] = $this->getUserResume();

        return $application;
    }



}
