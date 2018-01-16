<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EnquiryArea extends Model {
    protected $fillable = ['enquiry_id', 'area_id', 'city_id'];

    public function area(){
    	return $this->hasOne('App\Area','id', 'area_id');
    }
    public function city(){
    	return $this->hasOne('App\City','id', 'city_id');
    }
}
