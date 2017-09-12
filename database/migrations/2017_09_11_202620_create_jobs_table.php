<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('reference_id');
            $table->string('title');
            $table->text('description');
            $table->string('slug');
            $table->integer('category_id')->unsigned()->nullable(); 
            $table->integer('job_type')->nullable();
            $table->integer('experience_years_lower')->nullable();
            $table->integer('experience_years_upper')->nullable();
            $table->integer('salary_type')->nullable();
            $table->integer('salary_lower')->nullable();
            $table->integer('salary_upper')->nullable();
            $table->integer('status')->nullable();
            $table->integer('job_creator')->unsigned()->nullable(); 
            $table->integer('job_modifier')->unsigned()->nullable(); 
            $table->dateTime('published_on')->nullable();
            $table->integer('published_by')->unsigned()->nullable(); 
            $table->text('meta_data');
            $table->timestamps();


            $table->foreign( 'job_creator' )
                  ->references( 'id' )
                  ->on( 'users' )
                  ->onDelete( 'cascade' );

            $table->foreign( 'job_modifier' )
                  ->references( 'id' )
                  ->on( 'users' )
                  ->onDelete( 'cascade' );


            $table->foreign( 'published_by' )
                  ->references( 'id' )
                  ->on( 'users' )
                  ->onDelete( 'cascade' );

            $table->foreign( 'category_id' )
                  ->references( 'id' )
                  ->on( 'categories' )
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
        Schema::dropIfExists('jobs');
    }
}
