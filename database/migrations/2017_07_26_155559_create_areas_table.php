<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('areas', function (Blueprint $table) {
         $table->increments('id');
         $table->timestamps();
         $table->string('name');
         $table->string('slug')->nullable();
         $table->integer('city_id');
         $table->unique('name','city_id');

     });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('areas');
    }
}
