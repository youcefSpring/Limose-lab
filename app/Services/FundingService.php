<?php

namespace App\Services;

use App\Models\FundingSource;
use App\Models\ProjectFunding;
use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FundingService
{
    public function __construct(
        private NotificationService $notificationService
    ) {}

    /**
     * Get paginated list of funding (sources and project funding) with filters.
     */
    public function getFunding(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        // For now, return project funding as the main "funding" data
        return $this->getProjectFunding($filters, $perPage);
    }

    /**
     * Get paginated list of funding sources with filters.
     */
    public function getFundingSources(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = FundingSource::query();

        // Apply filters
        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('description', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('contact_email', 'like', '%' . $filters['search'] . '%');
            });
        }

        if (!empty($filters['type'])) {
            $query->where('type', $filters['type']);
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['country'])) {
            $query->where('country', $filters['country']);
        }

        return $query->orderBy('name')
                    ->paginate($perPage);
    }

    /**
     * Create new funding (project funding).
     */
    public function createFunding(array $fundingData): ProjectFunding
    {
        return $this->createProjectFunding($fundingData);
    }

    /**
     * Create a new funding source.
     */
    public function createFundingSource(array $fundingData): FundingSource
    {
        return DB::transaction(function () use ($fundingData) {
            $fundingSource = FundingSource::create($fundingData);

            // Log creation
            Log::info("Funding source created", [
                'funding_source_id' => $fundingSource->id,
                'name' => $fundingSource->name,
                'type' => $fundingSource->type
            ]);

            return $fundingSource;
        });
    }

    /**
     * Update funding source.
     */
    public function updateFundingSource(FundingSource $fundingSource, array $updateData): FundingSource
    {
        return DB::transaction(function () use ($fundingSource, $updateData) {
            $fundingSource->update($updateData);

            Log::info("Funding source updated", [
                'funding_source_id' => $fundingSource->id,
                'changes' => $updateData
            ]);

            return $fundingSource->fresh();
        });
    }

    /**
     * Delete funding source.
     */
    public function deleteFundingSource(FundingSource $fundingSource): bool
    {
        return DB::transaction(function () use ($fundingSource) {
            // Check if funding source has active projects
            $activeProjectsCount = $fundingSource->projectFunding()
                ->whereHas('project', function ($q) {
                    $q->whereIn('status', ['active', 'ongoing']);
                })
                ->count();

            if ($activeProjectsCount > 0) {
                throw new \Exception("Cannot delete funding source with active projects. Please complete or transfer the projects first.");
            }

            Log::info("Funding source deleted", [
                'funding_source_id' => $fundingSource->id,
                'name' => $fundingSource->name
            ]);

            return $fundingSource->delete();
        });
    }

    /**
     * Get paginated list of project funding with filters.
     */
    public function getProjectFunding(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = ProjectFunding::with(['project', 'fundingSource']);

        // Apply filters
        if (!empty($filters['project_id'])) {
            $query->where('project_id', $filters['project_id']);
        }

        if (!empty($filters['funding_source_id'])) {
            $query->where('funding_source_id', $filters['funding_source_id']);
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['year'])) {
            $query->whereYear('start_date', $filters['year']);
        }

        return $query->orderBy('start_date', 'desc')
                    ->paginate($perPage);
    }

    /**
     * Create project funding.
     */
    public function createProjectFunding(array $fundingData): ProjectFunding
    {
        return DB::transaction(function () use ($fundingData) {
            $projectFunding = ProjectFunding::create($fundingData);

            // Update project budget if needed
            $project = $projectFunding->project;
            $totalFunding = $project->funding()->sum('amount');

            if ($totalFunding > $project->budget) {
                $project->update(['budget' => $totalFunding]);
            }

            Log::info("Project funding created", [
                'project_funding_id' => $projectFunding->id,
                'project_id' => $projectFunding->project_id,
                'funding_source_id' => $projectFunding->funding_source_id,
                'amount' => $projectFunding->amount
            ]);

            return $projectFunding;
        });
    }

    /**
     * Update project funding.
     */
    public function updateProjectFunding(ProjectFunding $projectFunding, array $updateData): ProjectFunding
    {
        return DB::transaction(function () use ($projectFunding, $updateData) {
            $projectFunding->update($updateData);

            // Recalculate project budget if amount changed
            if (isset($updateData['amount'])) {
                $project = $projectFunding->project;
                $totalFunding = $project->funding()->sum('amount');

                if ($totalFunding > $project->budget) {
                    $project->update(['budget' => $totalFunding]);
                }
            }

            Log::info("Project funding updated", [
                'project_funding_id' => $projectFunding->id,
                'changes' => $updateData
            ]);

            return $projectFunding->fresh();
        });
    }

    /**
     * Delete project funding.
     */
    public function deleteProjectFunding(ProjectFunding $projectFunding): bool
    {
        return DB::transaction(function () use ($projectFunding) {
            Log::info("Project funding deleted", [
                'project_funding_id' => $projectFunding->id,
                'project_id' => $projectFunding->project_id,
                'amount' => $projectFunding->amount
            ]);

            return $projectFunding->delete();
        });
    }

    /**
     * Get funding analytics with filters.
     */
    public function getFundingAnalytics(array $filters = []): array
    {
        $statistics = $this->getFundingStatistics();

        // Add filtered analytics based on provided filters
        if (!empty($filters['year'])) {
            $statistics['yearly_breakdown'] = ProjectFunding::whereYear('start_date', $filters['year'])
                ->selectRaw('MONTH(start_date) as month, COUNT(*) as count, SUM(amount) as total_amount')
                ->groupBy('month')
                ->orderBy('month')
                ->get()
                ->mapWithKeys(function ($item) {
                    return [$item->month => [
                        'count' => $item->count,
                        'total_amount' => $item->total_amount
                    ]];
                });
        }

        return $statistics;
    }

    /**
     * Get funding statistics.
     */
    public function getFundingStatistics(): array
    {
        return [
            'total_funding_sources' => FundingSource::count(),
            'active_funding_sources' => FundingSource::where('status', 'active')->count(),
            'total_funded_projects' => ProjectFunding::distinct('project_id')->count(),
            'total_funding_amount' => ProjectFunding::sum('amount'),
            'funding_by_type' => FundingSource::selectRaw('type, COUNT(*) as count, SUM(COALESCE((SELECT SUM(amount) FROM project_funding WHERE funding_source_id = funding_sources.id), 0)) as total_amount')
                ->groupBy('type')
                ->get()
                ->mapWithKeys(function ($item) {
                    return [$item->type => [
                        'count' => $item->count,
                        'total_amount' => $item->total_amount ?? 0
                    ]];
                }),
            'funding_by_year' => ProjectFunding::selectRaw('YEAR(start_date) as year, COUNT(*) as count, SUM(amount) as total_amount')
                ->groupBy('year')
                ->orderBy('year', 'desc')
                ->get()
                ->mapWithKeys(function ($item) {
                    return [$item->year => [
                        'count' => $item->count,
                        'total_amount' => $item->total_amount
                    ]];
                }),
        ];
    }

    /**
     * Get funding opportunities (active funding sources).
     */
    public function getFundingOpportunities(int $limit = 10): Collection
    {
        return FundingSource::where('status', 'active')
            ->where('application_deadline', '>', now())
            ->orderBy('application_deadline')
            ->limit($limit)
            ->get();
    }

    /**
     * Get project funding summary.
     */
    public function getProjectFundingSummary(Project $project): array
    {
        $funding = $project->funding()->with('fundingSource')->get();

        return [
            'total_funding' => $funding->sum('amount'),
            'funding_count' => $funding->count(),
            'funding_sources' => $funding->groupBy('fundingSource.type')->map(function ($items, $type) {
                return [
                    'type' => $type,
                    'count' => $items->count(),
                    'total_amount' => $items->sum('amount'),
                    'sources' => $items->pluck('fundingSource.name')->unique()->values()
                ];
            }),
            'funding_timeline' => $funding->sortBy('start_date')->map(function ($item) {
                return [
                    'funding_source' => $item->fundingSource->name,
                    'amount' => $item->amount,
                    'start_date' => $item->start_date,
                    'end_date' => $item->end_date,
                    'status' => $item->status
                ];
            })->values(),
        ];
    }

    /**
     * Search funding sources.
     */
    public function searchFundingSources(array $filters = []): Collection
    {
        $query = FundingSource::query();

        if (!empty($filters['query'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['query'] . '%')
                  ->orWhere('description', 'like', '%' . $filters['query'] . '%');
            });
        }

        if (!empty($filters['type'])) {
            $query->where('type', $filters['type']);
        }

        if (!empty($filters['country'])) {
            $query->where('country', $filters['country']);
        }

        if (!empty($filters['min_amount'])) {
            $query->where('max_amount', '>=', $filters['min_amount']);
        }

        if (!empty($filters['max_amount'])) {
            $query->where('min_amount', '<=', $filters['max_amount']);
        }

        return $query->where('status', 'active')
                    ->orderBy('application_deadline')
                    ->limit(50)
                    ->get();
    }

    /**
     * Get funding recommendations for a project.
     */
    public function getFundingRecommendations(Project $project, int $limit = 5): Collection
    {
        // Simple recommendation based on project budget and research domain
        $query = FundingSource::where('status', 'active')
            ->where('application_deadline', '>', now());

        // Filter by budget range
        if ($project->budget) {
            $query->where(function ($q) use ($project) {
                $q->where('min_amount', '<=', $project->budget)
                  ->where('max_amount', '>=', $project->budget);
            });
        }

        // Could add more sophisticated matching based on research domains, keywords, etc.

        return $query->orderBy('application_deadline')
                    ->limit($limit)
                    ->get();
    }
}