<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Defaults;

class InternalEmailDefaults extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $defaults = [
            'draft-listing-active'=> [
                'name'=>'Listing in draft , user active',
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
            'draft-listing-inactive'=> [
                'name'=>'Listing in draft , user inactive',
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
            'user-activate'=> [
                'name'=>'Activation of user account',
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
            $object->type = 'internal_email';
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
        Defaults::where('type','internal_email')->delete();
    }
}
