<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Desk extends Model
{
    protected $fillable = [
        'name',
        'location',
        'description',
        'capacity',
        'available_equipment',
        'is_active',
        'manager_id'
    ];

    protected $casts = [
        'available_equipment' => 'array',
        'is_active' => 'boolean',
        'capacity' => 'integer'
    ];

    public function manager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    public function equipmentRequests(): HasMany
    {
        return $this->hasMany(EquipmentRequest::class, 'assigned_desk_id');
    }

    public function activeRequests(): HasMany
    {
        return $this->hasMany(EquipmentRequest::class, 'assigned_desk_id')
            ->whereIn('status', ['approved', 'in_progress']);
    }

    public function getCurrentOccupancy(): int
    {
        return $this->activeRequests()
            ->whereDate('requested_date', now()->toDateString())
            ->whereTime('requested_start_time', '<=', now()->toTimeString())
            ->whereTime('requested_end_time', '>=', now()->toTimeString())
            ->sum('estimated_users');
    }

    public function isAvailable($date, $startTime, $endTime, $requiredCapacity = 1): bool
    {
        if (!$this->is_active) {
            return false;
        }

        $currentOccupancy = $this->equipmentRequests()
            ->whereDate('requested_date', $date)
            ->where(function($query) use ($startTime, $endTime) {
                $query->where(function($q) use ($startTime, $endTime) {
                    $q->whereTime('requested_start_time', '<=', $startTime)
                      ->whereTime('requested_end_time', '>', $startTime);
                })->orWhere(function($q) use ($startTime, $endTime) {
                    $q->whereTime('requested_start_time', '<', $endTime)
                      ->whereTime('requested_end_time', '>=', $endTime);
                })->orWhere(function($q) use ($startTime, $endTime) {
                    $q->whereTime('requested_start_time', '>=', $startTime)
                      ->whereTime('requested_end_time', '<=', $endTime);
                });
            })
            ->whereIn('status', ['approved', 'in_progress'])
            ->sum('estimated_users');

        return ($currentOccupancy + $requiredCapacity) <= $this->capacity;
    }
}
