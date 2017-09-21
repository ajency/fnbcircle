<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditCitiesAreasCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cities', function (Blueprint $table) {
            $table->date('published_date')->nullable();
            $table->tinyInteger('status')->comment('0=draft, 1 = published, 2=draft');
            $table->integer('order');
        });
        Schema::table('areas', function (Blueprint $table) {
            $table->date('published_date')->nullable();
            $table->tinyInteger('status')->comment('0=draft, 1 = published, 2=draft');
            $table->integer('order');
        });
        Schema::table('categories', function (Blueprint $table) {
            $table->date('published_date')->nullable();
            $table->tinyInteger('status')->comment('0=draft, 1 = published, 2=draft');
            $table->integer('order');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cities', function (Blueprint $table) {
            $table->dropColumn(['published_date','status','categories']);
        });
        Schema::table('areas', function (Blueprint $table) {
            $table->dropColumn(['published_date','status','categories']);
        });
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn(['published_date','status','categories']);
        });
    }
}
