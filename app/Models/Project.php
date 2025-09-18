<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'leader_id',
        'title_ar',
        'title_fr',
        'title_en',
        'description_ar',
        'description_fr',
        'description_en',
        'budget',
        'start_date',
        'end_date',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'budget' => 'decimal:2',
    ];

    /**
     * Get the researcher that leads this project.
     */
    public function leader(): BelongsTo
    {
        return $this->belongsTo(Researcher::class, 'leader_id');
    }

    /**
     * Get the members of this project.
     */
    public function members(): BelongsToMany
    {
        return $this->belongsToMany(Researcher::class, 'project_members')
                    ->withPivot('role', 'joined_at')
                    ->withTimestamps();
    }

    /**
     * Get the funding sources for this project.
     */
    public function funding(): HasMany
    {
        return $this->hasMany(ProjectFunding::class);
    }

    /**
     * Get the publications associated with this project.
     */
    public function publications(): BelongsToMany
    {
        return $this->belongsToMany(Publication::class);
    }

    /**
     * Get the equipment reservations for this project.
     */
    public function equipmentReservations(): HasMany
    {
        return $this->hasMany(EquipmentReservation::class);
    }

    /**
     * Get the project members pivot records.
     */
    public function projectMembers(): HasMany
    {
        return $this->hasMany(ProjectMember::class);
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
     * Get the project duration in days.
     */
    public function getDurationAttribute(): int
    {
        return $this->start_date->diffInDays($this->end_date);
    }

    /**
     * Check if the project is active.
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Check if the project is completed.
     */
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    /**
     * Check if the project is pending.
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Scope a query to only include active projects.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include projects by status.
     */
    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope a query to search projects by title.
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
     * Scope a query to filter projects by date range.
     */
    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('start_date', [$startDate, $endDate])
                     ->orWhereBetween('end_date', [$startDate, $endDate]);
    }
}