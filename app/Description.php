<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Description extends Model
{
     public function users() { 
        return $this->belongsToMany('App\User', 'user_descriptions')->wherePivot('user_type','App\\User')->using('App\UserDescription');
    }

    public function leads() { 
        return $this->belongsToMany('App\Lead', 'user_descriptions')->wherePivot('user_type','App\\Lead')->using('App\UserDescription');
    }

    public static function getID($value = null){
    	$descriptions = self::all();
    	$response = [];
    	foreach ($descriptions as $description) {
    		$response[$description->value]=$description->id;
    		if($description->value == $value) return $description->id;
    	}
    	return $response;
    }
}
