<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobCompany extends Model
{
	public $timestamps = false;
	
    public function company(){
		return $this->belongsTo('App\Company');
	}
}
