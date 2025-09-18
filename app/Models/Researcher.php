<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Researcher extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'photo_path',
        'cv_path',
        'research_domain',
        'google_scholar_url',
        'bio_ar',
        'bio_fr',
        'bio_en',
    ];

    /**
     * Get the user that owns the researcher profile.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the projects led by this researcher.
     */
    public function ledProjects(): HasMany
    {
        return $this->hasMany(Project::class, 'leader_id');
    }

    /**
     * Get the projects this researcher is a member of.
     */
    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'project_members')
                    ->withPivot('role', 'joined_at')
                    ->withTimestamps();
    }

    /**
     * Get the publications created by this researcher.
     */
    public function createdPublications(): HasMany
    {
        return $this->hasMany(Publication::class, 'created_by');
    }

    /**
     * Get the publications this researcher is an author of.
     */
    public function publications(): BelongsToMany
    {
        return $this->belongsToMany(Publication::class, 'publication_authors')
                    ->withPivot('author_order', 'is_corresponding_author')
                    ->withTimestamps();
    }

    /**
     * Get the equipment reservations made by this researcher.
     */
    public function equipmentReservations(): HasMany
    {
        return $this->hasMany(EquipmentReservation::class);
    }

    /**
     * Get the collaborations coordinated by this researcher.
     */
    public function coordinatedCollaborations(): HasMany
    {
        return $this->hasMany(Collaboration::class, 'coordinator_id');
    }

    /**
     * Get the researcher's full name.
     */
    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * Get the localized bio based on the given locale.
     */
    public function getBio(string $locale = 'en'): ?string
    {
        return match ($locale) {
            'ar' => $this->bio_ar,
            'fr' => $this->bio_fr,
            'en' => $this->bio_en,
            default => $this->bio_en,
        };
    }

    /**
     * Scope a query to search researchers by domain.
     */
    public function scopeByDomain($query, string $domain)
    {
        return $query->where('research_domain', 'like', '%' . $domain . '%');
    }

    /**
     * Scope a query to search researchers by name.
     */
    public function scopeByName($query, string $name)
    {
        return $query->where(function ($q) use ($name) {
            $q->where('first_name', 'like', '%' . $name . '%')
              ->orWhere('last_name', 'like', '%' . $name . '%');
        });
    }
}