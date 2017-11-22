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

    public function plan() {
        return $this->belongsTo( 'App\Plan');
    }

    public function premium()
    {
        return $this->morphTo();
    }
    const PENDING    = 0;
    const ACTIVE       = 1;
    const CANCEL       = 2;

}
