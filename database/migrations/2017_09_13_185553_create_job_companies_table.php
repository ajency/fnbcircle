<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_companies', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('job_id')->unsigned()->nullable(); 
            $table->integer('company_id')->unsigned()->nullable();

            $table->foreign( 'job_id' )
                  ->references( 'id' )
                  ->on( 'jobs' )
                  ->onDelete( 'cascade' );


            $table->foreign( 'company_id' )
                  ->references( 'id' )
                  ->on( 'companies' )
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
        Schema::dropIfExists('job_companies');
    }
}
