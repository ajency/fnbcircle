<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Defaults;

class CreateJobKeywordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_keywords', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('job_id')->unsigned()->nullable(); 
            $table->integer('keyword_id')->unsigned()->nullable();

            $table->foreign( 'job_id' )
                  ->references( 'id' )
                  ->on( 'jobs' )
                  ->onDelete( 'cascade' );

        });

        ///add default key words
        $keywords = ['ACCOUNTANT',
'IT',
'COOKING',
'DATA ENTRY',
'CREATIVE/ART/DESIGN',
'SALES, ADVERTISING OR MARKETING',
'CUSTOMER SERVICE ',
'MANAGEMENT',
'LEGAL',
'TRAINING',
'PURCHASE',
'Q.A.',
'CONSTRUCTION & DEVELOPMENT',
'DISTRIBUTION AND LOGISTICS',
'OTHER',
'Apprentice Bartender',
'Area Director',
'Assistant Chef',
'Assistant General Manager',
'Assistant Kitchen Manager',
'Associate Creative Director',
'Baker',
'Bakery-Cafe Associate',
'Barback',
'Barista',
'Bar Manager',
'Bartender',
'Brand Manager',
'Bus Person',
'Cashier',
'Casual Restaurant Manager',
'Chef',
'Chef Manager',
'Coffee Tasting Room Assistant',
'Communications Manager',
'Cook',
'Commis',
'Commis 1',
'Commis 2',
'Culinary Services Supervisor',
'Culinary Trainee',
'Dessert Finisher',
'Digital Marketing Manager',
'Dining Room Manager',
'Director of Human Resources',
'Dishwasher',
'District Manager',
'Espresso Beverage Maker',
'Executive Chef',
'Expeditor',
'Field Recruiting Manager',
'Fine Dining Restaurant Manager',
'Food Runner',
'Front Manager',
'Grill Cook',
'Hibachi Chef',
'Host',
'Human Resources Manager',
'Inventory Analyst',
'Kitchen Manager',
'Kitchen Worker',
'Lead Cook',
'Line Cook',
'Manager, Research and Development',
'National Training Manager',
'Operations Analyst',
'Pantry Worker',
'Prep Cook',
'Product Manager',
'Regional Brand Development Manager',
'Regional Facilities Manager',
'Regional Manager',
'Regional Operations Specialist',
'Restaurant General Manager',
'Restaurant Manager',
'Server',
'Shift Supervisor',
'Sous Chef',
'Steward',
'Back Office Assistant',
'Bell Attendant',
'Bellhop',
'Bellman',
'Bellperson',
'Concierge',
'Concierge Agent',
'Crew Member',
'Director of Hotel Sales',
'Director of Hotel Operations',
'Driver',
'Event Planner',
'Front Desk Clerk',
'Front Desk Agent',
'Front Desk Associate',
'Front Desk Sales and Service Associate',
'Front Office Associate',
'Front Office Attendant',
'Front Office Associate',
'Gardener',
'Greeter',
'Groundskeeper',
'Group Sales Coordinator',
'Group Sales Manager',
'Guest Room Sales Manager',
'Guest Services Associate',
'Guest Services Coordinator',
'Guest Services Manager',
'Guest Service Representative',
'Guest Services Supervisor',
'Hotel Deposit Clerk',
'Hotel Group Sales Manager',
'Housekeeper',
'Housekeeper Aide',
'Housekeeping Supervisor',
'Lead Housekeeper',
'Manager, Special Events',
'Maintenance Supervisor',
'Maintenance Worker',
'Marketing Coordinator',
'Meeting Coordinator',
'Meeting Concierge',
'Meeting Planner',
'Meeting Specialist',
'Meeting Manager',
'Mini-Bar Attendant',
'Night Auditor',
'Night Clerk',
'Porter',
'Reservations Agent',
'Room Attendant',
'Room Service Manager',
'Room Service Worker',
'Team Member',
'Transportation Coordinator',
'Valet Attendant',
'Valet Parker',
'Valet Parking Attendant',
'Wedding Coordinator',
'Wedding Sales Manager',
'Back Office Supervisor',
'Corporate Sales Manager',
'Director of Maintenance',
'Director of Marketing',
'Director of Operations',
'Director of Sales',
'Event Planner',
'Events Manager',
'Executive Housekeeper',
'Executive Conference Manager',
'Executive Meeting Manager',
'Front Desk Supervisor',
'General Manager',
'Guest Services Supervisor',
'Housekeeping Supervisor',
'Public Relations Coordinator',
'Public Relations Manager',
'Sales and Marketing Coordinator',
'Sales Coordinator',
'Sales Manager',
'Shift Leader',
'Shift Manager',
'Backwaiter',
'Banquet Server',
'Banquet Manager',
'Bartender',
'Bar Staff',
'Busser',
'Cafe Manager',
'Catering Manager',
'Catering Sales Manager',
'Chef',
'Cook',
'Dishwasher',
'Food and Beverage Manager',
'Food Runner',
'Food Server',
'Host',
'Hostess',
'Kitchen Team Member',
'Kitchen Manager',
'Restaurant Manager',
'Server',
'Wait Staff',
'Waiter',
'Waitress'];

        foreach ($keywords as $key => $keyword) {
            $default = new Defaults;
            $default ->type = 'job_keyword';
            $default ->label = $keyword;
            $default ->meta_data = serialize([]);
            $default ->save();
             
        }


        $jobTypes = ['Full Time','Part Time','Contact/Temp','Internship','Work From Home','International Jobs-Work Abroad'];

        foreach ($jobTypes as $key => $jobType) {
            $default = new Defaults;
            $default ->type = 'job_type';
            $default ->label = $jobType;
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
        Schema::dropIfExists('job_keywords');
    }
}
