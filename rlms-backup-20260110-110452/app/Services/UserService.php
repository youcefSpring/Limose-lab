<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class UserService
{
    /**
     * Create a new user (registration).
     *
     * @param array $data
     * @return User
     */
    public function createUser(array $data): User
    {
        // Handle avatar upload if provided
        if (isset($data['avatar'])) {
            $data['avatar'] = $this->uploadAvatar($data['avatar']);
        }

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone' => $data['phone'] ?? null,
            'avatar' => $data['avatar'] ?? null,
            'research_group' => $data['research_group'] ?? null,
            'bio' => $data['bio'] ?? null,
            'status' => 'pending', // All new users start as pending
            'locale' => $data['locale'] ?? 'en',
        ]);

        // Assign default role if provided
        if (isset($data['role'])) {
            $user->assignRole($data['role']);
        }

        return $user->fresh();
    }

    /**
     * Update user profile.
     *
     * @param User $user
     * @param array $data
     * @return User
     */
    public function updateUser(User $user, array $data): User
    {
        // Handle avatar upload if provided
        if (isset($data['avatar'])) {
            // Delete old avatar
            if ($user->avatar) {
                $this->deleteAvatar($user->avatar);
            }
            $data['avatar'] = $this->uploadAvatar($data['avatar']);
        }

        $user->update([
            'name' => $data['name'] ?? $user->name,
            'phone' => $data['phone'] ?? $user->phone,
            'avatar' => $data['avatar'] ?? $user->avatar,
            'research_group' => $data['research_group'] ?? $user->research_group,
            'bio' => $data['bio'] ?? $user->bio,
            'locale' => $data['locale'] ?? $user->locale,
        ]);

        return $user->fresh();
    }

    /**
     * Approve a pending user.
     *
     * @param User $user
     * @param string $role
     * @param NotificationService|null $notificationService
     * @return User
     */
    public function approveUser(User $user, string $role, ?NotificationService $notificationService = null): User
    {
        if (!$user->isPending()) {
            throw new \Exception('Only pending users can be approved');
        }

        DB::transaction(function () use ($user, $role) {
            $user->update(['status' => 'active']);
            $user->assignRole($role);
        });

        // Send notification
        if (!$notificationService) {
            $notificationService = app(NotificationService::class);
        }
        $notificationService->sendUserNotification($user, 'approved', ['role' => $role]);

        return $user->fresh();
    }

    /**
     * Reject a pending user.
     *
     * @param User $user
     * @param NotificationService|null $notificationService
     * @return bool
     */
    public function rejectUser(User $user, ?NotificationService $notificationService = null): bool
    {
        if (!$user->isPending()) {
            throw new \Exception('Only pending users can be rejected');
        }

        // Send notification before deletion
        if (!$notificationService) {
            $notificationService = app(NotificationService::class);
        }
        $notificationService->sendUserNotification($user, 'rejected');

        // Delete avatar if exists
        if ($user->avatar) {
            $this->deleteAvatar($user->avatar);
        }

        return $user->forceDelete(); // Permanently delete rejected users
    }

    /**
     * Suspend a user.
     *
     * @param User $user
     * @param Carbon|null $until
     * @param string|null $reason
     * @param NotificationService|null $notificationService
     * @return User
     */
    public function suspendUser(User $user, ?Carbon $until = null, ?string $reason = null, ?NotificationService $notificationService = null): User
    {
        $user->update([
            'status' => 'suspended',
            'suspended_until' => $until,
            'suspension_reason' => $reason,
        ]);

        // Send notification
        if (!$notificationService) {
            $notificationService = app(NotificationService::class);
        }
        $notificationService->sendUserNotification($user, 'suspended', [
            'reason' => $reason,
            'until' => $until ? $until->format('Y-m-d') : 'indefinitely',
        ]);

        return $user->fresh();
    }

    /**
     * Unsuspend a user.
     *
     * @param User $user
     * @return User
     */
    public function unsuspendUser(User $user): User
    {
        $user->update([
            'status' => 'active',
            'suspended_until' => null,
            'suspension_reason' => null,
        ]);

        return $user->fresh();
    }

    /**
     * Ban a user permanently.
     *
     * @param User $user
     * @param string|null $reason
     * @return User
     */
    public function banUser(User $user, ?string $reason = null): User
    {
        $user->update([
            'status' => 'banned',
            'suspension_reason' => $reason,
        ]);

        return $user->fresh();
    }

    /**
     * Change user role.
     *
     * @param User $user
     * @param string $newRole
     * @param NotificationService|null $notificationService
     * @return User
     */
    public function changeUserRole(User $user, string $newRole, ?NotificationService $notificationService = null): User
    {
        // Remove all existing roles
        $user->syncRoles([$newRole]);

        // Send notification
        if (!$notificationService) {
            $notificationService = app(NotificationService::class);
        }
        $notificationService->sendUserNotification($user, 'role_changed', ['new_role' => $newRole]);

        return $user->fresh();
    }

    /**
     * Delete a user (soft delete).
     *
     * @param User $user
     * @return bool
     */
    public function deleteUser(User $user): bool
    {
        return $user->delete();
    }

    /**
     * Restore a deleted user.
     *
     * @param int $userId
     * @return User|null
     */
    public function restoreUser(int $userId): ?User
    {
        $user = User::withTrashed()->find($userId);

        if ($user && $user->trashed()) {
            $user->restore();
            return $user->fresh();
        }

        return null;
    }

    /**
     * Update user password.
     *
     * @param User $user
     * @param string $newPassword
     * @return User
     */
    public function updatePassword(User $user, string $newPassword): User
    {
        $user->update(['password' => Hash::make($newPassword)]);
        return $user->fresh();
    }

    /**
     * Get pending users awaiting approval.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getPendingUsers()
    {
        return User::pending()
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Get active users by role.
     *
     * @param string|null $role
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getActiveUsers(?string $role = null)
    {
        $query = User::active();

        if ($role) {
            $query->role($role);
        }

        return $query->orderBy('name')->get();
    }

    /**
     * Search users by keyword.
     *
     * @param string $keyword
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function searchUsers(string $keyword)
    {
        return User::where('name', 'like', "%{$keyword}%")
            ->orWhere('email', 'like', "%{$keyword}%")
            ->orWhere('research_group', 'like', "%{$keyword}%")
            ->orderBy('name')
            ->get();
    }

    /**
     * Get user statistics.
     *
     * @param User $user
     * @return array
     */
    public function getUserStatistics(User $user): array
    {
        return [
            'total_reservations' => $user->reservations()->count(),
            'active_reservations' => $user->reservations()->whereIn('status', ['pending', 'approved'])->count(),
            'total_projects' => $user->projects()->count(),
            'owned_projects' => $user->createdProjects()->count(),
            'total_experiments' => $user->experiments()->count(),
            'registered_events' => $user->events()->count(),
            'total_comments' => $user->experimentComments()->count(),
            'maintenance_tasks' => $user->maintenanceLogs()->count(),
        ];
    }

    /**
     * Get system-wide user statistics.
     *
     * @return array
     */
    public function getSystemStatistics(): array
    {
        return [
            'total_users' => User::count(),
            'active_users' => User::active()->count(),
            'pending_users' => User::pending()->count(),
            'suspended_users' => User::where('status', 'suspended')->count(),
            'banned_users' => User::where('status', 'banned')->count(),
            'users_by_role' => [
                'admin' => User::role('admin')->count(),
                'material_manager' => User::role('material_manager')->count(),
                'researcher' => User::role('researcher')->count(),
                'phd_student' => User::role('phd_student')->count(),
                'partial_researcher' => User::role('partial_researcher')->count(),
                'technician' => User::role('technician')->count(),
                'guest' => User::role('guest')->count(),
            ],
        ];
    }

    /**
     * Auto-unsuspend users whose suspension period has ended.
     *
     * @return int Number of users unsuspended
     */
    public function autoUnsuspendUsers(): int
    {
        return User::where('status', 'suspended')
            ->whereNotNull('suspended_until')
            ->where('suspended_until', '<=', now())
            ->update([
                'status' => 'active',
                'suspended_until' => null,
                'suspension_reason' => null,
            ]);
    }

    /**
     * Upload user avatar.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @return string Path to stored avatar
     */
    private function uploadAvatar($file): string
    {
        $path = $file->store('avatars', 'public');
        return $path;
    }

    /**
     * Delete user avatar.
     *
     * @param string $path
     * @return bool
     */
    private function deleteAvatar(string $path): bool
    {
        return Storage::disk('public')->delete($path);
    }
}
