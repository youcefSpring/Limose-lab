<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'title',
        'description',
        'event_date',
        'event_time',
        'location',
        'capacity',
        'event_type',
        'target_roles',
        'image',
        'created_by',
        'cancelled_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'event_date' => 'date',
            'event_time' => 'datetime:H:i',
            'target_roles' => 'array',
            'cancelled_at' => 'datetime',
            'capacity' => 'integer',
        ];
    }

    /**
     * Get the user who created the event.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the attendees for the event.
     */
    public function attendees(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'event_attendees')
            ->withPivot('status', 'registered_at')
            ->withTimestamps();
    }

    /**
     * Get confirmed attendees.
     */
    public function confirmedAttendees(): BelongsToMany
    {
        return $this->attendees()->wherePivot('status', 'confirmed');
    }

    /**
     * Get the event attendees records.
     */
    public function eventAttendees(): HasMany
    {
        return $this->hasMany(EventAttendee::class);
    }

    /**
     * Scope a query to only include upcoming events.
     */
    public function scopeUpcoming($query)
    {
        return $query->where('event_date', '>=', now()->toDateString())
            ->whereNull('cancelled_at')
            ->orderBy('event_date', 'asc')
            ->orderBy('event_time', 'asc');
    }

    /**
     * Scope a query to only include past events.
     */
    public function scopePast($query)
    {
        return $query->where('event_date', '<', now()->toDateString())
            ->orderBy('event_date', 'desc');
    }

    /**
     * Scope a query to only include public events.
     */
    public function scopePublic($query)
    {
        return $query->where('event_type', 'public');
    }

    /**
     * Check if event is cancelled.
     */
    public function isCancelled(): bool
    {
        return !is_null($this->cancelled_at);
    }

    /**
     * Check if event has capacity.
     */
    public function hasCapacity(): bool
    {
        if (is_null($this->capacity)) {
            return true;
        }

        return $this->confirmedAttendees()->count() < $this->capacity;
    }

    /**
     * Check if user can attend event.
     */
    public function canUserAttend(User $user): bool
    {
        if ($this->isCancelled()) {
            return false;
        }

        if ($this->event_type === 'private' && $this->target_roles) {
            $userRoles = $user->getRoleNames()->toArray();
            return count(array_intersect($userRoles, $this->target_roles)) > 0;
        }

        return true;
    }

    /**
     * Check if user is registered.
     */
    public function hasUserRegistered(User $user): bool
    {
        return $this->attendees()->where('user_id', $user->id)->exists();
    }
}
