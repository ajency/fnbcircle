<?php

namespace App;

use App\Area;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table    = "cities";
    protected $fillable = ['name'];
    protected $dates    = [
        'created_at',
        'updated_at',
        'published_date',
    ];

    public function areas()
    {
        return $this->hasMany('App\Area');
    }

    public function isPublishable()
    {
        $areas = Area::where('city_id', $this->id)->count();
        if ($areas > 0) {
            return array("response"=>true, "message"=>"");
        } else {
          return array("response"=>false, "message"=>"City has no published areas under it");
        }

    }
    public function isArchivable(){
      $areas = Area::where('city_id', $this->id)->get();
      // dd($areas);
      foreach ($areas as $area) {
        $archieve = $area->isArchivable();
        // dd($archieve);
        if($archieve['response'] == false) return array("response"=>false, "message"=>"Listings are associated with this City");
        # code...
      }
      return array("response"=>true, "message"=>"");
    }

}
