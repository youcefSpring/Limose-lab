<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\ChangePasswordRequest;
use App\Services\AuthenticationService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function __construct(
        private AuthenticationService $authService
    ) {}

    /**
     * User login
     * POST /api/v1/auth/login
     */
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $result = $this->authService->authenticate(
                $request->validated() + ['device_name' => $request->input('device_name', 'api')]
            );

            return response()->json([
                'status' => 'success',
                'data' => [
                    'user' => [
                        'id' => $result['user']->id,
                        'name' => $result['user']->name,
                        'email' => $result['user']->email,
                        'role' => $result['user']->role,
                        'status' => $result['user']->status,
                        'permissions' => $result['user']->getAllPermissions()->pluck('name'),
                    ],
                    'token' => $result['token'],
                    'token_type' => 'Bearer',
                    'expires_in' => 7200, // 2 hours
                ]
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid credentials',
                'code' => 'INVALID_CREDENTIALS'
            ], 401);
        }
    }

    /**
     * User logout
     * POST /api/v1/auth/logout
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out'
        ]);
    }

    /**
     * Refresh token
     * POST /api/v1/auth/refresh
     */
    public function refresh(Request $request): JsonResponse
    {
        $user = $request->user();

        // Delete current token
        $request->user()->currentAccessToken()->delete();

        // Create new token
        $token = $user->createToken($request->input('device_name', 'api'))->plainTextToken;

        return response()->json([
            'status' => 'success',
            'data' => [
                'token' => $token,
                'token_type' => 'Bearer',
                'expires_in' => 7200,
            ]
        ]);
    }

    /**
     * Get authenticated user profile
     * GET /api/v1/auth/me
     */
    public function me(Request $request): JsonResponse
    {
        $user = $request->user();
        $profile = $this->authService->getUserProfile($user);

        return response()->json([
            'status' => 'success',
            'data' => [
                'user' => $profile
            ]
        ]);
    }

    /**
     * Update user profile
     * PUT /api/v1/auth/profile
     */
    public function updateProfile(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|regex:/^\+[1-9]\d{1,14}$/',
        ]);

        $user = $request->user();
        $updatedUser = $this->authService->updateProfile($user, $request->validated());

        return response()->json([
            'status' => 'success',
            'data' => [
                'user' => $updatedUser
            ]
        ]);
    }

    /**
     * Change password
     * POST /api/v1/auth/change-password
     */
    public function changePassword(ChangePasswordRequest $request): JsonResponse
    {
        $user = $request->user();

        // Verify current password
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Current password is incorrect',
                'errors' => [
                    'current_password' => ['كلمة المرور الحالية غير صحيحة']
                ]
            ], 422);
        }

        $this->authService->changePassword($user, $request->password);

        return response()->json([
            'status' => 'success',
            'message' => 'Password changed successfully'
        ]);
    }

    /**
     * Request password reset
     * POST /api/v1/auth/forgot-password
     */
    public function forgotPassword(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $this->authService->sendPasswordResetLink($request->email);

        return response()->json([
            'status' => 'success',
            'message' => 'Password reset link sent to your email'
        ]);
    }

    /**
     * Reset password
     * POST /api/v1/auth/reset-password
     */
    public function resetPassword(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required|string',
            'password' => 'required|min:8|confirmed',
        ]);

        try {
            $this->authService->resetPassword($request->validated());

            return response()->json([
                'status' => 'success',
                'message' => 'Password reset successfully'
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid or expired reset token',
                'code' => 'INVALID_RESET_TOKEN'
            ], 422);
        }
    }

    /**
     * Register new user (Admin only)
     * POST /api/v1/auth/register
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        if (!auth()->user()->isAdmin()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Access denied',
                'code' => 'INSUFFICIENT_PERMISSIONS'
            ], 403);
        }

        try {
            $result = $this->authService->register($request->validated());

            return response()->json([
                'status' => 'success',
                'data' => [
                    'user' => [
                        'id' => $result['user']->id,
                        'name' => $result['user']->name,
                        'email' => $result['user']->email,
                        'role' => $result['user']->role,
                        'status' => $result['user']->status,
                    ]
                ],
                'message' => 'User registered successfully'
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Registration failed',
                'errors' => $e->errors()
            ], 422);
        }
    }

    /**
     * Get user permissions
     * GET /api/v1/auth/permissions
     */
    public function permissions(Request $request): JsonResponse
    {
        $user = $request->user();
        $permissions = $this->authService->getUserPermissions($user);

        return response()->json([
            'status' => 'success',
            'data' => [
                'permissions' => $permissions
            ]
        ]);
    }
}