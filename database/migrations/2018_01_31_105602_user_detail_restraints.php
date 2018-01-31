<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserDetailRestraints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement( 'ALTER TABLE  `user_details` CHANGE  `created_at`  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP' );
        DB::statement( 'ALTER TABLE  `user_details` CHANGE  `updated_at`  `updated_at` TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP' );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement( 'ALTER TABLE  `user_details` CHANGE  `created_at`  `updated_at` TIMESTAMP NULL' );
        DB::statement( 'ALTER TABLE  `user_details` CHANGE  `updated_at`  `updated_at` TIMESTAMP NULL' );
    }
}
