<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Category;

class updateCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('job_locations', function ($table) {
            $table->integer('city_id')->unsigned()->nullable(); 
        });

        Schema::table('categories', function ($table) {
            $table->string('type');
        });

        \DB::table('categories')->update(['type' => 'listing']);

        $jobCategories = ['RESTAURANT/BAR',
                            'HOTEL/RESORT',
                            'ENTERTAINMENT-CINEMAS, CASINO, ETC',
                            'CLUB, BANQUET & CATERING UNIT',
                            'TRAVEL & TOURISM- AIRLINE CRUISE, ETC',
                            'GUEST HOUSE, BnB & VILLA RENTALS',
                            'HEALTHCARE-HOSPITAL',
                            'RETAIL',
                            'SPA',
                            'OTHER'];


        foreach ($jobCategories as $key => $jobCategory) {
            $category = new Category;
            $category ->type = 'job';
            $category ->name = ucfirst($jobCategory);
            $category ->path = null;
            $category ->parent = 1;
            $category ->status = 1;
            $category ->level = 1;
            $category ->order = 0;
            $category ->slug = getUniqueSlug($category, $jobCategory);
            $category ->save();
             
        }


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
