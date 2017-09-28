<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Defaults;

class AddKeywords extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $keywords = ['ENGINEERING & MAINTAINENCE',
                    'ADMINISTRATION',
                    'Administration & General jobs',
                    'Asset Management jobs',
                    'Back Office jobs',
                    'Bakery/Pastry jobs',
                    'Catering jobs',
                    'Chocolate Arts jobs',
                    'Communication jobs',
                    'Consulting jobs',
                    'Engineering & Maintenance jobs',
                    'Events jobs',
                    'F&B kitchen jobs',
                    'F&B other jobs',
                    'F&B service jobs',
                    'Finance/Accounting jobs',
                    'Front Office concierge jobs',
                    'Front Office porter jobs',
                    'Front Office reception jobs',
                    'Guest Relations jobs',
                    'Helpdesk & Support jobs',
                    'Hostess jobs',
                    'Housekeeping jobs',
                    'Human Resources jobs',
                    'IT jobs',
                    'Legal jobs',
                    'Logistics jobs',
                    'Management jobs',
                    'Management Trainee jobs',
                    'Other jobs',
                    'Public Relations jobs',
                    'Purchasing jobs',
                    'Real Estate jobs',
                    'Recreation & Leisure jobs',
                    'Reservations jobs',
                    'Retail jobs',
                    'Revenue Management jobs',
                    'Rooms division jobs',
                    'Sales & Marketing jobs',
                    'Security jobs',
                    'Sommelier jobs', 
                    'Spa & Wellness jobs',
                    'Tourism jobs'];

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
