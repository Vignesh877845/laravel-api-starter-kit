<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserCredential;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,
        ]);

        $admin = User::create([
            'name'      => 'Super Admin',
            'email'     => 'superadmin@example.com',
            'phone'     => '9876543210',
            'status'    => 'active',
        ]);

        UserCredential::create([
            'user_id'       => $admin->id,
            'username'      => 'superadmin',
            'provider'      => 'local',
            'password'      => Hash::make('password'),
            'last_login_at' => now(),
        ]);

        $user = User::create([
            'name'      => 'Test User',
            'email'     => 'user@example.com',
            'phone'     => '9876543211',
            'status'    => 'active',
        ]);

        UserCredential::create([
            'user_id'   => $user->id,
            'username'  => 'testuser',
            'provider'  => 'local',
            'password'  => Hash::make('password'),
        ]);

        if (config('features.roles_permission')) {
            $admin->assignRole('Super Admin');
            $user->assignRole('User');
            $this->command->info('Roles Assigned: Super Admin and User');
        } else {
            $this->command->warn('Roles feature disabled. Users created without roles.');
        }

        // User::factory(10)->has(UserCredential::factory())->create();
        $this->command->info('Super Admin User Created: superadmin@example.com / password');
        $this->command->info('Test User Created: user@example.com / password');
    }
}
