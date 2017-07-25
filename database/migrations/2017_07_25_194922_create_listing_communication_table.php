<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListingCommunicationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listing_communication', function (Blueprint $table) {
          $table->integer('listing_id');
          $table->integer('user_communication_id');
          $table->primary(['listing_id','user_communication_id']);
          $table->timestamps();
          $table->boolean('verified');
          $table->boolean('visible');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('listing_communication');
    }
}
