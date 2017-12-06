<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Defaults;

class EmailDefaultsUpdate extends Migration
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
                'welcome-lead'=> ['name'=>'notification-welcome-lead', 'title'=>'New Lead Entry', 'value'=>[]],
                'seeker-email-enquiry'=> ['name'=>'notification-seeker-email-enquiry', 'title'=>'Seeker Email Enquiry', 'value'=>[]],
                'direct-listing-email'=> ['name'=>'notification-direct-listing-email', 'title'=>'Direct Listing', 'value'=>[]],
                'shared-listing-email'=> ['name'=>'notification-shared-listing-email', 'title'=>'Shared Listing', 'value'=>[]],
                'dev-dump'=> ['name'=>'notification-dev-dump', 'title'=>'Developer mode', 'value'=>[]],
                'listing-user-verify'=> ['name'=>'notification-listing-user-verify', 'title'=>'New User-Listing created and notified', 'value'=>[]],
                'listing-user-notify'=> ['name'=>'notification-listing-user-notify', 'title'=>'Notify existing user new listing added', 'value'=>[]],
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
            //
        });
    }
}
