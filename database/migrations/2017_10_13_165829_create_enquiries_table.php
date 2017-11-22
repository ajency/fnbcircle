<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnquiriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enquiries', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_object_id')->comment("lead_id / user_id")->nullable();
            $table->string('user_object_type')->comment("App\Lead / App\User")->nullable();
            $table->string('enquiry_device')->comment("desktop / mobile")->nullable();
            $table->string('enquiry_browser')->nullable();
            $table->integer('enquiry_to_id')->comment("listing_id / job_id")->nullable(); // Primary Listing / Job ID
            $table->string('enquiry_to_type')->comment("App\Listing / App\Job")->nullable(); // Primary Listing / Job Type
            $table->text('enquiry_message')->nullable();
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
        Schema::dropIfExists('enquiries');
    }
}
