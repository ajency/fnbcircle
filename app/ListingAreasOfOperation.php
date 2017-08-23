<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ListingAreasOfOperation extends Model
{
    protected $table = 'listing_areas_of_operations';
    public function listing()
    {
        return $this->belongsTo('App\Listing');
    }
    public function area()
    {
        return $this->belongsTo('App\Area');
    }
    public static function city($listing_id)
    {
        $operationAreas = DB::select("SELECT areas.id, areas.name as area_name, cities.id as city_id, cities.name as city_name FROM listing_areas_of_operations join areas join cities on listing_areas_of_operations.area_id = areas.id and areas.city_id = cities.id WHERE listing_id =?", [$listing_id]);
        // dd($operationAreas);
        $areas = [];
        foreach ($operationAreas as $area) {
            if (!isset($areas[$area->city_id])) {
                $areas[$area->city_id] = ['id' => $area->city_id, 'name' => $area->city_name, 'areas' => []];
            }
            $areas[$area->city_id]['areas'][] = ['id' => $area->id, 'name' => $area->area_name];
        }
        return $areas;
    }
}
