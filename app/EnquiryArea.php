<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EnquiryArea extends Model {
    protected $fillable = ['enquiry_id', 'area_id', 'city_id'];
}
