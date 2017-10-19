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
}
