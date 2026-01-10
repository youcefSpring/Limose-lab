<?php

namespace App\Models;

use App\Enums\MaintenanceStatus;
use App\Enums\MaintenanceType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaintenanceLog extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'material_id',
        'technician_id',
        'maintenance_type',
        'description',
        'scheduled_date',
        'completed_date',
        'cost',
        'notes',
        'status',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'scheduled_date' => 'date',
            'completed_date' => 'date',
            'completed_at' => 'datetime',
            'cost' => 'decimal:2',
            'status' => MaintenanceStatus::class,
            'type' => MaintenanceType::class,
        ];
    }

    /**
     * Get the material.
     */
    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
    }

    /**
     * Get the technician.
     */
    public function technician(): BelongsTo
    {
        return $this->belongsTo(User::class, 'technician_id');
    }

    /**
     * Scope a query to only include scheduled maintenance.
     */
    public function scopeScheduled($query)
    {
        return $query->where('status', 'scheduled')
            ->orderBy('scheduled_date', 'asc');
    }

    /**
     * Scope a query to only include in progress maintenance.
     */
    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    /**
     * Scope a query to only include completed maintenance.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed')
            ->orderBy('completed_date', 'desc');
    }

    /**
     * Check if maintenance is overdue.
     */
    public function isOverdue(): bool
    {
        return $this->status !== MaintenanceStatus::COMPLETED
            && $this->scheduled_date < now()->toDateString();
    }

    /**
     * Check if maintenance is scheduled.
     */
    public function isScheduled(): bool
    {
        return $this->status === MaintenanceStatus::SCHEDULED;
    }

    /**
     * Check if maintenance is in progress.
     */
    public function isInProgress(): bool
    {
        return $this->status === MaintenanceStatus::IN_PROGRESS;
    }

    /**
     * Check if maintenance is completed.
     */
    public function isCompleted(): bool
    {
        return $this->status === MaintenanceStatus::COMPLETED;
    }
}
