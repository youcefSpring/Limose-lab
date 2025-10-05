<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\UpdateProfileRequest;
use App\Models\User;
use App\Services\AuthenticationService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function __construct(
        private AuthenticationService $authService
    ) {}

    /**
     * Display a listing of users (Admin only)
     * GET /api/v1/users
     */
    public function index(Request $request): JsonResponse
    {
        if (!auth()->user()->isAdmin()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Access denied',
                'code' => 'INSUFFICIENT_PERMISSIONS'
            ], 403);
        }

        $filters = $request->only(['search', 'role', 'status']);
        $perPage = min($request->input('per_page', 15), 100);

        $users = $this->authService->getUsers($filters, $perPage);

        return response()->json([
            'status' => 'success',
            'data' => [
                'users' => $users->items(),
                'pagination' => [
                    'current_page' => $users->currentPage(),
                    'total_pages' => $users->lastPage(),
                    'total_items' => $users->total(),
                    'per_page' => $users->perPage(),
                    'has_next_page' => $users->hasMorePages(),
                    'has_previous_page' => $users->currentPage() > 1,
                ]
            ]
        ]);
    }

    /**
     * Store a newly created user
     * POST /api/v1/users
     */
    public function store(RegisterRequest $request): JsonResponse
    {
        if (!auth()->user()->isAdmin()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Access denied',
                'code' => 'INSUFFICIENT_PERMISSIONS'
            ], 403);
        }

        $result = $this->authService->register($request->validated());

        return response()->json([
            'status' => 'success',
            'data' => [
                'user' => $result['user']
            ],
            'message' => 'User created successfully'
        ], 201);
    }

    /**
     * Display the specified user
     * GET /api/v1/users/{id}
     */
    public function show(Request $request, User $user): JsonResponse
    {
        $currentUser = auth()->user();

        // Users can only view their own profile unless they're admin
        if (!$currentUser->isAdmin() && $currentUser->id !== $user->id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Access denied',
                'code' => 'INSUFFICIENT_PERMISSIONS'
            ], 403);
        }

        $profile = $this->authService->getUserProfile($user);

        return response()->json([
            'status' => 'success',
            'data' => [
                'user' => $profile
            ]
        ]);
    }

    /**
     * Update the specified user
     * PUT /api/v1/users/{id}
     */
    public function update(UpdateProfileRequest $request, User $user): JsonResponse
    {
        $currentUser = auth()->user();

        // Users can only update their own profile unless they're admin
        if (!$currentUser->isAdmin() && $currentUser->id !== $user->id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Access denied',
                'code' => 'INSUFFICIENT_PERMISSIONS'
            ], 403);
        }

        $updatedUser = $this->authService->updateProfile($user, $request->validated());

        return response()->json([
            'status' => 'success',
            'data' => [
                'user' => $updatedUser
            ],
            'message' => 'User updated successfully'
        ]);
    }

    /**
     * Remove the specified user
     * DELETE /api/v1/users/{id}
     */
    public function destroy(Request $request, User $user): JsonResponse
    {
        if (!auth()->user()->isAdmin()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Access denied',
                'code' => 'INSUFFICIENT_PERMISSIONS'
            ], 403);
        }

        // Prevent admin from deleting themselves
        if (auth()->id() === $user->id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Cannot delete your own account',
                'code' => 'CANNOT_DELETE_SELF'
            ], 422);
        }

        $this->authService->deleteUser($user);

        return response()->json([
            'status' => 'success',
            'message' => 'User deleted successfully'
        ]);
    }

    /**
     * Update user status (Admin only)
     * PUT /api/v1/users/{id}/status
     */
    public function updateStatus(Request $request, User $user): JsonResponse
    {
        if (!auth()->user()->isAdmin()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Access denied',
                'code' => 'INSUFFICIENT_PERMISSIONS'
            ], 403);
        }

        $request->validate([
            'status' => 'required|in:active,inactive,suspended'
        ]);

        $this->authService->updateUserStatus($user, $request->status);

        return response()->json([
            'status' => 'success',
            'message' => 'User status updated successfully'
        ]);
    }

    /**
     * Get user statistics (Admin only)
     * GET /api/v1/users/statistics
     */
    public function statistics(Request $request): JsonResponse
    {
        if (!auth()->user()->isAdmin()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Access denied',
                'code' => 'INSUFFICIENT_PERMISSIONS'
            ], 403);
        }

        $stats = $this->authService->getUserStatistics();

        return response()->json([
            'status' => 'success',
            'data' => [
                'statistics' => $stats
            ]
        ]);
    }
}