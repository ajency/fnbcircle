<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserToken extends Model
{
    protected $table = 'user_token';

    public function users(){
    	return $this->belongsTo('App\User');
    }
}
