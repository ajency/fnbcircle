<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListingCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('listing_category', function (Blueprint $table) {
          $table->integer('listing_id');
          $table->integer('category_id');
          $table->primary(['listing_id','category_id']);
          $table->timestamps();
          $table->boolean('core')->default(0);
          $table->index('listing_id');
          $table->index('category_id');

      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::dropIfExists('listing_category');

    }
}
