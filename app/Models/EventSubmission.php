<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventSubmission extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'event_id',
        'user_id',
        'title',
        'abstract',
        'authors',
        'submission_type',
        'category',
        'keywords',
        'paper_file',
        'presentation_file',
        'supplementary_files',
        'status',
        'reviewer_notes',
        'author_notes',
        'submitted_at',
        'reviewed_at',
        'reviewed_by',
        'review_score',
        'is_featured',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'submitted_at' => 'datetime',
            'reviewed_at' => 'datetime',
            'supplementary_files' => 'array',
            'is_featured' => 'boolean',
            'review_score' => 'integer',
        ];
    }

    /**
     * Get the event that owns the submission.
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Get the user who submitted.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the reviewer who reviewed the submission.
     */
    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    /**
     * Scope a query to only include pending submissions.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include accepted submissions.
     */
    public function scopeAccepted($query)
    {
        return $query->where('status', 'accepted');
    }

    /**
     * Scope a query to only include rejected submissions.
     */
    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    /**
     * Scope a query to only include submissions under review.
     */
    public function scopeUnderReview($query)
    {
        return $query->where('status', 'under_review');
    }

    /**
     * Check if submission is pending.
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if submission is accepted.
     */
    public function isAccepted(): bool
    {
        return $this->status === 'accepted';
    }

    /**
     * Check if submission is rejected.
     */
    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    /**
     * Mark submission as under review.
     */
    public function markAsUnderReview(): void
    {
        $this->update(['status' => 'under_review']);
    }

    /**
     * Accept the submission.
     */
    public function accept(?string $notes = null): void
    {
        $this->update([
            'status' => 'accepted',
            'reviewer_notes' => $notes,
            'reviewed_at' => now(),
            'reviewed_by' => auth()->id(),
        ]);
    }

    /**
     * Reject the submission.
     */
    public function reject(?string $notes = null): void
    {
        $this->update([
            'status' => 'rejected',
            'reviewer_notes' => $notes,
            'reviewed_at' => now(),
            'reviewed_by' => auth()->id(),
        ]);
    }

    /**
     * Request revision.
     */
    public function requestRevision(?string $notes = null): void
    {
        $this->update([
            'status' => 'revision_requested',
            'reviewer_notes' => $notes,
            'reviewed_at' => now(),
            'reviewed_by' => auth()->id(),
        ]);
    }
}
