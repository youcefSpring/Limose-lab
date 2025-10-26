<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
        'orcid',
        'phone',
        'is_active',
        'department',
        'position',
        'preferred_language',
        'bio',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the researcher profile associated with the user.
     */
    public function researcher(): HasOne
    {
        return $this->hasOne(Researcher::class);
    }

    /**
     * Get the events organized by this user.
     */
    public function organizedEvents(): HasMany
    {
        return $this->hasMany(Event::class, 'organizer_id');
    }

    /**
     * Get the event registrations for this user.
     */
    public function eventRegistrations(): HasMany
    {
        return $this->hasMany(EventRegistration::class);
    }

    /**
     * Get the equipment reservations approved by this user.
     */
    public function approvedReservations(): HasMany
    {
        return $this->hasMany(EquipmentReservation::class, 'approved_by');
    }

    /**
     * Check if the user is an admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user can manage researchers
     */
    public function canManageResearchers(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user can manage projects
     */
    public function canManageProjects(): bool
    {
        return in_array($this->role, ['admin', 'lab_manager']);
    }

    /**
     * Check if user can manage equipment
     */
    public function canManageEquipment(): bool
    {
        return in_array($this->role, ['admin', 'lab_manager']);
    }

    /**
     * Check if user can manage publications
     */
    public function canManagePublications(): bool
    {
        return in_array($this->role, ['admin', 'lab_manager', 'researcher']);
    }

    /**
     * Check if user can access admin panel
     */
    public function canAccessAdminPanel(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user can manage all system settings
     */
    public function canManageSystem(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user can delete resources
     */
    public function canDelete(string $resource = null): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user can create resources
     */
    public function canCreate(string $resource = null): bool
    {
        switch ($resource) {
            case 'researcher':
                return $this->role === 'admin';
            case 'project':
                return in_array($this->role, ['admin', 'lab_manager', 'researcher']);
            case 'equipment':
                return in_array($this->role, ['admin', 'lab_manager']);
            case 'publication':
                return in_array($this->role, ['admin', 'lab_manager', 'researcher']);
            default:
                return $this->role === 'admin';
        }
    }

    /**
     * Check if the user is a researcher.
     */
    public function isResearcher(): bool
    {
        return $this->role === 'researcher';
    }

    /**
     * Check if the user is a lab manager.
     */
    public function isLabManager(): bool
    {
        return $this->role === 'lab_manager';
    }

    /**
     * Check if the user is a visitor.
     */
    public function isVisitor(): bool
    {
        return $this->role === 'visitor';
    }

    /**
     * Check if the user account is active.
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }
}
