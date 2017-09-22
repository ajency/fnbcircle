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
        $areas = Area::where('city_id', $this->id)->where('status','1')->count();
        if ($areas > 0) {
            return array("response"=>true, "message"=>"");
        } else {
          return array("response"=>false, "message"=>"City cannot be published as there is no published area under this city.");
        }

    }
    public function isArchivable(){
      $areas = Area::where('city_id', $this->id)->get();
      // dd($areas);
      foreach ($areas as $area) {
        $archieve = $area->isArchivable();
        // dd($archieve);
        if($archieve['response'] == false) return array("response"=>false, "message"=>"This city has listings associated with it. Click here to view the listings.<br>You can archive this city only once this is removed from all the listings.");
        # code...
      }
      return array("response"=>true, "message"=>"");
    }

}
