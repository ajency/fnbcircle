<?php
 
return [

    //job alert config 
    'job_alert_published_date_from' => date('Y-m-d',strtotime("-1 days")),
    'job_alert_published_date_to' => date('Y-m-d',strtotime("-1 days")),
 
 
    'email_to' => 'admin@fnbcircle.com',
    'email_from' => 'admin@fnbcircle.com',
    'email_from_name' => 'FnBCircle Admin',
 
    /* Dev Mode */
    'email_from_dev' => 'admin@fnbcircle.com',
    'email_to_dev' => ['harshita@ajency.in','rahul@pizzasquare.in','meha@ajency.in'], // ['harshita@ajency.in', 'valenie@ajency.in'],
    'email_cc_dev' => [], // ['prajay@ajency.in', 'sharath@ajency.in', 'shashank@ajency.in'],
    'email_bcc_dev' => [],

    'sms_to_dev' => ['+918806724695'],
    'sms_to_dev_array' => env('SMS_TO_DEV_ARRAY', false), // IF false, will take 1st no, else will take all the No

    'app_dev_envs' => ['local', 'development'],

    'user_state_cookie_expiry' => 45000,
 

    'send_email_dev' => env('SEND_EMAIL_DEV', true), // If true, Email will be sent, else will not send Email -> ONLY on DEV mode, else Email will be sent in Production mode
    'send_sms_dev' => env('SEND_SMS_DEV', true), // IF true, SMS will be sent, else will not send SMS -> ONLY on DEV mode, else SMS will be sent in Production mode

    'send_delay_dev' => 2, // In mins -> This delay will be used in Email / SMS sending
 	/* Dev Mode Ends */

    'google-analytics' => env('GOOGLE_ANALYTICS_ID','UA-112473904-1'),
];
 
