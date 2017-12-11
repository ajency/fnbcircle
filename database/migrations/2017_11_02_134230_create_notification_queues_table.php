<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationQueuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_queue', function (Blueprint $table) {
            $table->increments('id');
            $table->string('notification_type')->nullable();
            $table->string('event_type')->nullable();
            $table->string('subject')->nullable();
            $table->string('to')->nullable();
            $table->string('cc')->nullable();
            $table->string('bcc')->nullable();
            $table->string('from_name')->nullable();
            $table->string('from_email')->nullable();
            $table->longText('template_data')->nullable();
            $table->dateTime('send_at')->nullable();
            $table->dateTime('processed_at')->nullable();
            $table->boolean('processed')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notification_queue');
    }
}
