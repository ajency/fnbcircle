<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobLocation extends Model
{
    public $timestamps = false;

    public function city(){
    	return $this->belongsTo('App\City');
    }

    public function area(){
    	return $this->belongsTo('App\Area');
    }
}
