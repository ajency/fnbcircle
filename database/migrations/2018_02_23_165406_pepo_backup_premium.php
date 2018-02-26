<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PepoBackupPremium extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pepo_backups', function (Blueprint $table) {
            $table->json('listingPremium')->nullable();
            $table->json('jobPremium')->nullable();
            $table->json('enquiryArea')->nullable();
        });
        Schema::table('pepo_imports', function (Blueprint $table) {
            $table->json('listingPremium')->nullable();
            $table->json('jobPremium')->nullable();
            $table->json('enquiryArea')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pepo_backups', function (Blueprint $table) {
            $table->dropColumn(['listingPremium','jobPremium','enquiryArea']);
        });
        Schema::table('pepo_imports', function (Blueprint $table) {
            $table->dropColumn(['listingPremium','jobPremium','enquiryArea']);
        });
    }
}
