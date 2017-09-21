<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    public function getTitleAttribute( $value ) { 
        $value = ucwords( $value );      
        return $value;
    }

    public function companyStatuses(){
    	return ['1'=>'Published','2'=>'Not Published'];
    }
}
