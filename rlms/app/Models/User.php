<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'avatar',
        'research_group',
        'bio',
        'status',
        'suspended_until',
        'suspension_reason',
        'locale',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<string>
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
            'suspended_until' => 'datetime',
            'status' => 'string',
        ];
    }

    /**
     * Get the reservations for the user.
     */
    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    /**
     * Get the validated reservations by the user.
     */
    public function validatedReservations(): HasMany
    {
        return $this->hasMany(Reservation::class, 'validated_by');
    }

    /**
     * Get the projects created by the user.
     */
    public function createdProjects(): HasMany
    {
        return $this->hasMany(Project::class, 'created_by');
    }

    /**
     * Get the projects the user is a member of.
     */
    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'project_user')
            ->withPivot('role', 'joined_at')
            ->withTimestamps();
    }

    /**
     * Get the experiments created by the user.
     */
    public function experiments(): HasMany
    {
        return $this->hasMany(Experiment::class);
    }

    /**
     * Get the experiment comments by the user.
     */
    public function experimentComments(): HasMany
    {
        return $this->hasMany(ExperimentComment::class);
    }

    /**
     * Get the events created by the user.
     */
    public function createdEvents(): HasMany
    {
        return $this->hasMany(Event::class, 'created_by');
    }

    /**
     * Get the events the user is attending.
     */
    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class, 'event_attendees')
            ->withPivot('status', 'registered_at')
            ->withTimestamps();
    }

    /**
     * Get the maintenance logs assigned to the user (as technician).
     */
    public function maintenanceLogs(): HasMany
    {
        return $this->hasMany(MaintenanceLog::class, 'technician_id');
    }

    /**
     * Scope a query to only include active users.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include pending users.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Check if user is active.
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Check if user is pending approval.
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if user is suspended.
     */
    public function isSuspended(): bool
    {
        return $this->status === 'suspended';
    }

    /**
     * Check if user is banned.
     */
    public function isBanned(): bool
    {
        return $this->status === 'banned';
    }

    /**
     * Get projects where user is principal investigator.
     */
    public function principalInvestigatorProjects(): HasMany
    {
        return $this->hasMany(Project::class, 'principal_investigator_id');
    }

    /**
     * Get the events organized by the user.
     */
    public function organizedEvents(): HasMany
    {
        return $this->hasMany(Event::class, 'organizer_id');
    }
}
