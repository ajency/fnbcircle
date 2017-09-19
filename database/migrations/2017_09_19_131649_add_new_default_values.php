<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Defaults;
use App\Category;

class AddNewDefaultValues extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        

        $jobCategories = ['FOOD TECH','FOOD PROCESSING'];

        foreach ($jobCategories as $key => $jobCategory) {
            $jobCategory = strtolower($jobCategory);
            $jobCategory = ucwords($jobCategory);
            $category = new Category;
            $category ->type = 'job';
            $category ->name = $jobCategory;
            $category ->path = null;
            $category ->parent = 1;
            $category ->status = 1;
            $category ->level = 1;
            $category ->order = 0;
            $category ->slug = getUniqueSlug($category, $jobCategory);
            $category ->save();
             
        }

        $keywords = ['Account manager jobs',
                            'Accounting Manager jobs',
                            'Accounts Payable jobs',
                            'Assistant Manager jobs',
                            'Baker jobs',
                            'Banquet Chef jobs',
                            'Banquet Manager jobs',
                           'Banquet Supervisor jobs',
                            'Bar Manager jobs',
                            'Bar Supervisor jobs',
                            'Butler jobs',
                            'Cashier jobs',
                            'Catering Manager jobs',
                            'Chef de Partie jobs',
                            'Chef de Rang jobs',
                            'Commis Chef jobs',
                            'Commis de cuisine jobs',
                            'Commis de rang jobs',
                            'Concierge jobs',
                            'Conference Manager jobs',
                            'Demi Chef de Partie jobs',
                            'Events Coordinator jobs',
                            'Events Manager jobs',
                            'Executive Chef jobs',
                            'F&B Attendant jobs',
                            'F&B Controller jobs',
                            'F&B Director jobs',
                            'F&B Manager jobs',
                            'F&B Supervisor jobs',
                            'Fitness Instructor jobs',
                            'Front Office Agent jobs',
                            'Front Office Manager jobs',
                            'Front Office Supervisor jobs',
                            'Guest Services Agent jobs',
                            'Guest Services Manager jobs',
                            'Guest Services Supervisor jobs',
                            'HR Assistant jobs',
                            'HR Director jobs',
                            'HR Manager jobs',
                            'Head Chef jobs',
                            'Hotel General Manager jobs',
                            'Housekeeping Executive jobs',
                            'Housekeeping Supervisor jobs',
                            'Kitchen Assistant jobs',
                            'Kitchen Manager jobs',
                            'Leisure Manager jobs',
                            'Massage Therapist jobs',
                            'Night Auditor jobs',
                            'Night Porter jobs',
                            'Operations Director jobs',
                            'Operations Manager jobs',
                            'Pastry Chef jobs',
                            'Pastry Commis jobs',
                            'Porter jobs',
                            'Purchasing Manager jobs',
                            'Reservations Manager jobs',
                            'Restaurant Manager jobs',
                            'Restaurant Supervisor jobs',
                            'Revenue Manager jobs',
                            'Room Attendant jobs',
                            'Rooms Division Manager jobs',
                            'Sales Coordinator jobs',
                            'Sales Director jobs',
                            'Sales Executive jobs',
                            'Sales Manager jobs',
                            'Sous Chef jobs',
                            'Spa Manager jobs',
                            'Spa Receptionist jobs',
                            'Spa Therapist jobs',
                            'Sushi Chef jobs',
                            'Training Assistant jobs',
                            'Training Manager jobs',
                            'Waiter / Waitress jobs',
                            'Manager'];

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
