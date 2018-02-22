<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Defaults;
class SaveExportFilterDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $defaults = [
            'users'=> [
                'name'=>'Registered Users',
                'applied_filters'=>[
                    'App\Listing'=>[
                        'status'=>[3]
                    ],
                    'App\User'=>[
                        'status'=>['active'],
                    ],
                ],
                'user_filters' =>[
                    'location_filter', 
                    'category_filter', 
                    'listing_source',
                ]
            ],
            'listings'=> [
                'name'=>'Listing Owners',
                'applied_filters'=>[
                    'App\Listing'=>[
                        'status'=>[3]
                    ],
                    'App\User'=>[
                        'status'=>['inactive'],
                    ],
                ],
                'user_filters' =>[
                    'location_filter', 
                    'category_filter', 
                    'listing_source',
                ]
            ],
            'jobs'=> [
                'name'=>'Job Posters',
                'applied_filters'=>[
                    'App\Listing'=>[
                        'status'=>[3]
                    ],
                    'App\User'=>[
                        'status'=>['inactive'],
                    ],
                ],
                'user_filters' =>[
                    'location_filter', 
                    'category_filter', 
                    'listing_source',
                ]
            ],
            'enquiries'=> [
                'name'=>'Enquirees',
                'applied_filters'=>[
                    'App\User'=>[
                        'status'=>['inactive'],
                    ],
                ],
                'user_filters' =>[
                    'description_filter',
                    'location_filter',
                    'user_created_filter',
                ],
            ],
        ];
        foreach($defaults as $default_key => $default_value){
            $object = new Defaults;
            $object->type = 'export_filter';
            $object->label = $default_key;
            $object->meta_data = json_encode($default_value);
            $object->save();
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
