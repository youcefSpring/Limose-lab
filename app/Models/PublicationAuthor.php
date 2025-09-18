<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PublicationAuthor extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'publication_id',
        'researcher_id',
        'author_order',
        'is_corresponding_author',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_corresponding_author' => 'boolean',
        'author_order' => 'integer',
    ];

    /**
     * Get the publication that this authorship belongs to.
     */
    public function publication(): BelongsTo
    {
        return $this->belongsTo(Publication::class);
    }

    /**
     * Get the researcher for this authorship.
     */
    public function researcher(): BelongsTo
    {
        return $this->belongsTo(Researcher::class);
    }

    /**
     * Scope a query to only include corresponding authors.
     */
    public function scopeCorrespondingAuthors($query)
    {
        return $query->where('is_corresponding_author', true);
    }

    /**
     * Scope a query to order by author order.
     */
    public function scopeOrderedByAuthorOrder($query)
    {
        return $query->orderBy('author_order');
    }

    /**
     * Check if this is the first author.
     */
    public function isFirstAuthor(): bool
    {
        return $this->author_order === 1;
    }

    /**
     * Check if this is the corresponding author.
     */
    public function isCorrespondingAuthor(): bool
    {
        return $this->is_corresponding_author;
    }
}