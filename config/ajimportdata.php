<?php

$ajimport_config['filetype']  = "csv";
$ajimport_config['delimiter'] = ",";
$ajimport_config['batchsize'] = "100";
$ajimport_config['recipient'] = "parag@ajency.in";


$ajimport_config['temptablename'] = 'aj_import_temp';
//$ajimport_config['filepath']  = resource_path('uploads') . "/filetoimport.csv";

//$ajimport_config['fileheader'] = array('seq', 'first', 'last', 'age', 'street', 'city', 'state', 'zip', 'email');

// $ajimport_config['fileheader'] = array('Id', 'Company Name', 'Add', 'City', 'Pin Code', 'Reference', 'State', 'Phone1', 'Phone2', 'Mobile1', 'Mobile2', 'Email1', 'Email2', 'Year', 'Web', 'Business Type', 'Business Details');
$ajimport_config['fileheader'] = array('BusinessName', 'BusinessType', 'City', 'Email1', 'Email2', 'Mobile1', 'Mobile2', 'Landline1', 'Landline2', 'CoreCategory1', 'CoreCategory1_id', 'CoreCategory2', 'CoreCategory2_id', 'CoreCategory3', 'CoreCategory3_id', 'CoreCategory4', 'CoreCategory4_id', 'CoreCategory5', 'CoreCategory5_id', 'CoreCategory6',   'CoreCategory6_id',    'CoreCategory7',   'CoreCategory7_id',    'CoreCategory8',   'CoreCategory8_id',    'CoreCategory9',   'CoreCategory9_id',    'CoreCategory10',  'CoreCategory10_id',   'Brand1',  'Brand1_id',   'Brand2',  'Brand2_id',   'Brand3',  'Brand3_id',   'Brand4',  'Brand4_id',   'Brand5',  'Brand5_id',   'Brand6',  'Brand6_id',   'Brand7',  'Brand7_id',   'Brand8',  'Brand8_id',   'Brand9',  'Brand9_id',   'Brand10', 'Brand10_id',  'DisplayAddress',  'AreaOfOperation1',    'AreaOfOperation1_id', 'AreaOfOperation2',    'AreaOfOperation3',    'AreaOfOperation4',    'AreaOfOperation5',    'AreaOfOperation6',    'AreaOfOperation7',    'AreaOfOperation8',    'AreaOfOperation9',    'AreaOfOperation10',   'BusinessDescription', 'BusinessHighlights', 'YearofEstablishment',   'BusinessWebsite',    'PaymentMode1',    'PaymentMode2',    'PaymentMode3',    'PaymentMode4',    'PaymentMode5',    'PaymentMode6',    'PaymentMode7',    'PaymentMode8',   'PaymentMode9');
 

$ajimport_config['childtables'][] = array('name' => 'users',
    // 'insertid_temptable'  => 'stateid', // 'Field to be added to temp table to store id of insertion record to child table'
    'insertid_childtable'                            => 'id',
    'is_mandatary_insertid'                          => 'yes',
    /*'insertid_mtable'     => 'owner_id' ,*/
    'insertid_temptable'                             => array('users_id' => 'id'),
    'fields_map_to_update_temptable_child_id'        => array("Email1" => "email"),
    'fields_map'                                     => array("Email1" => "email")); //'temp table field'=>'child table field')

$ajimport_config['childtables'][] = array('name' => 'cities',
    // 'insertid_temptable'  => 'stateid', // 'Field to be added to temp table to store id of insertion record to child table'
    'insertid_childtable'                            => 'id',
    'is_mandatary_insertid'                          => 'yes',
    /*'insertid_mtable'     => 'city_id' ,*/
    'insertid_temptable'                             => array('cities_id' => 'id'),
    'fields_map_to_update_temptable_child_id'        => array("State" => "name"),
    'fields_map'                                     => array("State" => "name","state_slug"=>"slug"),
    'field_slug'                                     => array('State'=>'state_slug')//   array('temp table field from which slug will be created'=>'additinoal field on tempp table for the slug')
    ); //'temp table field'=>'child table field'


$ajimport_config['childtables'][] = array('name' => 'areas',
    // 'insertid_temptable'  => 'stateid', // 'Field to be added to temp table to store id of insertion record to child table'
    'insertid_childtable'                            => 'id',
    'is_mandatary_insertid'                          => 'yes',
    /*'insertid_mtable'     => 'locality_id' ,*/
    'insertid_temptable'                             => array('areas_id' => 'id'),
    'fields_map_to_update_temptable_child_id'        => array("City" => "name", "cities_id" => "city_id"),
    'fields_map'                                     => array("City" => "name", "cities_id" => "city_id"), //'temp table field'=>'child table field'
);

// user communication one for phone after user entry
$ajimport_config['childtables'][] = array('name' => 'user_communications',
    'is_mandatary_insertid'                          => 'no',
    'fields_map'                                     => array("Phone1" => "value", "users_id" => "object_id"), //'temp table field'=>'child table field'
    'default_values'                                 => array("object_type" => "App\User", "type" => "mobile"), //array("user communication column name"=>"default value for the column")
);

// user communication one for email after user entry

$ajimport_config['childtables'][] = array('name' => 'user_communications',
    'is_mandatary_insertid'                          => 'no',
    'fields_map'                                     => array("Email1" => "value", "users_id" => "object_id"), //'temp table field'=>'child table field'
    'default_values'                                 => array("object_type" => "App\User", "type" => "email"), //array("user communication column name"=>"default value for the column")
);

$ajimport_config['childtables'][] = array('name' => 'listings',
    // 'insertid_temptable'  => 'stateid', // 'Field to be added to temp table to store id of insertion record to child table'
    'insertid_childtable'                            => 'id',
    'is_mandatary_insertid'                          => 'yes',
    //'insertid_mtable'     => 'locality_id' ,
    'insertid_temptable'                             => array('listings_id' => 'id'),
    'fields_map_to_update_temptable_child_id'        => array("Company_Name" => "title", "areas_id" => "locality_id", "users_id" => "owner_id"),
    'fields_map'                                     => array("Company_Name" => "title", "Add"     => "display_address",
                                                              "Business_Type"=> "type", "areas_id" => "locality_id", "users_id" => "owner_id",
                                                              "Reference"    => "reference",
                                                          ), //'temp table field'=>'child table field'
    'columnupdatevalues'                             => array('Business_Type' => array("Wholeseller" => 11, "Retailer" => 12, "Manufacturer" => 13)),

    /*serialize array form at array('column on tagle'=>array of values to be serialized where key will be a static provided by user and value will be field from temp table)    */
    'serializevalues'                                => array('other_details' => array('website' => 'Web', 'establish_year' => 'Year'),

    ),

);

// user communication one for phone after listings table  entry
$ajimport_config['childtables'][] = array('name' => 'user_communications',
    'is_mandatary_insertid'                          => 'no',
    'fields_map'                                     => array("Phone2" => "value", "listings_id" => "object_id"), //'temp table field'=>'child table field'
    'default_values'                                 => array("object_type" => "App\Listing", "type" => "phone2"), //array("user communication column name"=>"default value for the column")
);

// user communication one for phone after listings table  entry
$ajimport_config['childtables'][] = array('name' => 'user_communications',
    'is_mandatary_insertid'                          => 'no',
    'fields_map'                                     => array("Mobile1" => "value", "listings_id" => "object_id"), //'temp table field'=>'child table field'
    'default_values'                                 => array("object_type" => "App\Listing", "type" => "mobile1"), //array("user communication column name"=>"default value for the column")
);

// user communication one for phone after listings table  entry
$ajimport_config['childtables'][] = array('name' => 'user_communications',
    'is_mandatary_insertid'                          => 'no',
    'fields_map'                                     => array("Mobile2" => "value", "listings_id" => "object_id"), //'temp table field'=>'child table field'
    'default_values'                                 => array("object_type" => "App\Listing", "type" => "mobile2"), //array("user communication column name"=>"default value for the column")
);
// user communication one for phone after listings table  entry

$ajimport_config['childtables'][] = array('name' => 'user_communications',
    'is_mandatary_insertid'                          => 'no',
    'fields_map'                                     => array("Email2" => "value", "listings_id" => "object_id"), //'temp table field'=>'child table field'
    'default_values'                                 => array("object_type" => "App\Listing", "type" => "email"), //array("user communication column name"=>"default value for the column")
);

$ajimport_config['childtables'][] = array('name' => 'listing_category',
    'is_mandatary_insertid'                          => 'no',
    'fields_map'                                     => array("listings_id" => "listing_id"), //'temp table field'=>'child table field'
    'default_values'                                 => array("object_type" => "App\Listing", "type" => "email"), //array("user communication column name"=>"default value for the column")
    'commafield_to_multirecords'                     => array('Business_Details' => 'category_id'), //Does not support for multiple comma seperated fields into new records as array here. If more than one field is of type comma seperated and needs to be seperate records, add it as seperate childtable record
    'default_values'                                 => array("core" => "1"), //array("user communication column name"=>"default value for the column")
);

/* End Add Child tables here */

return $ajimport_config;
