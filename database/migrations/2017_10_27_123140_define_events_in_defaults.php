<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Defaults;

class DefineEventsInDefaults extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('defaults', function (Blueprint $table) {
            Defaults::where('type','email_notification')->delete();
            $defaults = [
                'verification'=> ['name'=>'notification-verification', 'title'=>'Email verification OTP generated', 'value'=>[]],
                'listing-submit-for-review'=> ['name'=>'notification-listing-submit-for-review', 'title'=>'Business listing submitted for review', 'value'=>[]],
                'listing-published'=> ['name'=>'notification-listing-published', 'title'=>'Lisitng Published', 'value'=>[]],
                'listing-rejected'=> ['name'=>'notification-listing-rejected', 'title'=>'Lisitng Rejected', 'value'=>[]],
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
        Schema::table('defaults', function (Blueprint $table) {
            Defaults::where('type','email_notification')->delete();
        });
    }
}
