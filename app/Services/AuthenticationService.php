<?php

namespace App\Services;

use App\Models\User;
use App\Models\Researcher;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\PersonalAccessToken;

class AuthenticationService
{
    /**
     * Authenticate user and return token for API access.
     */
    public function login(array $credentials, string $deviceName = 'default'): array
    {
        if (!Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => ['البريد الإلكتروني أو كلمة المرور غير صحيحة'],
            ]);
        }

        $user = Auth::user();

        // Check if user account is active
        if (!$user->isActive()) {
            Auth::logout();
            throw ValidationException::withMessages([
                'status' => ['الحساب غير مفعل. يرجى الاتصال بالمسؤول.'],
            ]);
        }

        // Create API token
        $token = $user->createToken($deviceName);

        return [
            'user' => $user->load('researcher'),
            'token' => $token->plainTextToken,
            'token_type' => 'Bearer',
            'expires_in' => config('sanctum.expiration', 525600), // minutes
        ];
    }

    /**
     * Register a new user with role-based validation.
     */
    public function register(array $userData): User
    {
        return DB::transaction(function () use ($userData) {
            // Create user account
            $user = User::create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'password' => Hash::make($userData['password']),
                'role' => $userData['role'] ?? 'visitor',
                'status' => 'inactive', // Requires admin activation
                'orcid' => $userData['orcid'] ?? null,
                'phone' => $userData['phone'] ?? null,
            ]);

            // Create researcher profile if user is a researcher
            if ($user->role === 'researcher' && isset($userData['researcher_data'])) {
                $this->createResearcherProfile($user, $userData['researcher_data']);
            }

            // Assign default role using Spatie Laravel Permission
            $user->assignRole($user->role);

            // Send email verification
            event(new Registered($user));

            return $user;
        });
    }

    /**
     * Create researcher profile for new researcher users.
     */
    private function createResearcherProfile(User $user, array $researcherData): Researcher
    {
        return Researcher::create([
            'user_id' => $user->id,
            'first_name' => $researcherData['first_name'],
            'last_name' => $researcherData['last_name'],
            'research_domain' => $researcherData['research_domain'],
            'google_scholar_url' => $researcherData['google_scholar_url'] ?? null,
            'bio_ar' => $researcherData['bio_ar'] ?? null,
            'bio_fr' => $researcherData['bio_fr'] ?? null,
            'bio_en' => $researcherData['bio_en'] ?? null,
        ]);
    }

    /**
     * Logout user by revoking current token.
     */
    public function logout(User $user, string $currentToken = null): bool
    {
        if ($currentToken) {
            // Revoke specific token
            $token = PersonalAccessToken::findToken($currentToken);
            if ($token && $token->tokenable_id === $user->id) {
                $token->delete();
                return true;
            }
        }

        // Revoke all tokens if no specific token provided
        $user->tokens()->delete();
        return true;
    }

    /**
     * Refresh user's API token.
     */
    public function refreshToken(User $user, string $currentToken, string $deviceName = 'default'): array
    {
        // Revoke current token
        $token = PersonalAccessToken::findToken($currentToken);
        if ($token && $token->tokenable_id === $user->id) {
            $token->delete();
        }

        // Create new token
        $newToken = $user->createToken($deviceName);

        return [
            'token' => $newToken->plainTextToken,
            'token_type' => 'Bearer',
            'expires_in' => config('sanctum.expiration', 525600),
        ];
    }

    /**
     * Activate user account (admin only).
     */
    public function activateUser(User $user): bool
    {
        return $user->update(['status' => 'active']);
    }

    /**
     * Suspend user account (admin only).
     */
    public function suspendUser(User $user, string $reason = null): bool
    {
        // Revoke all user tokens
        $user->tokens()->delete();

        return $user->update(['status' => 'suspended']);
    }

    /**
     * Update user profile information.
     */
    public function updateProfile(User $user, array $profileData): User
    {
        return DB::transaction(function () use ($user, $profileData) {
            // Update user data
            $userUpdates = array_intersect_key($profileData, array_flip([
                'name', 'email', 'phone', 'orcid'
            ]));

            if (!empty($userUpdates)) {
                $user->update($userUpdates);
            }

            // Update researcher profile if exists and data provided
            if ($user->researcher && isset($profileData['researcher_data'])) {
                $researcherUpdates = array_intersect_key($profileData['researcher_data'], array_flip([
                    'first_name', 'last_name', 'research_domain', 'google_scholar_url',
                    'bio_ar', 'bio_fr', 'bio_en'
                ]));

                if (!empty($researcherUpdates)) {
                    $user->researcher->update($researcherUpdates);
                }
            }

            return $user->fresh(['researcher']);
        });
    }

    /**
     * Change user password.
     */
    public function changePassword(User $user, string $currentPassword, string $newPassword): bool
    {
        if (!Hash::check($currentPassword, $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => ['كلمة المرور الحالية غير صحيحة'],
            ]);
        }

        return $user->update([
            'password' => Hash::make($newPassword)
        ]);
    }

    /**
     * Send password reset link.
     */
    public function sendPasswordResetLink(string $email): bool
    {
        $user = User::where('email', $email)->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'email' => ['لم يتم العثور على مستخدم بهذا البريد الإلكتروني'],
            ]);
        }

        // Use Laravel's built-in password reset functionality
        $status = \Illuminate\Support\Facades\Password::sendResetLink(['email' => $email]);

        return $status === \Illuminate\Support\Facades\Password::RESET_LINK_SENT;
    }

    /**
     * Reset password using reset token.
     */
    public function resetPassword(array $credentials): bool
    {
        $status = \Illuminate\Support\Facades\Password::reset(
            $credentials,
            function ($user, $password) {
                $user->update([
                    'password' => Hash::make($password)
                ]);

                // Revoke all tokens for security
                $user->tokens()->delete();
            }
        );

        return $status === \Illuminate\Support\Facades\Password::PASSWORD_RESET;
    }

    /**
     * Get user permissions based on role.
     */
    public function getUserPermissions(User $user): array
    {
        $permissions = $user->getAllPermissions()->pluck('name')->toArray();

        // Add role-based permissions
        $rolePermissions = $this->getRolePermissions($user->role);

        return array_unique(array_merge($permissions, $rolePermissions));
    }

    /**
     * Get default permissions for a role.
     */
    private function getRolePermissions(string $role): array
    {
        return match ($role) {
            'admin' => [
                'users.manage', 'projects.manage', 'equipment.manage',
                'events.manage', 'collaborations.manage', 'system.manage'
            ],
            'researcher' => [
                'projects.create', 'projects.view', 'publications.manage',
                'equipment.reserve', 'events.participate'
            ],
            'lab_manager' => [
                'equipment.manage', 'reservations.approve', 'events.organize'
            ],
            'visitor' => [
                'projects.view', 'publications.view', 'events.view'
            ],
            default => []
        };
    }

    /**
     * Check if user has permission.
     */
    public function hasPermission(User $user, string $permission): bool
    {
        $userPermissions = $this->getUserPermissions($user);
        return in_array($permission, $userPermissions);
    }
}