<?php

namespace App\Models;

use App\Enums\ExperimentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Experiment extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'project_id',
        'user_id',
        'title',
        'description',
        'experiment_type',
        'experiment_date',
        'hypothesis',
        'procedure',
        'results',
        'status',
        'duration',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'experiment_date' => 'date',
            'status' => ExperimentStatus::class,
            'duration' => 'decimal:2',
        ];
    }

    /**
     * Get the project that owns the experiment.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the user who created the experiment.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Alias for user (researcher).
     */
    public function researcher(): BelongsTo
    {
        return $this->user();
    }

    /**
     * Get the files for the experiment.
     */
    public function files(): HasMany
    {
        return $this->hasMany(ExperimentFile::class);
    }

    /**
     * Get the comments for the experiment.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(ExperimentComment::class);
    }

    /**
     * Get the root-level comments (no parent).
     */
    public function rootComments(): HasMany
    {
        return $this->hasMany(ExperimentComment::class)
            ->whereNull('parent_id')
            ->orderBy('created_at', 'desc');
    }

    /**
     * Scope a query to only include planned experiments.
     */
    public function scopePlanned($query)
    {
        return $query->where('status', ExperimentStatus::PLANNED);
    }

    /**
     * Scope a query to only include in-progress experiments.
     */
    public function scopeInProgress($query)
    {
        return $query->where('status', ExperimentStatus::IN_PROGRESS);
    }

    /**
     * Scope a query to only include completed experiments.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', ExperimentStatus::COMPLETED);
    }
}
