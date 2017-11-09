<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserCommunication extends Model
{
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'object_id', 'object_type', 'type', 'value', 'country_code', 'is_primary' 'is_communication', 'is_verified', 'is_visible',
    ];

	public function object(){
		return $this->morphTo();
	}

    function getUser() {
    	return $this->belongsTo('App\User', 'object_id')->where('object_type', "App\User");
    }
}
