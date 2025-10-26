<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EquipmentRequest extends Model
{
    protected $fillable = [
        'user_id',
        'equipment_id',
        'equipment_name',
        'description',
        'priority',
        'status',
        'requested_date',
        'requested_start_time',
        'requested_end_time',
        'purpose',
        'estimated_users',
        'special_requirements',
        'admin_notes',
        'rejection_reason',
        'approved_by',
        'approved_at',
        'assigned_desk_id'
    ];

    protected $casts = [
        'requested_date' => 'date',
        'requested_start_time' => 'datetime:H:i',
        'requested_end_time' => 'datetime:H:i',
        'approved_at' => 'datetime',
        'estimated_users' => 'integer'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class);
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function assignedDesk(): BelongsTo
    {
        return $this->belongsTo(Desk::class, 'assigned_desk_id');
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending' => 'warning',
            'approved' => 'success',
            'rejected' => 'danger',
            'in_progress' => 'info',
            'completed' => 'primary',
            default => 'secondary'
        };
    }

    public function getPriorityColorAttribute(): string
    {
        return match($this->priority) {
            'low' => 'success',
            'medium' => 'info',
            'high' => 'warning',
            'urgent' => 'danger',
            default => 'secondary'
        };
    }
}
