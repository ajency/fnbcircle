<?php

$ajimport_msg_config['file_permission_check'] = array(
    'message' => '"<br/> Checking the file permissions ...."');
$ajimport_msg_config['pending_job_check'] = array(
    'message'     => 'Checking for pending import',
    'success_msg' => ' - Success ',
    'failure_msg' => ' - Failed',
);
$ajimport_msg_config['table_exists_check'] = array(
    'message'     => '',
    'success_msg' => '',
    'failure_msg' => '',
);
$ajimport_msg_config['pending_job_exists'] = array(
    'message' => 'There are pending jobs from previous import to be processed!! <br/> Please try after some time.',

);

$ajimport_msg_config['validate_file'] = array(
    'message'     => 'Validating the details',
    'success_msg' => ' - Success ',
    'failure_msg' => ' - Failed',
);
$ajimport_msg_config['mandatory_fields_empty'] = array(
    'message' => 'Mandatary fields are empty');
$ajimport_msg_config['download_temp_file'] = array(
    'message' => "View the csv import data from ready table. <br/>",
    'display' => false,
);
$ajimport_msg_config['run_import_job_queue'] = array(
    'message' => '<br>Listing Import is under process in background, you will receive an email with the upload status once done.', //*<b>Note: Please run this command to complete the import of data: <br/> \'php artisan queue:work --queue=validateunique,insert_records ajfileimportcon\'  </b>',*/

    'display' => true);
$ajimport_msg_config['config_tables_not_found'] = array(
    'message' => 'Following Tables mentioned in config file do not exists in database. <br/>',
);

return $ajimport_msg_config;
