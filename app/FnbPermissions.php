<?php

/**
define permission set for each route and ui element
"admin_owner_auth_check" will include permission which checks if logged in user is admin or owner of the model
"normal_user_check" whill skip admin/owner check
**/

function routePermission(){
	
	$routePermission =[

		'admin_owner_auth_check' =>	
			
			[
				//jobs permission
				'jobs/create'=>['add_job'],					
				'jobs/store'=>['add_job'],
				'jobs/{reference_id}/{step?}'=>['edit_job'], 
				'jobs/update'=>['edit_job'],

				
				//listing


				//admin jobs permission
 				'admin-dashboard/jobs/manage-jobs'=>['manage_job_status','manage_job_view'],
			 	'admin-dashboard/jobs/get-jobs'=>['manage_job_status','manage_job_view'],
			 	'admin-dashboard/jobs/update-job-status'=>['manage_job_status'],
			 	'admin-dashboard/jobs/bulk-update-job-status'=>['manage_job_status'],


			 	//ui element
				'submit_review_element_cls'=>['submit_for_review_job','submit_for_review_listing'],
				'edit_permission_element_cls'=>['edit_job','edit_listing'],
			],

		'normal_user_check' =>
			[						
				'delete_element_cls'=>['delete_job_contact'],					
				'status_element_cls'=>['change_job_status'],	
			],

		// 'public_access' =>
		// 	[	
		// 		//jobs permission
		// 		'jobs/{job}'=>['read_job'],
		// 	]
										
	];


	return $routePermission;
}
 
/**
checks if user has access to the page or ui element by passing page uri or ui elemnt class
$uriPath - page uri / ui elemnt class
$objectId - model id
$tableReference - pass table reference key defined in routeModelConfig (only in case of ui element)

if permissions not defined hasAccess will return true
**/

function hasAccess($uriPath,$objectId,$tableReference){
	
	$routePerrmissions = routePermission();
	
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
		
		$tableConfig = routeModelConfig();
		$tableData = $tableConfig[$tableReference];
		 
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
	elseif (empty($uriPermission)) { //if no permission set
		$access = true;
	}
	 
	return $access;
}

/***
checks if user has permission 
$uriPermission : array of permission
**/

function hasPermission($uriPermission){
	if(Auth::check() && Auth::user()->hasAnyPermission($uriPermission))
        return true;
    else
        return false;
}
 
/***
checks if model belongs to the logged in user
$table : table name (set in routeModelConfig())
$referenceKey : coloumn name to find entry in  table (eg : id ,reference_id)
$referenceId : object id of table
$userReferenceKey : user coloumn name in the table (eg : user_id ,owner_id)

**/
function isOwner($table,$referenceKey,$userReferenceKey,$referenceId){
	// var_dump('select *  from  '.$table.' where '.$referenceKey.' ="'.$referenceId.'" and '.$userReferenceKey.'='.Auth::user()->id);
	$isOwner = \DB::select('select *  from  '.$table.' where '.$referenceKey.' ="'.$referenceId.'" and '.$userReferenceKey.'='.Auth::user()->id);

	return (!empty($isOwner)) ? true :false;
}

/***
checks if logged in user is admin
 
**/
function isAdmin()
{
    if(Auth::check() && Auth::user()->hasRole('superadmin'))
        return true;
    else
        return false;

}
 
/***
set table config
$key : first element in the route (eg jobs/create)
table : name of the table
id : column name of whose referenece id is passed in url (eg jobs/{reference_id})
user : user coloumn name in the table
 
**/
function routeModelConfig(){

	$config = [
				'jobs' => ['table' => 'jobs', 'id' =>'reference_id' ,'user' =>'job_creator'],
				'listing' => ['table' => 'listings', 'id' =>'reference','user' =>'job_creator'],
				];

	return $config;
}




