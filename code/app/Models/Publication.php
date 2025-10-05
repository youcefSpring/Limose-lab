<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Publication extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'authors',
        'journal',
        'conference',
        'publisher',
        'doi',
        'publication_year',
        'volume',
        'issue',
        'pages',
        'type',
        'pdf_path',
        'status',
        'created_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'publication_year' => 'integer',
    ];

    /**
     * Get the researcher who created this publication.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(Researcher::class, 'created_by');
    }

    /**
     * Get the authors of this publication.
     */
    public function authorResearchers(): BelongsToMany
    {
        return $this->belongsToMany(Researcher::class, 'publication_authors')
                    ->withPivot('author_order', 'is_corresponding_author')
                    ->withTimestamps()
                    ->orderBy('publication_authors.author_order');
    }

    /**
     * Get the projects associated with this publication.
     */
    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class);
    }

    /**
     * Get the publication authors pivot records.
     */
    public function publicationAuthors(): HasMany
    {
        return $this->hasMany(PublicationAuthor::class);
    }

    /**
     * Check if the publication is published.
     */
    public function isPublished(): bool
    {
        return $this->status === 'published';
    }

    /**
     * Check if the publication is a draft.
     */
    public function isDraft(): bool
    {
        return $this->status === 'draft';
    }

    /**
     * Check if the publication is submitted.
     */
    public function isSubmitted(): bool
    {
        return $this->status === 'submitted';
    }

    /**
     * Check if the publication is archived.
     */
    public function isArchived(): bool
    {
        return $this->status === 'archived';
    }

    /**
     * Get the corresponding author(s).
     */
    public function getCorrespondingAuthorsAttribute()
    {
        return $this->authorResearchers()
                   ->wherePivot('is_corresponding_author', true)
                   ->get();
    }

    /**
     * Scope a query to only include published publications.
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    /**
     * Scope a query to filter by publication type.
     */
    public function scopeByType($query, string $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope a query to filter by publication year.
     */
    public function scopeByYear($query, int $year)
    {
        return $query->where('publication_year', $year);
    }

    /**
     * Scope a query to search publications by title.
     */
    public function scopeByTitle($query, string $title)
    {
        return $query->where('title', 'like', '%' . $title . '%');
    }

    /**
     * Scope a query to search publications by author name.
     */
    public function scopeByAuthor($query, string $author)
    {
        return $query->where('authors', 'like', '%' . $author . '%');
    }

    /**
     * Generate citation in APA format.
     */
    public function generateCitation(): string
    {
        $citation = $this->authors . ' (' . $this->publication_year . '). ' . $this->title . '. ';

        if ($this->journal) {
            $citation .= $this->journal;
            if ($this->volume) {
                $citation .= ', ' . $this->volume;
                if ($this->issue) {
                    $citation .= '(' . $this->issue . ')';
                }
            }
            if ($this->pages) {
                $citation .= ', ' . $this->pages;
            }
        } elseif ($this->conference) {
            $citation .= $this->conference;
        }

        if ($this->doi) {
            $citation .= '. DOI: ' . $this->doi;
        }

        return $citation;
    }
}