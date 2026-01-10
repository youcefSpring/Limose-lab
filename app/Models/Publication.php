<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Publication extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
        'title_fr',
        'title_ar',
        'abstract',
        'abstract_fr',
        'abstract_ar',
        'authors',
        'journal',
        'conference',
        'publisher',
        'year',
        'volume',
        'issue',
        'pages',
        'doi',
        'isbn',
        'url',
        'pdf_file',
        'type',
        'status',
        'publication_date',
        'keywords',
        'research_areas',
        'is_featured',
        'is_open_access',
        'citations_count',
        'visibility',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_open_access' => 'boolean',
        'citations_count' => 'integer',
        'year' => 'integer',
        'publication_date' => 'date',
    ];

    /**
     * Get the user that owns the publication
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get localized title based on current locale
     */
    public function getLocalizedTitle($locale = null): string
    {
        $locale = $locale ?? app()->getLocale();

        return match($locale) {
            'fr' => $this->title_fr ?? $this->title,
            'ar' => $this->title_ar ?? $this->title,
            default => $this->title,
        };
    }

    /**
     * Get localized abstract based on current locale
     */
    public function getLocalizedAbstract($locale = null): ?string
    {
        $locale = $locale ?? app()->getLocale();

        return match($locale) {
            'fr' => $this->abstract_fr ?? $this->abstract,
            'ar' => $this->abstract_ar ?? $this->abstract,
            default => $this->abstract,
        };
    }

    /**
     * Scope to get only public publications
     */
    public function scopePublic($query)
    {
        return $query->where('visibility', 'public');
    }

    /**
     * Scope to get only published publications
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    /**
     * Scope to get featured publications
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope to filter by type
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope to filter by year
     */
    public function scopeByYear($query, $year)
    {
        return $query->where('year', $year);
    }
}
