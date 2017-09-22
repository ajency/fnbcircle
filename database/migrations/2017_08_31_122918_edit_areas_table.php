<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('areas', function (Blueprint $table) {
            $table->dropUnique('city_id');
            $table->unique('slug');
            $table->unique(['name','city_id'],'dupname');
        });
        Schema::table('cities', function (Blueprint $table) {
            $table->unique('slug');
            $table->unique('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('areas', function (Blueprint $table) {
            $table->unique('name','city_id');
            $table->dropUnique('areas_slug_unique');
            $table->dropUnique('dupname');
        });
        Schema::table('cities', function (Blueprint $table) {
            $table->dropUnique('cities_slug_unique');
            $table->dropUnique('cities_name_unique');
        });
    }
}
