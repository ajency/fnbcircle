<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class UserDescription extends pivot
{
     public function user()
    {
        return $this->morphTo();
    }
}
