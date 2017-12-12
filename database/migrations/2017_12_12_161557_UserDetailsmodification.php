<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserDetailsmodification extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('brands');

        Schema::table('user_details', function (Blueprint $table) {
            $table->dropColumn(['is_job_seeker','has_job_listing','has_business_listing','has_restaurant_listing']);
            $table->integer('total_listings')->default(0);
            $table->integer('published_listings')->default(0);
            $table->integer('total_jobs')->default(0);
            $table->integer('published_jobs')->default(0);
            $table->integer('jobs_applied')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_details', function (Blueprint $table) {
            $table->dropColumn(['total_listings','published_listings','total_jobs','published_jobs','jobs_applied']);
            $table->boolean('is_job_seeker');
            $table->boolean('has_job_listing');
            $table->boolean('has_business_listing');
            $table->boolean('has_restaurant_listing');
        });
    }
}
