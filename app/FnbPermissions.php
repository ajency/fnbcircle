<?php


function routePermission(){
	
	$configPermission =[	
					//jobs permission
					'jobs/create'=>['job_add'],					
					'jobs/store'=>['job_add'],
					'jobs/edit'=>['job_edit'], 
					'jobs/update'=>['job_edit'], 
					'jobs/show'=>['read_job','job_add','job_edit'],


					//admin jobs permission
	 				'admin-dashboard/jobs/manage-jobs'=>['manage_job_status','manage_job_view'],
				 	'admin-dashboard/jobs/get-jobs'=>['manage_job_status','manage_job_view'],
				 	'admin-dashboard/jobs/update-job-status'=>['manage_job_status'],
				 	'admin-dashboard/jobs/bulk-update-job-status'=>['manage_job_status'],
				];


	return $configPermission;
}




