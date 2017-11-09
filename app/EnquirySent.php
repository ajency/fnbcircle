<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EnquirySent extends Model {
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['enquiry_id', 'enquiry_type', 'enquiry_to_id', 'enquiry_to_type'];

    public function enquiry(){
    	return $this->belongsTo('App\Enquiry');
    }

    public function enquiry_to(){
    	return $this->morphTo();
    }
}
