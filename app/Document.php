<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
  public function listing(){
    return $this->belongsTo('App\Listing');
  }
}
