<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    //

    public function getUserSubtypes() { // Will return the Key("Referred in DB & Code")-Value("Referred in Template") pair of UserDetail->subtype
    	return [
    		"hospitality" => "Hospitality Business Owner",
    		"professional" => "Working Professional",
    		"vendor" => "Vendor/Supplier/Service provider",
    		"student" => "Student",
    		"enterpreneur" => "Prospective Entrepreneur",
    		"others" => "Others"
    	];
    }

	public function getUser() { 
		return $this->belongsTo('App\User', 'user_id');
	}

    public function userCity() {
        return $this->belongsTo( 'App\City' ,'city');
    }

    public function userArea() {
        return $this->belongsTo( 'App\Area' ,'area');
    }

    public function lastLogin($format=1){
        $date = '';

        if(!empty($this->last_login)){

            if($format==1)
                $date = date('F j, Y', strtotime(str_replace('-','/', $this->last_login)));
            elseif($format==2){
                $dateFormat = date('d-m-Y ~*~ h:i A', strtotime(str_replace('-','/', $this->last_login)));
                $splitDate = explode('~*~', $dateFormat);
                $date = $splitDate[0].'<br>'.$splitDate[1];

            }
            else
                $date = date('d-m-Y h:i A', strtotime(str_replace('-','/', $this->last_login)));

        }

        return $date;
      
    }

    public function getSavedUserSubTypes(){
        $subtype = $this->getUserSubtypes();
        $userSubTypes = unserialize($this->subtype);
        $savedSubTypes = [];
        if(!empty($userSubTypes)){
            foreach ($userSubTypes as $userSubType) {
                $savedSubTypes[$userSubType] = $subtype[$userSubType];
            }
        }
        

        return $savedSubTypes;
    }
}
