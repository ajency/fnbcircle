<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanAssociationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_associations', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('premium_type');
            $table->string('premium_id');
            $table->string('plan_id');
            $table->timestamp('approval_date')->nullable();
            $table->timestamp('billing_start')->nullable();
            $table->timestamp('billing_end')->nullable();
            $table->int('status')->default(0);

        });
       
        Schema::table('jobs', function (Blueprint $table) {
            $table->boolean('premium')->default(0);
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plan_associations');
        Schema::table('jobs', function (Blueprint $table) {
            $table->dropColumn('premium');
        });
        
    }
}
