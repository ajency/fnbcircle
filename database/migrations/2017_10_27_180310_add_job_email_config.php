<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Defaults;

class AddJobEmailConfig extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('defaults', function (Blueprint $table) {
            $defaults = [
                'job-application'=> ['name'=>'notification-job-application', 'title'=>'Job Application', 'value'=>[]],
                'job-submit-for-review'=> ['name'=>'notification-job-submit-for-review', 'title'=>'Job Submit For Review', 'value'=>[]],
                'job-published'=> ['name'=>'notification-job-published', 'title'=>'Job Published', 'value'=>[]],
                'job-rejected'=> ['name'=>'notification-job-rejected', 'title'=>'Job Rejected', 'value'=>[]],
                'job-alert'=> ['name'=>'notification-job-alert', 'title'=>'Job Alert', 'value'=>[]],
            ];
            foreach($defaults as $default_key => $default_value){
                $object = new Defaults;
                $object->type = 'email_notification';
                $object->label = $default_key;
                $object->meta_data = json_encode($default_value);
                $object->save();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
