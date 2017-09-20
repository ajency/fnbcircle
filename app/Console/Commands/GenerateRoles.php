<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class GenerateRoles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:role-permissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generating Roles & Permissions';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function assignPermissionToRole($role_obj, $permission = '') {
        $permission_obj = Permission::where("name", $permission)->first(); // Check if Permission exist

        if(!$permission_obj) { // Create Permission if it doesn't exist
            Permission::create(["name" => $permission]);
        }

        return $role_obj->givePermissionTo($permission);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        $roles = ['superadmin', 'listing_manager', 'customer'];
        $permissions = ['add_internal_user', 'edit_internal_user', 'view_internal_user_list', 'add_listing', 'edit_listing', 'manage_categories', 'manage_locations', 'listing_approval', 'add_job', 'edit_job'];

        $role_permissions = [
            ["role" => 0, "permissions" => [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]],
            ["role" => 1, "permissions" => [3, 4, 7]],
            ["role" => 2, "permissions" => [3, 4, 8, 9]]
        ];

        foreach ($role_permissions as $keyRP => $valueRP) {
            $role = Role::where("name", $roles[$valueRP["role"]])->first(); // Find the Role else is null

            if(!$role) { // If null
                $role = Role::create(["name" => $roles[$valueRP["role"]]]); // Create Role if it doesn't exist
                $this->info("Created Role: " . $roles[$valueRP["role"]]);
            }

            foreach ($valueRP["permissions"] as $keyP => $valueP) { // Map Permissions to the Role
                $this->assignPermissionToRole($role, $permissions[$valueP]);
            }
        }

        $this->info("Roles & it's Permissions created successfully");
        return;
    }
}
