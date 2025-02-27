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
                'name'=>'Users',
                'applied_filters'=>[
                    "signUpType" => ['google','facebook','import','listing']
                ],
                'user_filters' =>[
                    'signUpType' => 'signupType',
                    'active' => 'active',
                    'userSubType' => 'userSubType',
                    'state' => 'state' 
                ]
            ],
            'listings'=> [
                'name'=>'Business Listings',
                'applied_filters'=>[
                    'userType' => ['Listing']
                ],
                'user_filters' =>[
                    'area' => 'state',
                    'listingStatus' => 'status',
                    'listingPremium' => 'premium',
                    'listingCategories' => 'categories'
                ]
            ],
            'jobs'=> [
                'name'=>'Jobs',
                'applied_filters'=>[
                    'userType'=>['Job Poster']
                ],
                'user_filters' =>[
                    'jobArea' => 'state',
                    'jobPremium' => 'premium',
                    'jobStatus' => 'status',
                    'jobCategory' => 'jobBusinessType',
                    'jobRole' => 'jobRole'
                ]
            ],
            'enquiries'=> [
                'name'=>'Enquiries',
                'applied_filters'=>[
                    'userType' => ['Enquiry']
                ],
                'user_filters' =>[
                    'signUpType' => 'userType',
                    'userSubType' => 'userSubType',
                    'enquiryArea' => 'state',
                    'enquiryCategories' => 'categories'
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
        Defaults::where('type','export_filter')->delete();
    }
}
