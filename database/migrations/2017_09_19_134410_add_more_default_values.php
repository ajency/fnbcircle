<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Defaults;


class AddMoreDefaultValues extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $keywords = ['AGENT',
                        'EXECUTIVE',
                        'DELIVERY STAFF',
                        'DELIVERY BOY',
                        'DRIVER',
                        'ORDER TAKER',
                        'TRAVEL AGENT'];

        foreach ($keywords as $key => $keyword) {
            $keyword = strtolower($keyword);
            $keyword = ucwords($keyword);

            $default = new Defaults;
            $default ->type = 'job_keyword';
            $default ->label = $keyword;
            $default ->meta_data = serialize([]);
            $default ->save();
             
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
