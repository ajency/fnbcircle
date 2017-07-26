<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ListingOperationTime extends Model
{
  const MONDAY= 0;
  const TUESDAY= 1;
  const WEDNESDAY= 2;
  const THURSDAY= 3;
  const FRIDAY= 4;
  const SATURDAY= 5;
  const SUNDAY= 6;

  public function listing(){
    return $this->belongsTo('App\Listing');
  }
}
