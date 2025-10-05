<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Funding\StoreFundingSourceRequest;
use App\Http\Requests\Funding\UpdateFundingSourceRequest;
use App\Http\Requests\Funding\StoreProjectFundingRequest;
use App\Http\Requests\Funding\UpdateProjectFundingRequest;
use App\Models\FundingSource;
use App\Models\ProjectFunding;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class FundingController extends Controller
{
    /**
     * Display a listing of funding sources
     * GET /api/v1/funding
     */
    public function index(Request $request): JsonResponse
    {
        $filters = $request->only(['search', 'type']);
        $perPage = min($request->input('per_page', 15), 100);

        $query = FundingSource::query();

        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('name_ar', 'like', "%{$filters['search']}%")
                  ->orWhere('name_fr', 'like', "%{$filters['search']}%")
                  ->orWhere('name_en', 'like', "%{$filters['search']}%");
            });
        }

        if (!empty($filters['type'])) {
            $query->where('type', $filters['type']);
        }

        $fundingSources = $query->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'data' => [
                'funding' => $fundingSources->items()->map(function ($source) {
                    return [
                        'id' => $source->id,
                        'name' => $source->getName(),
                        'type' => $source->type,
                        'contact_info' => $source->contact_info,
                        'website' => $source->website,
                        'projects_count' => $source->projectFunding()->count(),
                        'total_funding' => $source->projectFunding()->sum('amount'),
                        'created_at' => $source->created_at,
                    ];
                }),
                'pagination' => [
                    'current_page' => $fundingSources->currentPage(),
                    'total_pages' => $fundingSources->lastPage(),
                    'total_items' => $fundingSources->total(),
                    'per_page' => $fundingSources->perPage(),
                ]
            ]
        ]);
    }

    /**
     * Store a newly created funding source
     * POST /api/v1/funding
     */
    public function store(StoreFundingSourceRequest $request): JsonResponse
    {
        $fundingSource = FundingSource::create($request->validated());

        return response()->json([
            'status' => 'success',
            'data' => [
                'funding_source' => [
                    'id' => $fundingSource->id,
                    'name' => $fundingSource->getName(),
                    'type' => $fundingSource->type,
                    'contact_info' => $fundingSource->contact_info,
                    'website' => $fundingSource->website,
                ]
            ],
            'message' => 'Funding source created successfully'
        ], 201);
    }

    /**
     * Display the specified funding source
     * GET /api/v1/funding/{id}
     */
    public function show(FundingSource $funding): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data' => [
                'funding_source' => [
                    'id' => $funding->id,
                    'name' => $funding->getName(),
                    'type' => $funding->type,
                    'contact_info' => $funding->contact_info,
                    'website' => $funding->website,
                    'projects' => $funding->projectFunding->map(function ($projectFunding) {
                        return [
                            'id' => $projectFunding->project->id,
                            'title' => $projectFunding->project->getTitle(),
                            'amount' => $projectFunding->amount,
                            'currency' => $projectFunding->currency,
                            'start_date' => $projectFunding->start_date,
                            'end_date' => $projectFunding->end_date,
                        ];
                    }),
                    'statistics' => [
                        'total_projects' => $funding->projectFunding()->count(),
                        'total_funding' => $funding->projectFunding()->sum('amount'),
                        'active_projects' => $funding->projectFunding()
                            ->whereHas('project', function ($q) {
                                $q->where('status', 'active');
                            })->count(),
                    ],
                    'created_at' => $funding->created_at,
                ]
            ]
        ]);
    }

    /**
     * Update the specified funding source
     * PUT /api/v1/funding/{id}
     */
    public function update(UpdateFundingSourceRequest $request, FundingSource $funding): JsonResponse
    {
        $funding->update($request->validated());

        return response()->json([
            'status' => 'success',
            'data' => [
                'funding_source' => [
                    'id' => $funding->id,
                    'name' => $funding->getName(),
                    'type' => $funding->type,
                    'contact_info' => $funding->contact_info,
                    'website' => $funding->website,
                ]
            ],
            'message' => 'Funding source updated successfully'
        ]);
    }

    /**
     * Remove the specified funding source
     * DELETE /api/v1/funding/{id}
     */
    public function destroy(FundingSource $funding): JsonResponse
    {
        if (!auth()->user()->isAdmin()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Access denied',
                'code' => 'INSUFFICIENT_PERMISSIONS'
            ], 403);
        }

        // Check if funding source has active projects
        $activeProjects = $funding->projectFunding()
            ->whereHas('project', function ($q) {
                $q->where('status', 'active');
            })->count();

        if ($activeProjects > 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'Cannot delete funding source with active projects',
                'code' => 'FUNDING_SOURCE_HAS_ACTIVE_PROJECTS'
            ], 422);
        }

        $funding->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Funding source deleted successfully'
        ]);
    }

    /**
     * Get funding budget details
     * GET /api/v1/funding/{id}/budget
     */
    public function budget(FundingSource $funding): JsonResponse
    {
        $projectFundings = $funding->projectFunding()->with(['project'])->get();

        $budget = [
            'funding_source_id' => $funding->id,
            'funding_source_name' => $funding->getName(),
            'total_allocated' => $projectFundings->sum('amount'),
            'currencies' => $projectFundings->groupBy('currency')->map(function ($group) {
                return [
                    'total_amount' => $group->sum('amount'),
                    'projects_count' => $group->count(),
                ];
            }),
            'projects' => $projectFundings->map(function ($projectFunding) {
                return [
                    'id' => $projectFunding->id,
                    'project' => [
                        'id' => $projectFunding->project->id,
                        'title' => $projectFunding->project->getTitle(),
                        'status' => $projectFunding->project->status,
                    ],
                    'amount' => $projectFunding->amount,
                    'currency' => $projectFunding->currency,
                    'start_date' => $projectFunding->start_date,
                    'end_date' => $projectFunding->end_date,
                    'grant_number' => $projectFunding->grant_number,
                    'is_active' => $projectFunding->isActive(),
                ];
            }),
        ];

        return response()->json([
            'status' => 'success',
            'data' => [
                'budget' => $budget
            ]
        ]);
    }
}

/**
 * Project Funding Controller
 */
class ProjectFundingController extends Controller
{
    /**
     * Store project funding
     * POST /api/v1/project-funding
     */
    public function store(StoreProjectFundingRequest $request): JsonResponse
    {
        $projectFunding = ProjectFunding::create($request->validated());
        $projectFunding->load(['project', 'fundingSource']);

        return response()->json([
            'status' => 'success',
            'data' => [
                'project_funding' => [
                    'id' => $projectFunding->id,
                    'project' => [
                        'id' => $projectFunding->project->id,
                        'title' => $projectFunding->project->getTitle(),
                    ],
                    'funding_source' => [
                        'id' => $projectFunding->fundingSource->id,
                        'name' => $projectFunding->fundingSource->getName(),
                    ],
                    'amount' => $projectFunding->amount,
                    'currency' => $projectFunding->currency,
                    'start_date' => $projectFunding->start_date,
                    'end_date' => $projectFunding->end_date,
                    'grant_number' => $projectFunding->grant_number,
                ]
            ],
            'message' => 'Project funding created successfully'
        ], 201);
    }

    /**
     * Update project funding
     * PUT /api/v1/project-funding/{id}
     */
    public function update(UpdateProjectFundingRequest $request, ProjectFunding $projectFunding): JsonResponse
    {
        $projectFunding->update($request->validated());
        $projectFunding->load(['project', 'fundingSource']);

        return response()->json([
            'status' => 'success',
            'data' => [
                'project_funding' => [
                    'id' => $projectFunding->id,
                    'amount' => $projectFunding->amount,
                    'currency' => $projectFunding->currency,
                    'start_date' => $projectFunding->start_date,
                    'end_date' => $projectFunding->end_date,
                    'grant_number' => $projectFunding->grant_number,
                ]
            ],
            'message' => 'Project funding updated successfully'
        ]);
    }

    /**
     * Remove project funding
     * DELETE /api/v1/project-funding/{id}
     */
    public function destroy(ProjectFunding $projectFunding): JsonResponse
    {
        $currentUser = auth()->user();

        if (!$currentUser->isAdmin() && !$currentUser->isLabManager() &&
            (!$currentUser->researcher || $currentUser->researcher->id !== $projectFunding->project->leader_id)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Access denied',
                'code' => 'INSUFFICIENT_PERMISSIONS'
            ], 403);
        }

        $projectFunding->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Project funding deleted successfully'
        ]);
    }
}