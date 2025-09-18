<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectMember extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'project_id',
        'researcher_id',
        'role',
        'joined_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'joined_at' => 'datetime',
    ];

    /**
     * Get the project that this membership belongs to.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the researcher for this membership.
     */
    public function researcher(): BelongsTo
    {
        return $this->belongsTo(Researcher::class);
    }

    /**
     * Scope a query to only include members with a specific role.
     */
    public function scopeByRole($query, string $role)
    {
        return $query->where('role', $role);
    }

    /**
     * Check if the member is a principal investigator.
     */
    public function isPrincipalInvestigator(): bool
    {
        return $this->role === 'principal_investigator' || $this->role === 'PI';
    }

    /**
     * Check if the member is a co-investigator.
     */
    public function isCoInvestigator(): bool
    {
        return $this->role === 'co_investigator' || $this->role === 'co-PI';
    }
}