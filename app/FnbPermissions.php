<?php


function routePermission(){
	
	$configPermission =[

		'admin_owner_auth_check' =>	
			
			[
				//jobs permission
				'jobs/create'=>['add_job'],					
				'jobs/store'=>['add_job'],
				'jobs/{reference_id}/{step?}'=>['add_job'], 
				'jobs/update'=>['edit_job'],

				//listing


				//admin jobs permission
 				'admin-dashboard/jobs/manage-jobs'=>['manage_job_status','manage_job_view'],
			 	'admin-dashboard/jobs/get-jobs'=>['manage_job_status','manage_job_view'],
			 	'admin-dashboard/jobs/update-job-status'=>['manage_job_status'],
			 	'admin-dashboard/jobs/bulk-update-job-status'=>['manage_job_status'],
			],

		'normal_user_check' =>
			[	
	 
			],

		// 'public_access' =>
		// 	[	
		// 		//jobs permission
		// 		'jobs/{job}'=>['read_job'],
		// 	]
					


					
	];


	return $configPermission;
}

function hasAccess($uriPath,$objectId){

	$routePerrmissions = routePermission();
	$route = explode('/', $uriPath);
	$access = false;
	$adminOwnerCheck = true;

	foreach ($routePerrmissions as $permissionType => $routePerrmission) {
		if(isset($routePerrmission[$uriPath])){
			$uriPermission = $routePerrmission[$uriPath];
			break;
		}

	}

	//is owner/admin 
	if($permissionType == 'admin_owner_auth_check'){   
		
		$tableConfig = routeModalConfig();
		$tableData = $tableConfig[$route[0]];
		 
		if(!isAdmin() && !isOwner($tableData['table'],$tableData['id'],$tableData['user'],$objectId))
			$access = false;
		else
			$access = true;
	}
 	
 	if(!$access && !empty($uriPermission)){    //check for permission
		 
		if(!hasPermission($uriPermission))
		 	$access = false;
		else
			$access = true;

	}

	return $access;
}

function hasPermission($uriPermission){
	if(Auth::check() && Auth::user()->hasAnyPermission($uriPermission))
        return true;
    else
        return false;
}
 

function isOwner($table,$referenceKey,$userReferenceKey,$referenceId){
	
	$isOwner = \DB::select('select *  from  '.$table.' where '.$referenceKey.' ="'.$referenceId.'" and '.$userReferenceKey.'='.Auth::user()->id);

	return (!empty($isOwner)) ? true :false;
}


function isAdmin()
{
    if(Auth::check() && Auth::user()->hasRole('superadmin'))
        return true;
    else
        return false;

}
 

function routeModalConfig(){

	$config = [
				'jobs' => ['table' => 'jobs', 'id' =>'reference_id' ,'user' =>'job_creator'],
				'listing' => ['table' => 'listings', 'id' =>'reference','user' =>'job_creator'],
				];

	return $config;
}




