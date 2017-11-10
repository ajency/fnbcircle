<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_types', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('job_id')->unsigned()->nullable(); 
            $table->integer('type_id')->unsigned()->nullable();

            $table->foreign( 'job_id' )
                  ->references( 'id' )
                  ->on( 'jobs' )
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
        Schema::dropIfExists('job_types');
    }
}
