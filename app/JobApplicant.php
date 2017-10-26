<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobApplicant extends Model
{
    public function dateOfSubmission($format=1){
        $date = '';
        if(!empty($this->date_of_application)){

            if($format==1)
                $date = date('F j, Y', strtotime(str_replace('-','/', $this->date_of_application)));
            else
                $date = date('d-m-Y h:i A', strtotime(str_replace('-','/', $this->date_of_application)));

        }
        return $date;

    }


    public function resumeUpdated($format=1){
        $date = '';
        if(!empty($this->resume_updated_on)){

            if($format==1)
                $date = date('F j, Y', strtotime(str_replace('-','/', $this->resume_updated_on)));
            else
                $date = date('d-m-Y h:i A', strtotime(str_replace('-','/', $this->resume_updated_on)));

        }
        return $date;

    }

    public function job() {
        return $this->belongsTo( 'App\Job');
    }

    public function jobAppliedBy() {
        return $this->belongsTo( 'App\User');
    }
}
