<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
	protected $table='areas';
	protected $dates = [
        'created_at',
        'updated_at',
        'published_date'
    ];
  public function city(){
    return $this->belongsTo('App\City', 'city_id');
  }
  public function listings(){
    return $this->hasMany('App\Listing')->using('App\ListingAreasOfOperation');
  }
}
