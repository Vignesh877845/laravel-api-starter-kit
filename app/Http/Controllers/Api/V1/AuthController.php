<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Auth\LoginRequest;
use App\Http\Requests\Api\V1\Auth\RegisterRequest;
use App\Http\Requests\Api\V1\Auth\UpdateProfileRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use App\Traits\ApiResponses as ApiResponseTraits;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use ApiResponseTraits;

    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request)
    {
        try {
            $user = $this->authService->register($request->validated());
            return $this->success(UserResource::make($user), 'User registered successfully', 201);
        } catch (\Exception $e) {
            return $this->error('Registration failed: ' . $e->getMessage(), 500);
        }
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();
        $data = $this->authService->login($credentials['username'], $credentials['password']);

        if (!$data) {
            return $this->error('Invalid credentials', 401);
        }

        return $this->success([
            'user' => UserResource::make($data['user']),
            'token' => $data['token']
        ], 'Login successful');
    }

    public function me(Request $request)
    {
        return $this->success(UserResource::make($request->user()), 'User details retrieved successfully');
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $user = $this->authService->updateProfile($request->user(), $request->validated());
        return $this->success(UserResource::make($user), 'Profile updated successfully');
    }
    
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return $this->success([], 'Logged out successfully');
    }

    public function logoutForAllDevices(Request $request)
    {
        $this->authService->logoutFromAllDevices($request->user());
        return $this->success([], 'Logged out from all devices successfully');
    }
}