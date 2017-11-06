<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Defaults;

class AddUserEmailConfig extends Migration
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
                'user-register'=> ['name'=>'notification-user-register', 'title'=>'New User Registration', 'value'=>[]],
                'register-internal-user'=> ['name'=>'notification-register-internal-user', 'title'=>'New Internal User Registration', 'value'=>[]],
                'user-verify'=> ['name'=>'notification-user-verify', 'title'=>'User Verification', 'value'=>[]],
                'welcome-user'=> ['name'=>'notification-welcome-user', 'title'=>'Welcome User', 'value'=>[]],
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
