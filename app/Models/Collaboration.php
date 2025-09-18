<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Collaboration extends Model
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
        'institution_name',
        'country',
        'contact_person',
        'contact_email',
        'start_date',
        'end_date',
        'type',
        'status',
        'description_ar',
        'description_fr',
        'description_en',
        'coordinator_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    /**
     * Get the researcher coordinating this collaboration.
     */
    public function coordinator(): BelongsTo
    {
        return $this->belongsTo(Researcher::class, 'coordinator_id');
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
     * Get the collaboration duration in days.
     */
    public function getDurationAttribute(): ?int
    {
        if (!$this->end_date) {
            return null;
        }

        return $this->start_date->diffInDays($this->end_date);
    }

    /**
     * Check if the collaboration is active.
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Check if the collaboration is completed.
     */
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    /**
     * Check if the collaboration is suspended.
     */
    public function isSuspended(): bool
    {
        return $this->status === 'suspended';
    }

    /**
     * Check if the collaboration is cancelled.
     */
    public function isCancelled(): bool
    {
        return $this->status === 'cancelled';
    }

    /**
     * Check if the collaboration is currently valid (within date range and active).
     */
    public function isCurrentlyValid(): bool
    {
        $now = now()->toDate();
        return $this->isActive() &&
               $this->start_date <= $now &&
               (!$this->end_date || $this->end_date >= $now);
    }

    /**
     * Check if the collaboration is academic type.
     */
    public function isAcademic(): bool
    {
        return $this->type === 'academic';
    }

    /**
     * Check if the collaboration is industrial type.
     */
    public function isIndustrial(): bool
    {
        return $this->type === 'industrial';
    }

    /**
     * Check if the collaboration is governmental type.
     */
    public function isGovernmental(): bool
    {
        return $this->type === 'governmental';
    }

    /**
     * Check if the collaboration is international type.
     */
    public function isInternational(): bool
    {
        return $this->type === 'international';
    }

    /**
     * Scope a query to only include active collaborations.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to filter by collaboration type.
     */
    public function scopeByType($query, string $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope a query to filter by country.
     */
    public function scopeByCountry($query, string $country)
    {
        return $query->where('country', 'like', '%' . $country . '%');
    }

    /**
     * Scope a query to filter by institution.
     */
    public function scopeByInstitution($query, string $institution)
    {
        return $query->where('institution_name', 'like', '%' . $institution . '%');
    }

    /**
     * Scope a query to search collaborations by title.
     */
    public function scopeByTitle($query, string $title)
    {
        return $query->where(function ($q) use ($title) {
            $q->where('title_ar', 'like', '%' . $title . '%')
              ->orWhere('title_fr', 'like', '%' . $title . '%')
              ->orWhere('title_en', 'like', '%' . $title . '%');
        });
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
     * Scope a query to only include ongoing collaborations.
     */
    public function scopeOngoing($query)
    {
        $now = now()->toDate();
        return $query->where('status', 'active')
                     ->where('start_date', '<=', $now)
                     ->where(function ($q) use ($now) {
                         $q->whereNull('end_date')
                           ->orWhere('end_date', '>=', $now);
                     });
    }
}