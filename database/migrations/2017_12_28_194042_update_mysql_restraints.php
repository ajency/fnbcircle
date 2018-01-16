<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateMysqlRestraints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE  `listings` ADD CONSTRAINT UniqueListings UNIQUE (`title` ,`owner_id` ,`type` ,`locality_id`)');
        DB::statement('ALTER TABLE  `listings` CHANGE  `reference`  `reference` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL ');
        DB::statement('ALTER TABLE  `listing_category` CHANGE  `category_slug`  `category_slug` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL ');
        DB::statement('ALTER TABLE  `tagging_tagged` CHANGE  `tag_name`  `tag_name` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL ');
        DB::statement('ALTER TABLE  `user_descriptions` CHANGE  `created_at`  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ');
        DB::statement('ALTER TABLE  `user_descriptions` CHANGE  `updated_at`  `updated_at` TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE `listings` DROP INDEX UniqueListings;');
        DB::statement('ALTER TABLE  `listings` CHANGE  `reference`  `reference` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ;');
        DB::statement('ALTER TABLE  `listing_category` CHANGE  `category_slug`  `category_slug` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL');
        DB::statement('ALTER TABLE  `tagging_tagged` CHANGE  `tag_name`  `tag_name` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL');
        DB::statement('ALTER TABLE  `user_descriptions` CHANGE  `created_at`  `created_at` TIMESTAMP NULL');
        DB::statement('ALTER TABLE  `user_descriptions` CHANGE  `updated_at`  `updated_at` TIMESTAMP NULL');
    }
}
