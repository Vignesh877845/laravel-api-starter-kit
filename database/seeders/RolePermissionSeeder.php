<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!config('features.roles_permission')) {
            $this->command->warn('Roles & Permissions feature is disabled in features.php. Skipping seed...');
            return;
        }

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissionsByModule = [
            'User Management'   => ['user-list', 'user-create', 'user-edit', 'user-delete'],
            'Role Management'   => ['role-list', 'role-create', 'role-edit', 'role-delete'],
            'Core'              => ['view-dashboard', 'update-profile', 'view-reports'],
        ];

        $this->command->info('Creating permissions...');

        foreach ($permissionsByModule as $module => $perms){
            foreach ($perms as $permission) {
                Permission::findOrCreate($permission, 'api');
            }
            $this->command->info("Created permissions for module: $module");
        }

        $this->command->info('Creating Roles...');

        $superAdminRole = Role::findOrCreate('Super Admin', 'api');
        $superAdminRole->syncPermissions(Permission::all());

        $userRole = Role::findOrCreate('User', 'api');
        $userRole->syncPermissions(['view-dashboard', 'update-profile']);

        $this->command->info('Roles and permissions seeded successfully!');

    }
}
