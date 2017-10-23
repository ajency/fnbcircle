<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Defaults;

class AddJobRoles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $keywords = ['Administrative Jobs', 'Administrative Assistant', 'Activities Coordinator', 'Tech Jobs', 'Caddie', 'Golf related jobs','Rider', 'Associate', 'Sales Associate', 'Audio Visual technician', 'Captain', 'Senior Captain', 'Gym Trainer', 'Gym Manager', 'Fitness Instructor', 'Houseperson', 'Beach Jobs', 'Ambassador', 'PR Jobs', 'Beautician', 'Bistro Jobs', 'Breakfast Cook', 'Breakfast Attendant','Building Maintenance', 'Cafeteria Attendant','Catering Coordinator', 'Certified Instructor', 'Kids caretaker','Nanny','Club Manager', 'Chief','Chief Engineer', 'Senior Crew Member', 'Senior Team Member', 'Intern', 'Cleaning Jobs', 'Dispatcher', 'Doorman', 'Security Supervisor', 'Security Manager','Security Executive','Franchise Manager', 'Franchise Supervisor','Clerk','Gaming Executive', 'Casino Jobs', 'Transport Manager', 'Backend Jobs', 'Frontend jobs', 'Kitchen Jobs', 'Sales Representative', 'Lift Operator', 'Loss Prevention Executive', 'Parking Attendant','Photographer', 'Controller', 'Security Agent', 'Security Manager', 'Security Staff', 'Bouncer', 'Uniform and Laundry', 'Window Cleaner', 'Assistant', 'Attendant', 'Hospitality Attendant', 'Laundry Attendant', 'Maintenance', 'Guest Experience Jobs','Supervisor', 'Secretary', 'Personal Attendant', 'Peon', 'Hotel Manager', 'Trainee', 'Hotel Jobs', 'Banquet Jobs', 'Restaurant Jobs', 'Catering Jobs', 'Foodtech Jobs', 'Food Processing Jobs'];

        foreach ($keywords as $key => $keyword) {
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
