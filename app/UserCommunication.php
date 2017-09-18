<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserCommunication extends Model
{

    function getUser() {
    	return $this->belongsTo('App\User', 'object_id')->where('object_type', "App\User");
    }
}
