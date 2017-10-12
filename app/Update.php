<?php

namespace App;

use Ajency\FileUpload\FileUpload;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Update extends Model
{
    use FileUpload;
    use SoftDeletes;


}
