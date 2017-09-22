<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ListingHighlight extends Model
{
    protected $table= 'listing_highlights';
    public function listing(){
      return $this->belongsTo('App\Listing');
    }
}
