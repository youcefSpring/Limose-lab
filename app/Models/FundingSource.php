<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FundingSource extends Model
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
        'type',
        'contact_info',
        'website',
    ];

    /**
     * Get the project funding records for this source.
     */
    public function projectFunding(): HasMany
    {
        return $this->hasMany(ProjectFunding::class);
    }

    /**
     * Get the projects funded by this source.
     */
    public function projects()
    {
        return $this->hasManyThrough(Project::class, ProjectFunding::class);
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
     * Get the total amount funded by this source.
     */
    public function getTotalFundingAttribute()
    {
        return $this->projectFunding()
                    ->where('status', 'active')
                    ->sum('amount');
    }

    /**
     * Scope a query to filter by funding type.
     */
    public function scopeByType($query, string $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope a query to search funding sources by name.
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
     * Check if the funding source is governmental.
     */
    public function isGovernmental(): bool
    {
        return $this->type === 'government';
    }

    /**
     * Check if the funding source is private.
     */
    public function isPrivate(): bool
    {
        return $this->type === 'private';
    }

    /**
     * Check if the funding source is international.
     */
    public function isInternational(): bool
    {
        return $this->type === 'international';
    }
}