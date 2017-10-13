<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUpdatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('updates', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('object_type')->nullable();
            $table->integer('object_id')->nullable();
            $table->integer('posted_by');
            $table->integer('last_updated_by');
            $table->string('title');
            $table->text('contents');
            $table->string('photos')->nullable();
            $table->integer('status')->comment('0= draft, 1=published');
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('updates');
    }
}
