<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
  public function city(){
    return $this->belongsTo('App\City', 'city_id');
  }
  public function listings(){
    return $this->hasMany('App\Listing');
  }
}
