<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
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
        foreach ($contacts as $info) {
          if(!is_numeric($info->id) or strpos($info->id, '.') == true) return false;
          if($info->verify!=="1" and $info->verify!=="0") return false;
          if($info->visible!=="1" and $info->visible!=="0") return false;
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
