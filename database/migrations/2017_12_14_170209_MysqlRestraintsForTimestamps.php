<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MysqlRestraintsForTimestamps extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement( 'ALTER TABLE  `users` CHANGE  `created_at`  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP' );
        DB::statement( 'ALTER TABLE  `users` CHANGE  `updated_at`  `updated_at` TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP' );
        DB::statement( 'ALTER TABLE  `user_communications` CHANGE  `created_at`  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP' );
        DB::statement( 'ALTER TABLE  `user_communications` CHANGE  `updated_at`  `updated_at` TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP' );
        DB::statement( 'ALTER TABLE  `listings` CHANGE  `created_at`  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP' );
        DB::statement( 'ALTER TABLE  `listings` CHANGE  `updated_at`  `updated_at` TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP' );
        DB::statement( 'ALTER TABLE  `listing_category` CHANGE  `created_at`  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP' );
        DB::statement( 'ALTER TABLE  `listing_category` CHANGE  `updated_at`  `updated_at` TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP' );
        DB::statement( 'ALTER TABLE  `listing_areas_of_operations` CHANGE  `created_at`  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP' );
        DB::statement( 'ALTER TABLE  `listing_areas_of_operations` CHANGE  `updated_at`  `updated_at` TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP' );
        DB::statement('ALTER TABLE  `user_communications` ADD CONSTRAINT UniqueContact UNIQUE (`object_type` ,`object_id` ,`value` ,`country_code`)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        DB::statement( 'ALTER TABLE  `users` CHANGE  `created_at`  `created_at` TIMESTAMP NULL' );
        DB::statement( 'ALTER TABLE  `users` CHANGE  `updated_at`  `updated_at` TIMESTAMP NULL' );
        DB::statement( 'ALTER TABLE  `user_communications` CHANGE  `created_at`  `created_at` TIMESTAMP NULL' );
        DB::statement( 'ALTER TABLE  `user_communications` CHANGE  `updated_at`  `updated_at` TIMESTAMP NULL' );
        DB::statement( 'ALTER TABLE  `listings` CHANGE  `created_at`  `updated_at` TIMESTAMP NULL' );
        DB::statement( 'ALTER TABLE  `listings` CHANGE  `updated_at`  `updated_at` TIMESTAMP NULL' );
        DB::statement( 'ALTER TABLE  `listing_category` CHANGE  `created_at`  `updated_at` TIMESTAMP NULL' );
        DB::statement( 'ALTER TABLE  `listing_category` CHANGE  `updated_at`  `updated_at` TIMESTAMP NULL' );
        DB::statement( 'ALTER TABLE  `listing_areas_of_operations` CHANGE  `created_at`  `updated_at` TIMESTAMP NULL' );
        DB::statement( 'ALTER TABLE  `listing_areas_of_operations` CHANGE  `updated_at`  `updated_at` TIMESTAMP NULL' );
        DB::statement('ALTER TABLE `user_communications` DROP INDEX UniqueContact;');
    }
}
