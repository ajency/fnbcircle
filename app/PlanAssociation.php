<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlanAssociation extends Model
{
    protected  $table = 'plan_associations';
    protected $dates = [
    	'created_at',
        'updated_at',
        'approval_date',
        'billing_start',
        'billing_end'
    ];

    public function premium()
    {
        return $this->morphTo();
    }

}
