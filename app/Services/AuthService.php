<?php

namespace App\Services;


use App\Models\User;
use App\Models\UserCredential;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

use Exception;

class AuthService
{
    public function register(array $data): User
    {
        DB::beginTransaction();

        try {
            $user = User::create([
                'name'      => $data['name'],
                'email'     => $data['email'],
                'phone'     => $data['phone'] ?? null,
                'status'    => 'active',
            ]);

            $user->credential()->create([
                'username'  => $data['username'] ?? null,
                'provider'  => 'local',
                'password'  => Hash::make($data['password']),
            ]);
            
            if(config('features.roles_permission')){
                $user->assignRole('User');
            }

            DB::commit();

            return $user;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Registration failed: ' . $e->getMessage());
            throw new Exception('Registration failed. Please try again.');
        }
    }

    public function login(string $identifier, string $password): ?array
    {
        $credential = UserCredential::with('user')
            ->where('username', $identifier)
            ->orWhereHas('user', function ($q) use ($identifier) {
                $q->where('email', $identifier);
            })->first();

        if (!$credential || !Hash::check($password, $credential->password)) {
            return null;
        }

        $credential->update(['last_login_at' => now()]);

        $user = $credential->user;

        if(config('features.roles_permission')){
            $user->load('roles', 'permissions');
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return ['user' => $user, 'token' => $token];
    }

    public function updateProfile(User $user, array $data): User
    {
        unset($data['password']);
        $user->update($data);
        
        if($user->wasChanged('email')){
            $user->tokens()->delete();
        }

        return $user;
    }

    public function logout($user): bool
    {
        return $user->currentAccessToken()->delete();
    }

    public function logoutFromAllDevices($user): bool
    {
        return (bool) $user->tokens()->delete();
    }
}