<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Material extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'description',
        'category_id',
        'quantity',
        'status',
        'location',
        'serial_number',
        'purchase_date',
        'image',
        'maintenance_schedule',
        'last_maintenance_date',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'purchase_date' => 'date',
            'last_maintenance_date' => 'date',
            'quantity' => 'integer',
            'status' => 'string',
        ];
    }

    /**
     * Get the category that owns the material.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(MaterialCategory::class, 'category_id');
    }

    /**
     * Get the reservations for the material.
     */
    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    /**
     * Get the maintenance logs for the material.
     */
    public function maintenanceLogs(): HasMany
    {
        return $this->hasMany(MaintenanceLog::class);
    }

    /**
     * Scope a query to only include available materials.
     */
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available')->where('quantity', '>', 0);
    }

    /**
     * Scope a query to only include materials in maintenance.
     */
    public function scopeInMaintenance($query)
    {
        return $query->where('status', 'maintenance');
    }

    /**
     * Check if material is available for reservation.
     */
    public function isAvailable(): bool
    {
        return $this->status === MaterialStatus::AVAILABLE && $this->quantity > 0;
    }

    /**
     * Get available quantity (total - reserved).
     */
    public function availableQuantity(): int
    {
        $reserved = $this->reservations()
            ->where('status', 'approved')
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->sum('quantity');

        return max(0, $this->quantity - $reserved);
    }
}
