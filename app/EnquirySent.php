<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EnquirySent extends Model {
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['enquiry_type', 'enquiry_to_id', 'enquiry_to_type'];
}
