<?php

namespace App;

use App\City;
use App\Listing;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $table = 'areas';
    protected $dates = [
        'created_at',
        'updated_at',
        'published_date',
    ];
    public function city()
    {
        return $this->belongsTo('App\City', 'city_id');
    }
    public function listings()
    {
        return $this->hasMany('App\Listing', 'locality_id');
    }
    public function siblingCount()
    {
        return Area::where('city_id', $this->city_id)->where('id', '!=', $this->id)->where('status', '1')->count();
    }
    public function getHirarchyAttribute(){
        $city = $this->city;
        return $city->name.">>".$this->name;
    }

    public function isArchivable()
    {
        $listings = Listing::where('locality_id', $this->id)->count();
        // dd($listings);
        if ($listings == "0") {
            return array("response" => true, "message" => "");
        } else {
            return array("response" => false, "message" => "This area has listings associated with it. Click here to view the listings.<br>You can archive this area only once this is removed from all the listings.");
        }

    }
    public function archieve()
    {
        $perm = $this->isArchivable();
        if ($perm['response']) {
            $this->status = 2;
            $this->save();
            if ($this->siblingCount() == 0) {
                $city         = City::find($this->city_id);
                $city->status = 2;
                $city->save();
            }
            return true;
        } else {
            return false;
        }
    }
}
