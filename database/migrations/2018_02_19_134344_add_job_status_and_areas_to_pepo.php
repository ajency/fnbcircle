<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddJobStatusAndAreasToPepo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pepo_backups', function (Blueprint $table) {
            $table->json('jobArea')->nullable();
        });
        Schema::table('pepo_imports', function (Blueprint $table) {
            $table->json('jobArea')->nullable();
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
            $table->dropColumn(['jobArea']);
        });
        Schema::table('pepo_imports', function (Blueprint $table) {
            $table->dropColumn(['jobArea']);
        });
    }
}
