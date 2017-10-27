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
        $defaults = [
        'new-user'=> ['name'=>'notification-new-user', 'title'=>'New User Registration', 'value'=>[]],
        'listing-approval'=> ['name'=>'notification-listing-approval', 'title'=>'Business Listing for Approval', 'value'=>[]],
        'advertise'=> ['name'=>'notification-advertise', 'title'=>'Advertise with us', 'value'=>[]],
        'get-featured'=> ['name'=>'notification-get-featured', 'title'=>'Get Featured', 'value'=>[]],
        'job-posted'=> ['name'=>'notification-job-posted', 'title'=>'Job Listings Posted', 'value'=>[]],
        'contact-us'=> ['name'=>'notification-contact-us', 'title'=>'Contact Us', 'value'=>[]]
        ];
        foreach($defaults as $default_key => $default_value){
            $object = new Defaults;
            $object->type = 'email_notification';
            $object->label = $default_key;
            $object->meta_data = json_encode($default_value);
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
        Defaults::where('type','email_notification')->delete();
    }
}
