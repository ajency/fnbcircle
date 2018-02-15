<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Defaults;

class CreatePepoImportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pepo_imports', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email');
            $table->string('name')->nullable();
            $table->string('state')->nullable();
            $table->string('signUpType')->nullable();
            $table->string('active')->default('False');
            $table->string('subscribed')->default('True');
            $table->json('userType')->nullable();
            $table->json('userSubType')->nullable();
            $table->json('listingType')->nullable();
            $table->json('jobRole')->nullable();
            $table->json('jobCategory')->nullable();
            $table->json('area')->nullable();
            $table->json('listingCategories')->nullable();
            $table->json('listingStatus')->nullable();
            $table->json('enquiryCategories')->nullable();
            $table->json('jobStatus')->nullable();
            $table->timestamps();
            $table->text('response')->nullable();
        });
        $object = new Defaults;
        $object->type = 'email_notification';
        $object->label = 'pepo-import';
        $object->meta_data = json_encode(['name'=>'notification-pepo-import', 'title'=>'Pepo import csv', 'value'=>[]]);
        $object->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pepo_imports');
    }
}
