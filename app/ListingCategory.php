<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ListingCategory extends Model
{
    protected $table = "listing_category";
    protected $primaryKey = ['listing_id', 'category_id'];
    protected $fillable=['listing_id','category_id'];
}
