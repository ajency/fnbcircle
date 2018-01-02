<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Plan;

class PremiumPlan0 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement( 'ALTER TABLE  `plans` CHANGE  `created_at`  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP' );
        DB::statement( 'ALTER TABLE  `plans` CHANGE  `updated_at`  `updated_at` TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP' );
        $plan = new Plan;
        $plan->title = "Basic Plan";
        $plan->slug = "free-listing";
        $plan->type="listing";
        $plan->order = 0;
        $plan->amount = 0;
        $plan->duration = 3650;
        $plan->meta_data = '{
            "0":"Basic plan",
            "1":"Lower Priority Listing", 
            "2":"Fewer Enquiries", 
            "3":"Fewer Contact Requests", 
            "4":"Lower Rating",
            "5":"No Power Seller Badge"
        }';
        $plan->save();

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
