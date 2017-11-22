<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Defaults;

class AddJobExpiryNotification extends Migration
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
                'job-expiry'=> ['name'=>'notification-job-expiry', 'title'=>'Job Expiry', 'value'=>[]],
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
