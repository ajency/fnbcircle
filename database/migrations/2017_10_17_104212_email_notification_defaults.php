<?php

use App\Defaults;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EmailNotificationDefaults extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $defaults = ['new-user','listing-approval','advertise','get-featured','job-posted','contact-us'];
        foreach($defaults as $default){
            $object = new Defaults;
            $object->type = 'email_notification';
            $object->label = $default;
            $object->meta_data = null;
            $object->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
    }
}
