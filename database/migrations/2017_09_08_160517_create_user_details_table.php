<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_details', function (Blueprint $table) {
            $table->increments('id');
			$table->string('subtype', 50)->nullable();
			$table->string('city', 50)->nullable();
			$table->string('area', 50)->nullable();
			$table->boolean('is_job_seeker')->default(0);
			$table->boolean('has_job_listing')->default(0);
			$table->boolean('has_business_listing')->default(0);
			$table->boolean('has_restaurant_listing')->default(0);
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
        Schema::dropIfExists('user_details');
    }
}
