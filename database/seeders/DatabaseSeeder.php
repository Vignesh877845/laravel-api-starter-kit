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
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'phone' => '9876543210',
            'status' => 'active',
        ]);

        UserCredential::create([
            'user_id' => $admin->id,
            'username' => 'admin',
            'provider' => 'local',
            'password' => Hash::make('password'),
            'last_login_at' => now(),
        ]);

        echo "✅ Admin User Created: admin@example.com / password \n";

        // User::factory(10)->has(UserCredential::factory())->create();

        echo "✅ 1 Sample User Created with Credentials \n";
    }
}
