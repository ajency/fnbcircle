<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ListingCategory;

class Listing extends Model
{
    const PUBLISHED    = 1;
    const REVIEW       = 2;
    const DRAFT        = 3;
    const WHOLESALER   = 11;
    const RETAILER     = 12;
    const MANUFACTURER = 13;

    protected $table = "listings";

    protected $fillable = ['title', 'status', 'type'];

    public function owner()
    {
        return $this->hasOne('App\User', 'owner_id');
    }
    public function createdBy()
    {
        return $this->hasOne('App\User', 'created_by');
    }
    public function location()
    {
        return $this->hasOne('App\Area', 'locality_id');
    }
    public function updates()
    {
        return $this->hasMany('App\Update', 'listing_id');
    }
    public function categories()
    {
        return $this->belongsToMany('App\Category')->using('App\ListingCategory');
    }
    public function operationAreas()
    {
        return $this->belongsToMany('App\Area')->using('App\ListingOperationAreas');
    }
    public function contacts()
    {
        return $this->belongsToMany('App\UserCommunication')->using('App\ListingCommunication')->withPivot('verified');
    }
    public function operationTimings()
    {
        return $this->hasMany('App\ListingTimeOfOperation');
    }
    public function isReviewable()
    {
        if (!empty($this->title) and !empty($this->type) and !empty($this->locality_id)) {
            $category=ListingCategory::where('listing_id',$this->id)->count();
            if($category<1) return false;
            return true;
        } else {
            return false;
        }

    }

    public function saveInformation($title, $type, $email,$area)
    {
        $this->title              = $title;
        $this->type               = $type;
        $this->show_primary_phone = 0;
        $this->show_primary_email = $email;
        $this->locality_id = $area;
        if($this->status == null) $this->status             = self::DRAFT;
        $this->owner_id           = "1";
        if($this->reference == null) $this->reference          = str_random(8);
        if($this->created_by == null)$this->created_by         = "1";
        $this->save();
    }

}
