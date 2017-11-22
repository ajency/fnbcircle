<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'mobile', 'is_verified', 'lead_creation_date', 'user_id', 'user_details_meta'];


    public function getPrimaryEmail($return_array = false){
    	return  (!$return_array)? $this->email : ['email' => $this->email, 'is_verified' => false];
    }

    public function getPrimaryContact(){
    	return ["contact_region" => explode('-',$this->mobile)[0], "contact" => explode('-',$this->mobile)[1], "is_verified" => $this->is_verified];
    }
}
