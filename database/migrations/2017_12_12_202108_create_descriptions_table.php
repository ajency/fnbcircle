<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Description;

class CreateDescriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('descriptions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('value')->unique();
            $table->string('description')->nullable();
            $table->text('meta')->nullable();
            $table->boolean('active')->default(1);
            $table->timestamps();
        });

        $hospitality = new Description;
        $hospitality->title = "Hospitality Business Owner";
        $hospitality->value = "hospitality";
        $hospitality->description = "If you are an Owner/Founder/Director/C.E.O of a Restaurant, Catering Business, Hotel, Food or Beverage Manufacturing/Processing unit, Food Tech Business or any other Hospitality Business";
        $hospitality->active = 1;
        $hospitality->meta = '{
            "register_description": {
                "type": "checkbox",
                "css_classes": "checkbox",
                "id": "",
                "name": "description[]",
                "value": "hospitality",
                "for": "hospitality",
                "title": "Hospitality Business Owner"
            },
            "listing_enquiry_description": {
                "type": "checkbox",
                "css_classes": "checkbox",
                "id": "",
                "name": "description[]",
                "value": "hospitality",
                "for": "hospitality",
                "title": "Hospitality Business Owner",
                "parsley": {
                    "data-parsley-mincheck": "1",
                    "data-required": "true",
                    "data-parsley-errors-container": "#describes-best-error"
                }
            },
            "enquiry_popup_display": {

                "type": "li_label",
                "css_classes": "x-small",
                "id": "",
                "name": "",
                "value": "",
                "for": "hospitality",
                "title": "Hospitality Business Owner",
                "parsley": {
                    "data-parsley-mincheck": "1",
                    "data-required": "true",
                    "data-parsley-errors-container": "#describes-best-error"
                }

            },
            "list_view_enquiry_description": {
                "type": "option",
                "css_classes": "",
                "id": "",
                "name": "description[]",
                "value": "hospitality",
                "for": "hospitality",
                "title": "Hospitality Business Owner",
                "parsley": {
                    "data-parsley-mincheck": "1",
                    "data-required": "true",
                    "data-parsley-errors-container": "#describes-best-error"
                }
            }
        }';
        $hospitality->save();

        
        $professional = new Description;
        $professional->title = "Working Professional";
        $professional->value = "professional";
        $professional->description = "If you are a Chef, Senior Manager, Mid level Manager, Supervisor, Order Taker, Customer Representative, etc";
        $professional->active = 1;
        $professional->meta = '{
            "register_description": {
                "type": "checkbox",
                "css_classes": "checkbox",
                "id": "",
                "name": "description[]",
                "value": "professional",
                "for": "professional",
                "title": "Working Professional"
            },
            "listing_enquiry_description": {
                "type": "checkbox",
                "css_classes": "checkbox",
                "id": "",
                "name": "description[]",
                "value": "professional",
                "for": "professional",
                "title": "Working Professional"
            },
            "enquiry_popup_display": {
                "type": "li_label",
                "css_classes": "x-small",
                "id": "",
                "name": "",
                "value": "",
                "for": "professional",
                "title": "Working Professional"
            },
            "list_view_enquiry_description": {
                "type": "option",
                "css_classes": "",
                "id": "",
                "name": "description[]",
                "value": "professional",
                "for": "professional",
                "title": "Working Professional"
            }
        }';
        $professional->save();

        $vendor = new Description;
        $vendor->title = "Vendor/Supplier/Service provider";
        $vendor->value = "vendor";
        $vendor->description = "If you or your company trades in or supplies/provides anything to the Hospitality Industry. This category includes Food & Beverage Traders, Manufacturers, Importers, Exporters, Service/Solution Providers";
        $vendor->active = 1;
        $vendor->meta = '{
            "register_description": {
                "type": "checkbox",
                "css_classes": "checkbox",
                "id": "",
                "name": "description[]",
                "value": "vendor",
                "for": "vendor",
                "title": "Vendor\/Supplier\/Service provider"
            },
            "listing_enquiry_description": {
                "type": "checkbox",
                "css_classes": "checkbox",
                "id": "",
                "name": "description[]",
                "value": "vendor",
                "for": "vendor",
                "title": "Vendor\/Supplier\/Service provider"
            },
            "enquiry_popup_display": {
                "type": "li_label",
                "css_classes": "x-small",
                "id": "",
                "name": "",
                "value": "",
                "for": "vendor",
                "title": "Vendor\/Supplier\/Service provider"
            },
            "list_view_enquiry_description": {
                "type": "option",
                "css_classes": "",
                "id": "",
                "name": "description[]",
                "value": "vendor",
                "for": "vendor",
                "title": "Vendor\/Supplier\/Service provider"
            }
        }';
        $vendor->save();

        $student = new Description;
        $student->title = "Hospitality Student";
        $student->value = "student";
        $student->description = "If you are pursuing your education in hospitality sector currently";
        $student->active = 1;
        $student->meta = '{
            "register_description": {
                "type": "checkbox",
                "css_classes": "checkbox",
                "id": "",
                "name": "description[]",
                "value": "student",
                "for": "student",
                "title": "Hospitality Student"
            },
            "listing_enquiry_description": {
                "type": "checkbox",
                "css_classes": "checkbox",
                "id": "",
                "name": "description[]",
                "value": "student",
                "for": "student",
                "title": "Hospitality Student"
            },
            "enquiry_popup_display": {
                "type": "li_label",
                "css_classes": "x-small",
                "id": "",
                "name": "",
                "value": "",
                "for": "student",
                "title": "Hospitality Student"
            },
            "list_view_enquiry_description": {
                "type": "option",
                "css_classes": "",
                "id": "",
                "name": "description[]",
                "value": "student",
                "for": "student",
                "title": "Hospitality Student"
            }
        }';
        $student->save(); 

        $entrepreneur = new Description;
        $entrepreneur->title = "Prospective Entrepreneur";
        $entrepreneur->value = "entrepreneur";
        $entrepreneur->description = "If you see yourself becoming a part of the awesome Hospitality Industry in the near or distant future";
        $entrepreneur->active = 1;
        $entrepreneur->meta = '{
            "register_description": {
                "type": "checkbox",
                "css_classes": "checkbox",
                "id": "",
                "name": "description[]",
                "value": "entrepreneur",
                "for": "entrepreneur",
                "title": "Prospective Entrepreneur"
            },
            "listing_enquiry_description": {
                "type": "checkbox",
                "css_classes": "checkbox",
                "id": "",
                "name": "description[]",
                "value": "entrepreneur",
                "for": "entrepreneur",
                "title": "Prospective Entrepreneur"
            },
            "enquiry_popup_display": {
                "type": "li_label",
                "css_classes": "x-small",
                "id": "",
                "name": "",
                "value": "",
                "for": "entrepreneur",
                "title": "Prospective Entrepreneur"
            },
            "list_view_enquiry_description": {
                "type": "option",
                "css_classes": "",
                "id": "",
                "name": "description[]",
                "value": "entrepreneur",
                "for": "entrepreneur",
                "title": "Prospective Entrepreneur"
            }
        }';
        $entrepreneur->save(); 

        $others = new Description;
        $others->title = "Others";
        $others->value = "others";
        $others->description = "Consultants, Media, Investors, Foodie, etc";
        $others->active = 1;
        $others->meta = '{
            "register_description": {
                "type": "checkbox",
                "css_classes": "checkbox",
                "id": "",
                "name": "description[]",
                "value": "others",
                "for": "others",
                "title": "Others"
            },
            "listing_enquiry_description": {
                "type": "checkbox",
                "css_classes": "checkbox",
                "id": "",
                "name": "description[]",
                "value": "others",
                "for": "others",
                "title": "Others",
                "required": "true"
            },
            "enquiry_popup_display": {
                "type": "li_label",
                "css_classes": "x-small",
                "id": "",
                "name": "",
                "value": "",
                "for": "others",
                "title": "Others",
                "required": "true"
            },
            "list_view_enquiry_description": {
                "type": "option",
                "css_classes": "",
                "id": "",
                "name": "description[]",
                "value": "others",
                "for": "others",
                "title": "Others",
                "required": "true"
            }
        }';
        $others->save();        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('descriptions');
    }
}
