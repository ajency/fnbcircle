<?php

$ajimport_config['filetype']  = "csv";
$ajimport_config['delimiter'] = ",";
$ajimport_config['batchsize'] = "100";
$ajimport_config['recipient'] = "parag@ajency.in";

$ajimport_config['temptablename'] = 'aj_import_temp';
$ajimport_config['temptable_default_fields'] = array("tmp_source"=>'y');
//$ajimport_config['filepath']  = resource_path('uploads') . "/filetoimport.csv";

$ajimport_config['fileheader'] = array(
    'BusinessName', 
    'BusinessType', 
    'City', 'City_id',
    'Email1', 
        'Email2', 
    'Mobile1', 
        'Mobile2', 
    'Landline1', 
        'Landline2', 
    'CoreCategory1', 'CoreCategory1_id', 
        'CoreCategory2', 'CoreCategory2_id', 
        'CoreCategory3', 'CoreCategory3_id', 
        'CoreCategory4', 'CoreCategory4_id', 
        'CoreCategory5', 'CoreCategory5_id', 
        'CoreCategory6', 'CoreCategory6_id', 
        'CoreCategory7', 'CoreCategory7_id', 
        'CoreCategory8', 'CoreCategory8_id', 
        'CoreCategory9', 'CoreCategory9_id', 
        'CoreCategory10', 'CoreCategory10_id', 
    'Brand1', 'Brand1_id', 
        'Brand2', 'Brand2_id', 
        'Brand3', 'Brand3_id', 
        'Brand4', 'Brand4_id', 
        'Brand5', 'Brand5_id', 
        'Brand6', 'Brand6_id', 
        'Brand7', 'Brand7_id', 
        'Brand8', 'Brand8_id', 
        'Brand9', 'Brand9_id', 
        'Brand10', 'Brand10_id', 
    'DisplayAddress', 
    'AreaOfOperation1', 'AreaOfOperation1_id', 
        'AreaOfOperation2',// 'AreaOfOperation2_id', 
        'AreaOfOperation3',// 'AreaOfOperation3_id', 
        'AreaOfOperation4',// 'AreaOfOperation4_id', 
        'AreaOfOperation5',// 'AreaOfOperation5_id', 
        'AreaOfOperation6',// 'AreaOfOperation6_id', 
        'AreaOfOperation7',// 'AreaOfOperation7_id', 
        'AreaOfOperation8', //'AreaOfOperation8_id', 
        'AreaOfOperation9',// 'AreaOfOperation9_id', 
        'AreaOfOperation10',// 'AreaOfOperation10_id', 
    'BusinessDescription', 
    'BusinessHighlights', 
    'YearofEstablishment', 
    'BusinessWebsite', 
    'OnlineBanking', 
        'OnCredit', 
        'Credit-DebitCards', 
        'E-MobileWallets', 
        'CashOnDelivery', 
        'USSD-AEPS-UPI', 
        'Cheque', 
        'Draft', 
);

$ajimport_config['childtables'][] = array(
    'name'                                    => 'users', 
    'insertid_childtable'                     => 'id',
    'is_mandatary_insertid'                   => 'yes',
    'insertid_temptable'                      => array( 
    // 'Field to be added to temp table to store id of insertion record to child table'
        'users_id' => 'id'
    ),
    'fields_map_to_update_temptable_child_id' => array(
    //'temp table field'=>'child table field')
        "Email1" => "email"
    ),
    'fields_map'                              => array(
    //'temp table field'=>'child table field')
        "Email1"    => "email",
        "Email1"      => "name"
    ),
    'default_values'        => array(
    //array("user communication column name"=>"default value for the column")
        "password"                      => '$2y$10$n1vUiqzSSGmD/3E8IddIw.ZiGiRup3tNf7WjZChIeJcCaOdpd8muK', 
        "type"                          => "external",
        'has_required_fields_filled'    => '0',
        "status"                        =>"inactive",
        "signup_source"                 =>"import"

    ), 
); 

// user communication one for email after user entry

$ajimport_config['childtables'][] = array(
    'name'                  => 'user_communications',
    'is_mandatary_insertid' => 'no',
    'fields_map'            => array(
        "Email1"    => "value", 
        "users_id"  => "object_id"
    ),
    'default_values'        => array(
        "object_type"       => "App\User", 
        "type"              => "email",
        "is_primary"        => "1",
        "is_communication"  => "1",
        "is_verified"       => "0",
        "is_visible"        => "1",
    ), 
);

// user communication one for phone after user entry
$ajimport_config['childtables'][] = array(
    'name'                  => 'user_communications',
    'is_mandatary_insertid' => 'no',
    'fields_map'            => array(
        "Mobile1"    => "value", 
        "users_id"  => "object_id"
    ),
    'default_values'        => array(
        "object_type"   => "App\User", 
        "type"          => "mobile",
        "is_primary"        => "1",
        "is_communication"  => "1",
        "is_verified"       => "0",
        "is_visible"        => "1",
        "country_code"      => "91"
    ), 
);

$ajimport_config['childtables'][] = array(
    'name'                                    => 'listings',
    'insertid_childtable'                     => 'id',
    'is_mandatary_insertid'                   => 'yes',
    'insertid_temptable'                      => array(
        'listings_id' => 'id'
    ),
    'fields_map_to_update_temptable_child_id' => array(
        "Company_Name"  => "title", 
        "areas_id"      => "locality_id", 
        "users_id"      => "owner_id"
    ),
    'fields_map'                              => array(
        "Company_Name"   => "title", 
        "DisplayAddress" => "display_address",
        "Business_Type"  => "type", 
        "areas_id"       => "locality_id", 
        "users_id"       => "owner_id",
        "Reference"      => "reference",
    ), 
    'columnupdatevalues'                      => array(
        'Business_Type'  => array(
            "Wholeseller"   => 11, 
            "Retailer"      => 12, 
            "Manufacturer"  => 13
        )
    ),
    /*serialize array form at array('column on tagle'=>array of values to be serialized where key will be a static provided by user and value will be field from temp table)    */
    'serializevalues'                         => array(
        'other_details' => array(
            'website'           => 'Web', 
            'establish_year'    => 'Year'
        ),
    ),

);
// user communication one for email after listings table  entry
$ajimport_config['childtables'][] = array(
    'name'                  => 'user_communications',
    'is_mandatary_insertid' => 'no',
    'fields_map'            => array(
        "Email2"        => "value", 
        "listings_id"   => "object_id"
    ), 
    'default_values'        => array(
        "object_type"   => "App\Listing", 
        "type"          => "email"
    ), 
);

// user communication one for mobile after listings table  entry
$ajimport_config['childtables'][] = array(
    'name'            => 'user_communications',
    'is_mandatary_in' => 'no',
    'fields_map'      => array(
        "Mobile2"        => "value", 
        "listings_id"   => "object_id"
    ), 
    'default_values'  => array(
        "object_type"   => "App\Listing", 
        "type"          => "mobile"
    ), 
);


// user communication one for phone after listings table  entry
$ajimport_config['childtables'][] = array(
    'name'                      => 'user_communications',
    'is_mandatary_insertid'     => 'no',
    'fields_map'                => array(
        "Landline1"       => "value", 
        "listings_id"   => "object_id"
    ),
    'default_values'            => array(
        "object_type"   => "App\Listing", 
        "type"          => "landline"
    ),
);

// user communication one for phone after listings table  entry
$ajimport_config['childtables'][] = array(
    'name'                      => 'user_communications',
    'is_mandatary_insertid'     => 'no',
    'fields_map'                => array(
        "Landline2"       => "value", 
        "listings_id"   => "object_id"
    ),
    'default_values'            => array(
        "object_type"   => "App\Listing", 
        "type"          => "landline"
    ),
);



// $ajimport_config['childtables'][] = array('name' => 'listing_category',
//     'is_mandatary_insertid'                          => 'no',
//     'fields_map'                                     => array("listings_id" => "listing_id"), //'temp table field'=>'child table field'
//     'default_values'                                 => array("object_type" => "App\Listing", "type" => "email"), //array("user communication column name"=>"default value for the column")
//     'commafield_to_multirecords'                     => array('Business_Details' => 'category_id'), //Does not support for multiple comma seperated fields into new records as array here. If more than one field is of type comma seperated and needs to be seperate records, add it as seperate childtable record
//     'default_values'                                 => array("core" => "1"), //array("user communication column name"=>"default value for the column")
// );

/* End Add Child tables here */

return $ajimport_config;
