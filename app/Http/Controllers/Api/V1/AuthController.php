<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
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
        $data = $this->authService->login($credentials['identifier'], $credentials['password']);

        if (!$data) {
            return $this->error('Invalid credentials', 401);
        }

        return $this->success([
            'user' => UserResource::make($data['user']),
            'token' => $data['token']
        ], 'Login successful');
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return $this->success([], 'Logged out successfully');
    }

    public function me(Request $request)
    {
        return $this->success(UserResource::make($request->user()), 'User details retrieved successfully');
    }
}