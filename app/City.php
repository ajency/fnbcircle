<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
  protected $table = "cities";
  protected $fillable=['name'];
  protected $dates = [
        'created_at',
        'updated_at',
        'published_date'
    ];

  public function areas(){
    return $this->hasMany('App\Area');
  }
}
