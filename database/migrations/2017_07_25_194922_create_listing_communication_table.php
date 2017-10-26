<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->increments('id');
            $table->integer('listing_id')->nullable();
            $table->timestamps();
            $table->string('value');
            $table->integer('communication_type')->comment('1=email, 2=phone');
            $table->boolean('is_verified')->default('0');
            $table->boolean('is_visible')->nullable();
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
