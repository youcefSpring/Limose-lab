<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reservation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'user_id',
        'material_id',
        'start_date',
        'end_date',
        'quantity',
        'purpose',
        'notes',
        'status',
        'validated_by',
        'validated_at',
        'rejection_reason',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'start_date' => 'datetime',
            'end_date' => 'datetime',
            'validated_at' => 'datetime',
            'quantity' => 'integer',
            'status' => 'string',
        ];
    }

    /**
     * Get the user that owns the reservation.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the material that is reserved.
     */
    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
    }

    /**
     * Get the validator of the reservation.
     */
    public function validator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'validated_by');
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
     * Scope a query to only include active reservations.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'approved')
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now());
    }

    /**
     * Scope a query to reservations for a specific user.
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Check if reservation is pending.
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if reservation is approved.
     */
    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    /**
     * Check if reservation can be cancelled.
     */
    public function canBeCancelled(): bool
    {
        return in_array($this->status, ['pending', 'approved'])
            && $this->start_date > now();
    }
}
