<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Enquiry extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_object_id', 'user_object_type', 'enquiry_device', 'enquiry_browser', 'enquiry_type', 'enquiry_to_id', 'enquiry_to_type', 'enquiry_message'];
}
