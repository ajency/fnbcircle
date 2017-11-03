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
}
