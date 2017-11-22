<?php
 
return [

    //job alert config 
    'job_alert_published_date_from' => date('Y-m-d',strtotime("-1 days")),
    'job_alert_published_date_to' => date('Y-m-d',strtotime("-1 days")),
 
 
    'email_to' => 'nutan@ajency.in',
    'email_from' => 'nutan@ajency.in',
    'email_from_name' => 'Nutan',
 
    /* Dev Mode */
    'email_from_dev' => 'nutan@ajency.in',
    'email_to_dev' => ['harshita@ajency.in'],
    'email_cc_dev' => ['prajay@ajency.in', 'sharath@ajency.in'],
    'email_bcc_dev' => [],

    'app_dev_envs' => ['local', 'development'],
 
    'user_state_cookie_expiry' => 45000,
    
 
 
];
 
