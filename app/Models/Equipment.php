<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Equipment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name_ar',
        'name_fr',
        'name_en',
        'description_ar',
        'description_fr',
        'description_en',
        'serial_number',
        'category',
        'location',
        'status',
        'purchase_date',
        'warranty_expiry',
        'maintenance_schedule',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'purchase_date' => 'date',
        'warranty_expiry' => 'date',
    ];

    /**
     * Get the reservations for this equipment.
     */
    public function reservations(): HasMany
    {
        return $this->hasMany(EquipmentReservation::class);
    }

    /**
     * Get the active reservations for this equipment.
     */
    public function activeReservations(): HasMany
    {
        return $this->hasMany(EquipmentReservation::class)
                    ->whereIn('status', ['approved', 'pending']);
    }

    /**
     * Get the localized name based on the given locale.
     */
    public function getName(string $locale = 'en'): ?string
    {
        return match ($locale) {
            'ar' => $this->name_ar,
            'fr' => $this->name_fr,
            'en' => $this->name_en,
            default => $this->name_en,
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
     * Check if the equipment is available.
     */
    public function isAvailable(): bool
    {
        return $this->status === 'available';
    }

    /**
     * Check if the equipment is reserved.
     */
    public function isReserved(): bool
    {
        return $this->status === 'reserved';
    }

    /**
     * Check if the equipment is under maintenance.
     */
    public function isUnderMaintenance(): bool
    {
        return $this->status === 'maintenance';
    }

    /**
     * Check if the equipment is out of order.
     */
    public function isOutOfOrder(): bool
    {
        return $this->status === 'out_of_order';
    }

    /**
     * Check if the warranty has expired.
     */
    public function isWarrantyExpired(): bool
    {
        return $this->warranty_expiry && $this->warranty_expiry->isPast();
    }

    /**
     * Scope a query to only include available equipment.
     */
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    /**
     * Scope a query to filter by category.
     */
    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope a query to filter by location.
     */
    public function scopeByLocation($query, string $location)
    {
        return $query->where('location', 'like', '%' . $location . '%');
    }

    /**
     * Scope a query to search equipment by name.
     */
    public function scopeByName($query, string $name)
    {
        return $query->where(function ($q) use ($name) {
            $q->where('name_ar', 'like', '%' . $name . '%')
              ->orWhere('name_fr', 'like', '%' . $name . '%')
              ->orWhere('name_en', 'like', '%' . $name . '%');
        });
    }

    /**
     * Check availability for a given time period.
     */
    public function isAvailableForPeriod($startDateTime, $endDateTime): bool
    {
        if (!$this->isAvailable()) {
            return false;
        }

        $conflictingReservations = $this->reservations()
            ->whereIn('status', ['approved', 'pending'])
            ->where(function ($query) use ($startDateTime, $endDateTime) {
                $query->whereBetween('start_datetime', [$startDateTime, $endDateTime])
                      ->orWhereBetween('end_datetime', [$startDateTime, $endDateTime])
                      ->orWhere(function ($q) use ($startDateTime, $endDateTime) {
                          $q->where('start_datetime', '<=', $startDateTime)
                            ->where('end_datetime', '>=', $endDateTime);
                      });
            })
            ->exists();

        return !$conflictingReservations;
    }
}