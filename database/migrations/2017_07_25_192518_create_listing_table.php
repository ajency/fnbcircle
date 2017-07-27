<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listings', function (Blueprint $table) {
          $table->increments('id');
          $table->timestamps();
          $table->string('title');
          $table->integer('status')->comment('1=published,2=review,3=draft');
          $table->timestamp('published_on')->nullable();
          $table->integer('type')->comment('11=Wholeseller,12=Retailer,13=distributer');
          $table->string('slug')->nullable();
          $table->text('description')->nullable();
          $table->string('other_details')->comment('Serialized array of year established, website etc')->nullable();
          $table->string('payment_modes')->nullable();
          $table->integer('owner_id')->nullable();
          $table->integer('created_by')->nullable();
          $table->integer('views_count')->default('0');
          $table->integer('contact_request_count')->default('0');
          $table->integer('locality_id')->nullable();
          $table->string('display_address')->nullable();
          $table->double('latitude')->nullable();
          $table->double('longitude')->nullable();
          $table->boolean('show_hours_of_operation')->nullable();
          $table->boolean('show_primary_phone');
          $table->boolean('show_primary_email');
          $table->boolean('verified')->nullable();
          $table->index('owner_id');
           $table->index('created_by');
           $table->index('locality_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('listings');
    }
}
