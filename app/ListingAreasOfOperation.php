<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ListingAreasOfOperation extends Model
{
  public function listing(){
    return $this->belongsTo('App\Listing');
  }
}
