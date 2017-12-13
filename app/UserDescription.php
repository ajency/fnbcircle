<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class UserDescription extends pivot
{
	protected $table = 'user_descriptions';
     public function user()
    {
        return $this->morphTo();
    }
}
