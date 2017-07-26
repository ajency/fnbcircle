<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserCommunicationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('user_communication', function (Blueprint $table) {
          $table->increments('id');
          $table->timestamps();
          $table->string('value');
          $table->integer('communication_type')->comment('1=email, 2=phone');
          $table->boolean('is_primary');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_communication');
    }
}
