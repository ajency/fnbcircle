<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditPublishedDateTimestamp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('categories', function (Blueprint $table) {
            // $table->dropColumn('published_date');
            $table->timestamp('published_date')->nullable();
        });
        Schema::table('cities', function (Blueprint $table) {
            // $table->dropColumn('published_date');
            $table->timestamp('published_date')->nullable();
        });
        Schema::table('areas', function (Blueprint $table) {
            // $table->dropColumn('published_date');
            $table->timestamp('published_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('categories', function (Blueprint $table) {
            //
        });
    }
}
