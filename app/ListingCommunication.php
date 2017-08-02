<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ListingCommunication extends Model
{

    protected $table    = "listing_communication";
    protected $fillable = ['listing_id', 'user_communication_id', 'visible', 'verified'];
    public function saveInformation($listing_id, $contact_id, $verify, $visible)
    {
        $this->listing_id            = $listing_id;
        $this->user_communication_id = $contact_id;
        $this->is_visible            = $visible;
        $this->is_verified           = $verify;
        $this->save();
    }
}
