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
            $table->integer('listing_id');
            $table->integer('user_communication_id');
            $table->primary(['listing_id', 'user_communication_id']);
            $table->timestamps();
            $table->boolean('is_verified');
            $table->boolean('is_visible');
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
