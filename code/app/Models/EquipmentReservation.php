<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EquipmentReservation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'equipment_id',
        'researcher_id',
        'project_id',
        'start_datetime',
        'end_datetime',
        'purpose_ar',
        'purpose_fr',
        'purpose_en',
        'status',
        'approved_by',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_datetime' => 'datetime',
        'end_datetime' => 'datetime',
    ];

    /**
     * Get the equipment for this reservation.
     */
    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class);
    }

    /**
     * Get the researcher who made this reservation.
     */
    public function researcher(): BelongsTo
    {
        return $this->belongsTo(Researcher::class);
    }

    /**
     * Get the project associated with this reservation.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the user who approved this reservation.
     */
    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Get the localized purpose based on the given locale.
     */
    public function getPurpose(string $locale = 'en'): ?string
    {
        return match ($locale) {
            'ar' => $this->purpose_ar,
            'fr' => $this->purpose_fr,
            'en' => $this->purpose_en,
            default => $this->purpose_en,
        };
    }

    /**
     * Get the duration of the reservation in hours.
     */
    public function getDurationInHours(): float
    {
        return $this->start_datetime->diffInHours($this->end_datetime);
    }

    /**
     * Check if the reservation is pending.
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if the reservation is approved.
     */
    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    /**
     * Check if the reservation is rejected.
     */
    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    /**
     * Check if the reservation is completed.
     */
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    /**
     * Check if the reservation is cancelled.
     */
    public function isCancelled(): bool
    {
        return $this->status === 'cancelled';
    }

    /**
     * Check if the reservation is currently active.
     */
    public function isCurrentlyActive(): bool
    {
        $now = now();
        return $this->isApproved() &&
               $this->start_datetime <= $now &&
               $this->end_datetime >= $now;
    }

    /**
     * Scope a query to only include pending reservations.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include approved reservations.
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope a query to filter by date range.
     */
    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('start_datetime', [$startDate, $endDate])
                     ->orWhereBetween('end_datetime', [$startDate, $endDate]);
    }

    /**
     * Scope a query to filter by equipment.
     */
    public function scopeByEquipment($query, $equipmentId)
    {
        return $query->where('equipment_id', $equipmentId);
    }

    /**
     * Scope a query to filter by researcher.
     */
    public function scopeByResearcher($query, $researcherId)
    {
        return $query->where('researcher_id', $researcherId);
    }
}