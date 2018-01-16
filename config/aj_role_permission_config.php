<?php
	/* 
		"roles" ->  Array of Role names to be generated,
		"permissions" -> Array of Permission names to be generated
		"roles_permissions" -> [Array having
			array("role" => < Array index of the role in "roles", "permissions" => [array of <indexes of permssion> from "permissions"])
		]
		
		Example:
		[
			"roles" => [0 => "superadmin", 1 => "admin", 2 => "member"],
			"permissions" => [0 => "add_users", 1 => "edit_users", 2 => "add_personal", 3 => "edit_personal", 4 => "add_internal", 5 => "edit_internal"],
			"roles_permissions" => [
				"roles" => 0, "permissions" => [0, 1, 2, 3, 4, 5],
				"roles" => 1, "permissions" => [0, 1, 2, 3],
				"roles" => 2, "permissions" => [2, 3]
			]
		]
	*/
	return [
		"roles" => [0 => 'superadmin', 1 => 'listing_manager', 2 => 'customer'],
		"permissions" => [
			0 => 'add_internal_user', 1 => 'edit_internal_user', 2 => 'view_internal_user_list', 
			3 => 'add_listing', 4 => 'edit_listing', 5 => 'manage_categories', 
			6 => 'manage_locations', 7 => 'listing_approval', 8 => 'add_job', 
			9 => 'edit_job', 10 => 'manage_job_status', 11 => 'manage_job_view', 
			12 => 'submit_for_review_job', 13 => 'delete_job_contact', 14 => 'change_job_status'
		],
		"roles_permissions" => [
            ["role" => 0, "permissions" => [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14]],
            ["role" => 1, "permissions" => [3, 4, 7, 9, 10]],
            ["role" => 2, "permissions" => []]
        ]
	];