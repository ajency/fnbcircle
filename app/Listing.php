<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Listing extends Model
{
    const PUBLISHED = 1;
    const REVIEW = 2;
    const DRAFT = 3;
    const WHOLESALER = 11;
    const RETAILER = 12;
    const DISTRIBUTER = 13;

    protected $table="listings";

    protected $fillable=['title','status','type'];

    public function owner(){
      return $this->hasOne('App\User','owner_id');
    }
    public function created_by(){
      return $this->hasOne('App\User','created_by');
    }
    public function location(){
      return $this->hasOne('App\Area','locality_id');
    }
    public function updates(){
      return $this->hasMany('App\Update','listing_id');
    }
    public function categories(){
      return $this->belongsToMany('App\Category')->using('App\ListingCategory');
    }
    public function operationAreas(){
      return $this->belongsToMany('App\Area')->using('App\ListingOperationAreas');
    }
    public function contacts(){
      return $this->belongsToMany('App\UserCommunication')->using('App\ListingCommunication')->withPivot('verified');
    }
    public function operationTimings(){
      return $this->hasMany('App\ListingTimeOfOperation');
    }
}
