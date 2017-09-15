<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\ListingCommunication;
use App\UserCommunication;
class User extends Authenticatable
{
    use Notifiable;

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
            }
            $object->object_type  =  $data['object_type'] ;
            $object->object_id  =  $data['object_id'] ;
            $object->value  =  $data['contact_value'] ;
            $object->type  =  $data['contact_type'] ;
            $object->is_primary = 0;
            $object->is_communication = 1;
            $object->save();

        }

        return $object;
    }
}
