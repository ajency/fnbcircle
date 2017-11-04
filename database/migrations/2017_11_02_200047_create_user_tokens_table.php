<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_token', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->text('token');
            $table->string('token_type');
            $table->timestamps();
            $table->datetime('token_expiry_date');
            $table->string('status');

            $table->foreign( 'user_id' )
                  ->references( 'id' )
                  ->on( 'users' )
                  ->onDelete( 'cascade' );
             
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_token');
    }
}
