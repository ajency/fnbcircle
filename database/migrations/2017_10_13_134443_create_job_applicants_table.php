<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobApplicantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_applicants', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('job_id')->unsigned()->nullable(); 
            $table->integer('user_id')->unsigned()->nullable(); 
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable(); 
            $table->string('city')->nullable(); 
            $table->integer('resume_id')->nullable(); 
            $table->dateTime('date_of_application')->nullable();

            $table->foreign( 'job_id' )
                  ->references( 'id' )
                  ->on( 'jobs' )
                  ->onDelete( 'cascade' );

            $table->foreign( 'user_id' )
                  ->references( 'id' )
                  ->on( 'users' )
                  ->onDelete( 'cascade' );

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
        Schema::dropIfExists('job_applicants');
    }
}
