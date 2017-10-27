<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EnquiryCategory extends Model {
    protected $fillable = ['enquiry_id', 'category_id'];
}
