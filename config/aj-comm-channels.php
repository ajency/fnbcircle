<?php
return [
    "email" => ["provider" => "laravel" , "password" => "" , "username" => "", 'from_address'=>'admin@fnbcircle.com', 'from_name'=>'FnBCircle Admin'],
    "sms" => ["provider" => "smsgupshup" , "password" =>env('sms_gupshup_password','') , "username" => env('sms_gupshup_username','')],
    "web-push" => ["provider" => "pushcrew" , "password" => "" , "username" => ""],
    "email-internal" => ["provider" => false , "password" => "" , "username" => ""],
    "email-promotional" => ["provider" => false , "password" => "" , "username" => ""],
    "sms-promotional" => ["provider" => false , "password" => "" , "username" => ""]
];
