<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserService
{
    public function getUsers(array $filters = [], int $perPage = 20): LengthAwarePaginator
    {
        $query = User::query();

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if (!empty($filters['role'])) {
            $query->where('role', $filters['role']);
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function createUser(array $data): User
    {
        $data['password'] = Hash::make($data['password']);

        return DB::transaction(function () use ($data) {
            $user = User::create($data);

            // Send welcome email or perform other post-creation tasks

            return $user;
        });
    }

    public function updateUser(User $user, array $data): User
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);

        return $user;
    }

    public function deleteUser(User $user): bool
    {
        return DB::transaction(function () use ($user) {
            // Perform any cleanup tasks before deletion

            return $user->delete();
        });
    }

    public function getUserStatistics(User $user): array
    {
        $stats = [
            'projects_count' => 0,
            'publications_count' => 0,
            'equipment_reservations_count' => $user->equipmentReservations()->count(),
            'event_registrations_count' => $user->eventRegistrations()->count(),
            'last_login' => $user->last_login_at,
            'account_created' => $user->created_at,
        ];

        // Add project and publication counts if user is a researcher
        if ($user->researcher) {
            $stats['projects_count'] = $user->researcher->projects()->count();
            $stats['publications_count'] = $user->researcher->publications()->count();
        }

        return $stats;
    }
}