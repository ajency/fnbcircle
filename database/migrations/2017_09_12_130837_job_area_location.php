<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class JobAreaLocation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_locations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('job_id')->unsigned()->nullable(); 
            $table->integer('area_id')->unsigned()->nullable();

            $table->foreign( 'job_id' )
                  ->references( 'id' )
                  ->on( 'jobs' )
                  ->onDelete( 'cascade' );


            $table->foreign( 'area_id' )
                  ->references( 'id' )
                  ->on( 'areas' )
                  ->onDelete( 'cascade' );
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
