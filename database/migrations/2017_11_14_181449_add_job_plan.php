<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Plan;

class AddJobPlan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $plan = new Plan;
        $plan->title = 'Free Membership';
        $plan->slug = str_slug('Free Membership');
        $plan->type = 'job';
        $plan->amount = 0;
        $plan->order = 1;
        $plan->duration = 20;
        $plan->meta_data = serialize(['Get 0 X times more response.','Get premium tag which makes your requirement stand out from rest.','Your job gets displayed on below  premium jobs and gets low priority.','0 extra days of visibility.',
'Your job is not displayed to candidates while searching for similar other jobs of other employers.']);
        $plan->save();


        $plan = new Plan;
        $plan->title = 'Premium Plan';
        $plan->slug = str_slug('Premium Plan');
        $plan->type = 'job';
        $plan->amount = 499;
        $plan->order = 2;
        $plan->duration = 40;
        $plan->meta_data = serialize(['Get 10 X times more response.','Get premium tag which makes your requirement stand out from rest.','Your job gets displayed on top of other non premium jobs and gets top priority.','20 extra days of visibility.',
'Your job is displayed to candidates while searching for similar other jobs of other employers.']);
        $plan->save();


        Schema::table('jobs', function ($table) {
            $table->dateTime('job_expires_on')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jobs', function ($table) {
            $table->dropColumn(['job_expires_on']);
        });
    }
}
