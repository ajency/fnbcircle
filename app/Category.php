<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table="categories";
    protected $fillable=['name','path','level','parent_id'];
    var $parent, $children;

    function path(){
      return $this->path.str_pad($this->id, 5, '0', STR_PAD_LEFT);
    }
    function level(){
      return intval($this->level)+1;
    }
    public function listing()
    {
        return $this->belongsToMany('App\Listing', 'listing_category');
    }
  //   function __construct() {
  //           if(!empty($this->parent_id)) {
  //               $this->parent->with('App\Category');
  //           }
  //   }
  //   public static $rules = array(
  //       'name' => 'required',
  //   );
  //
  //   public function parent(){
  //     $parents= $this->belongsTo('App\Category', 'parent_id');
  //     if(isset($parents->kids)) {
  //       $parents->kids->merge($parents);
  //     }
  //     return $parents;
  //   }
  //   public function children() {
  //    $children = $this->hasMany('App\Category','parent_id');
  //    foreach($children as $child) {
  //      $child->parent  = $this;
  //    }
  //    return $children;
  // }
}
