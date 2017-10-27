<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnquirySentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enquiry_sents', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('enquiry_type')->comment("direct, shared or more...")->nullable();
            $table->integer('enquiry_to_id')->comment("listing_id / job_id")->nullable();
            $table->string('enquiry_to_type')->comment("App\Listing / App\Job")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('enquiry_sents');
    }
}
