<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\ListingCommunication;
use App\UserCommunication;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function listing()
    {
        return $this->hasMany('App\Listing', 'owner_id');
    }

	public function getUserDetails() { 
		return $this->hasOne('App\UserDetail', 'user_id');
	}

    public function getUserCommunications() { // Get all the communication related to that user
        return $this->hasMany('App\UserCommunication', 'object_id')->where('object_type', 'App\User');
    }

    public function getPrimaryEmail() { // Get the primary Email
        $comm_obj = $this->hasMany('App\UserCommunication', 'object_id')->where([['object_type','App\User'], ['type', 'email'], ['is_primary', true]])->first();

        if($comm_obj) {
            return $comm_obj->value;
        } else {
            return null;
        }
    }

    public function getPrimaryContact() { // Get the Primary Contact No
        $comm_obj = $this->hasMany('App\UserCommunication', 'object_id')->where([['object_type','App\User'], ['is_primary', true]])->whereIn('type', ["telephone", "mobile"])->first();
        if ($comm_obj) {
            //return $comm_obj->value;
            return array("contact_region" => substr($comm_obj->value, 0, strlen($comm_obj->value) - 10), "contact" => substr($comm_obj->value, strlen($comm_obj->value) - 10));
        } else {
            return null;
        }
    }
    public function lastUpdatedListings()
    {
        return $this->hasMany('App\Listing', 'last_updated_by');
    }

    public function saveContactDetails($data,$type){

        if($type=='listing'){
            if ($data['id'] == null) {
                $object = new ListingCommunication;
            } else {
                $object = ListingCommunication::findorFail($data['id']);
            }
            $object->value              =  $data['value'] ;
            $object->communication_type = $data['type'];
            $object->save();
        }
        else{

            if ($data['id'] == null) {
                $object = new UserCommunication;
            } else {
                $object = UserCommunication::find($data['id']);

                if($data['contact_value'] == ""){
                    $object->delete();
                }
            }

            if($data['contact_value'] != ""){
                $object->object_type  =  $data['object_type'] ;

                if(!isset($data['action']))
                    $object->object_id  =  $data['object_id'] ;

                $object->value  =  $data['contact_value'] ;
                $object->type  =  $data['contact_type'] ;
                $object->is_primary = 0;
                $object->is_communication = 1;
                $object->is_visible = $data['is_visible'] ;
                $object->save();
            }
            

        }

        return $object;
    }
}
