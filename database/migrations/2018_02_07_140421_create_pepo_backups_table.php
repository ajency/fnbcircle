<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePepoBackupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pepo_backups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email')->unique();
            $table->string('name')->nullable();
            $table->integer('stateID')->nullable();
            $table->string('state')->nullable();
            $table->json('signUpType')->nullable();
            $table->string('active')->default('False');
            $table->string('subscribed')->default('True');
            $table->json('userType')->nullable();
            $table->json('userSubType')->nullable();
            $table->json('subTypeOptions')->nullable();
            $table->json('category')->nullable();
            $table->json('area')->nullable();
            $table->timestamps();
            $table->text('response')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pepo_backups');
    }
}
