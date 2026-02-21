<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserCredential>
 */
class UserCredentialFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'username' =>  fake()->unique()->userName(),
            'provider' => 'local',
            'password' => Hash::make('password'),
            'last_login_at' => now(),
        ];
    }
}
