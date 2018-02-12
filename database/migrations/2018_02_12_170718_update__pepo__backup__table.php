<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePepoBackupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pepo_backups', function (Blueprint $table) {
            $table->dropColumn('category');
            $table->json('listingCategories')->nullable();
            $table->json('listingStatus')->nullable();
            $table->json('enquiryCategories')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pepo_backups', function (Blueprint $table) {
            $table->dropColumn(['listingCategories','listingStatus','enquiryCategories']);
            $table->json('category')->nullable();
        });
    }
}
