<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title_ar',
        'title_fr',
        'title_en',
        'description_ar',
        'description_fr',
        'description_en',
        'type',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'location_ar',
        'location_fr',
        'location_en',
        'max_participants',
        'registration_deadline',
        'status',
        'organizer_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'start_time' => 'time',
        'end_time' => 'time',
        'registration_deadline' => 'date',
        'max_participants' => 'integer',
    ];

    /**
     * Get the organizer of this event.
     */
    public function organizer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    /**
     * Get the registrations for this event.
     */
    public function registrations(): HasMany
    {
        return $this->hasMany(EventRegistration::class);
    }

    /**
     * Get the confirmed registrations for this event.
     */
    public function confirmedRegistrations(): HasMany
    {
        return $this->hasMany(EventRegistration::class)
                    ->whereIn('status', ['confirmed', 'attended']);
    }

    /**
     * Get the participants of this event.
     */
    public function participants()
    {
        return $this->hasManyThrough(User::class, EventRegistration::class, 'event_id', 'id', 'id', 'user_id');
    }

    /**
     * Get the localized title based on the given locale.
     */
    public function getTitle(string $locale = 'en'): ?string
    {
        return match ($locale) {
            'ar' => $this->title_ar,
            'fr' => $this->title_fr,
            'en' => $this->title_en,
            default => $this->title_en,
        };
    }

    /**
     * Get the localized description based on the given locale.
     */
    public function getDescription(string $locale = 'en'): ?string
    {
        return match ($locale) {
            'ar' => $this->description_ar,
            'fr' => $this->description_fr,
            'en' => $this->description_en,
            default => $this->description_en,
        };
    }

    /**
     * Get the localized location based on the given locale.
     */
    public function getLocation(string $locale = 'en'): ?string
    {
        return match ($locale) {
            'ar' => $this->location_ar,
            'fr' => $this->location_fr,
            'en' => $this->location_en,
            default => $this->location_en,
        };
    }

    /**
     * Get the event duration in days.
     */
    public function getDurationAttribute(): int
    {
        return $this->start_date->diffInDays($this->end_date) + 1;
    }

    /**
     * Get the number of registered participants.
     */
    public function getRegisteredCountAttribute(): int
    {
        return $this->registrations()->count();
    }

    /**
     * Get the number of available spots.
     */
    public function getAvailableSpotsAttribute(): ?int
    {
        if (!$this->max_participants) {
            return null;
        }

        return $this->max_participants - $this->registered_count;
    }

    /**
     * Check if the event is in draft status.
     */
    public function isDraft(): bool
    {
        return $this->status === 'draft';
    }

    /**
     * Check if the event is published.
     */
    public function isPublished(): bool
    {
        return $this->status === 'published';
    }

    /**
     * Check if the event is ongoing.
     */
    public function isOngoing(): bool
    {
        return $this->status === 'ongoing';
    }

    /**
     * Check if the event is completed.
     */
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    /**
     * Check if the event is cancelled.
     */
    public function isCancelled(): bool
    {
        return $this->status === 'cancelled';
    }

    /**
     * Check if registration is open.
     */
    public function isRegistrationOpen(): bool
    {
        $now = now()->toDate();
        return $this->isPublished() &&
               (!$this->registration_deadline || $this->registration_deadline >= $now) &&
               (!$this->max_participants || $this->available_spots > 0);
    }

    /**
     * Check if registration deadline has passed.
     */
    public function isRegistrationClosed(): bool
    {
        return $this->registration_deadline && $this->registration_deadline < now()->toDate();
    }

    /**
     * Check if the event is full.
     */
    public function isFull(): bool
    {
        return $this->max_participants && $this->registered_count >= $this->max_participants;
    }

    /**
     * Scope a query to only include published events.
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    /**
     * Scope a query to filter by event type.
     */
    public function scopeByType($query, string $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope a query to filter by date range.
     */
    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('start_date', [$startDate, $endDate])
                     ->orWhereBetween('end_date', [$startDate, $endDate]);
    }

    /**
     * Scope a query to only include upcoming events.
     */
    public function scopeUpcoming($query)
    {
        return $query->where('start_date', '>=', now()->toDate());
    }

    /**
     * Scope a query to search events by title.
     */
    public function scopeByTitle($query, string $title)
    {
        return $query->where(function ($q) use ($title) {
            $q->where('title_ar', 'like', '%' . $title . '%')
              ->orWhere('title_fr', 'like', '%' . $title . '%')
              ->orWhere('title_en', 'like', '%' . $title . '%');
        });
    }
}