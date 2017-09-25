<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Defaults;

class CreateDefaultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('defaults', function (Blueprint $table) {
            $table->increments('id');
            $table->string( 'type');
            $table->string( 'label');
            $table->text( 'meta_data' )->nullable();
        });

        $statuses = ['1'=>'Draft','2'=>'Pending Review','3'=>'Published','4'=>'Archived'];

        foreach ($statuses as $key => $status) {
            $default = new Defaults;
            $default ->type = 'job_status';
            $default ->label = $status;
            $default ->meta_data = serialize([]);
            $default ->save();
             
        }

        // $jobTypes = ['1'=>'Part-time','2'=>'Full-time','3'=>'Temporary'];

        // foreach ($jobTypes as $key => $jobType) {
        //     $default = new Defaults;
        //     $default ->type = 'job_type';
        //     $default ->label = $jobType;
        //     $default ->meta_data = serialize([]);
        //     $default ->save();
             
        // }

        $salaryTypes = ['1'=>'Annualy','2'=>'Monthly','3'=>'Daily','4'=>'Hourly'];

        foreach ($salaryTypes as $key => $salaryType) {
            $default = new Defaults;
            $default ->type = 'salary_type';
            $default ->label = $salaryType;
            $default ->meta_data = serialize([]);
            $default ->save();
             
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('defaults');
    }
}
