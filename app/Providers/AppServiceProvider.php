<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Common;
use Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
      Validator::extend('contacts', function($attribute, $value, $parameters, $validator) {
        $contacts=json_decode($value);
        if(json_last_error() !== JSON_ERROR_NONE) return false;
        $ret = true;
        foreach ($contacts as $info) {
          if(!isset($info->id) or !is_numeric($info->id) or strpos($info->id, '.') == true or $info->id<1) return false;
          if(!isset($info->verify) or $info->verify!=="1" and $info->verify!=="0") return false;
          if(!isset($info->visible) or $info->visible!=="1" and $info->visible!=="0") return false;
          if(!Common::verify_id($info->id,'user_communication')) return false;
          // if($info->visible=="1") $ret=true;
        }
        return $ret;
     });
     Validator::extend('id_json', function($attribute, $value, $parameters, $validator) {
       $array=json_decode($value);
       if(json_last_error() !== JSON_ERROR_NONE) return false;
       foreach ($array as $info) {
         if(!isset($info->id) or !is_numeric($info->id) or strpos($info->id, '.') == true or $info->id<1) return false;
       }
       return true;
    });
    Validator::extend('doc_json', function($attribute, $value, $parameters, $validator) {
      $array=json_decode($value);
      if(json_last_error() !== JSON_ERROR_NONE) return false;
      foreach ($array as $info) {
        if(!isset($info->id) or !is_numeric($info->id) or strpos($info->id, '.') == true or $info->id<1) return false;
        if(!isset($info->title) or empty($info->title)) return false;
        if(!isset($info->url) or !filter_var($info->url, FILTER_VALIDATE_URL)) return false;
        if(!Common::verify_id($info->id,'documents')) return false;
      }
      return true;
   });
    Validator::extend('photo_json', function($attribute, $value, $parameters, $validator) {
      $array=json_decode($value);
      if(json_last_error() !== JSON_ERROR_NONE) return false;
      $featured=0;
      foreach ($array as $info) {
        if(!isset($info->id) or !is_numeric($info->id) or strpos($info->id, '.') == true or $info->id<1) return false;
        if(!isset($info->featured) or $info->featured!=="1" and $info->featured!=="0") return false;
        if($featured==1 and $info->featured==1) return false;
        if($info->featured==1) $featured =1;
        if(!isset($info->url) or empty($info->url) or !filter_var($info->url, FILTER_VALIDATE_URL)) return false;
        if(!Common::verify_id($info->id,'documents')) return false;
      }
      return true;
   });
    Validator::extend('not_empty_json', function($attribute, $value, $parameters, $validator) {
      $array=json_decode($value,true);
      if(json_last_error() !== JSON_ERROR_NONE) return false;
      if(empty($array)) return false;
      return true;
   });
   Validator::extend('week_time', function($attribute, $value, $parameters, $validator) {
     $array=json_decode($value,true);
     if(json_last_error() !== JSON_ERROR_NONE) return false;
     for($i=0;$i<7;$i++){
       if(!isset($array[$i]['from'])) return false;
       if(!isset($array[$i]['to'])) return false;
       if($array[$i]['from']>$array[$i]['to']) return false;
       if(!isset($array[$i]['closed'])or $array[$i]['closed']!=="1" and $array[$i]['closed']!=="0") return false;
       if(!isset($array[$i]['open24'])or $array[$i]['open24']!=="1" and $array[$i]['open24']!=="0") return false;
       if($array[$i]['closed']==1 and $array[$i]['open24']=="1") return false;
     }
     return true;
  });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
