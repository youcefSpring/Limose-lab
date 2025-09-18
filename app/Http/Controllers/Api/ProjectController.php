<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Models\Project;
use App\Models\Researcher;
use App\Services\ProjectService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProjectController extends Controller
{
    public function __construct(
        private ProjectService $projectService
    ) {}

    /**
     * Display a listing of projects
     * GET /api/v1/projects
     */
    public function index(Request $request): JsonResponse
    {
        $filters = $request->only([
            'search', 'status', 'researcher_id', 'funding_id',
            'start_date_from', 'start_date_to'
        ]);
        $perPage = min($request->input('per_page', 15), 100);

        $projects = $this->projectService->getProjects($filters, $perPage);

        return response()->json([
            'status' => 'success',
            'data' => [
                'projects' => $projects->items()->map(function ($project) {
                    return [
                        'id' => $project->id,
                        'title' => $project->getTitle(),
                        'description' => $project->getDescription(),
                        'status' => $project->status,
                        'start_date' => $project->start_date,
                        'end_date' => $project->end_date,
                        'budget' => $project->budget,
                        'progress_percentage' => $project->getProgressPercentage(),
                        'duration_days' => $project->duration,
                        'principal_investigator' => [
                            'id' => $project->leader->id,
                            'name' => $project->leader->full_name,
                        ],
                        'members_count' => $project->members()->count(),
                        'publications_count' => $project->publications()->count(),
                        'funding' => $project->funding ? [
                            'total_amount' => $project->funding->sum('amount'),
                            'sources_count' => $project->funding->count(),
                        ] : null,
                        'created_at' => $project->created_at,
                    ];
                }),
                'pagination' => [
                    'current_page' => $projects->currentPage(),
                    'total_pages' => $projects->lastPage(),
                    'total_items' => $projects->total(),
                    'per_page' => $projects->perPage(),
                    'has_next_page' => $projects->hasMorePages(),
                    'has_previous_page' => $projects->currentPage() > 1,
                ]
            ]
        ]);
    }

    /**
     * Store a newly created project
     * POST /api/v1/projects
     */
    public function store(StoreProjectRequest $request): JsonResponse
    {
        $project = $this->projectService->createProject($request->validated());

        return response()->json([
            'status' => 'success',
            'data' => [
                'project' => [
                    'id' => $project->id,
                    'title' => $project->getTitle(),
                    'description' => $project->getDescription(),
                    'status' => $project->status,
                    'start_date' => $project->start_date,
                    'end_date' => $project->end_date,
                    'budget' => $project->budget,
                    'principal_investigator' => [
                        'id' => $project->leader->id,
                        'name' => $project->leader->full_name,
                        'email' => $project->leader->user->email,
                    ],
                    'members' => $project->members->map(function ($member) {
                        return [
                            'id' => $member->id,
                            'name' => $member->full_name,
                            'role' => $member->pivot->role ?? 'member',
                        ];
                    }),
                ]
            ],
            'message' => 'Project created successfully'
        ], 201);
    }

    /**
     * Display the specified project
     * GET /api/v1/projects/{id}
     */
    public function show(Project $project): JsonResponse
    {
        $statistics = $this->projectService->getProjectStatistics($project);

        return response()->json([
            'status' => 'success',
            'data' => [
                'project' => [
                    'id' => $project->id,
                    'title' => $project->getTitle(),
                    'description' => $project->getDescription(),
                    'status' => $project->status,
                    'start_date' => $project->start_date,
                    'end_date' => $project->end_date,
                    'budget' => $project->budget,
                    'progress_percentage' => $project->getProgressPercentage(),
                    'duration_days' => $project->duration,
                    'principal_investigator' => [
                        'id' => $project->leader->id,
                        'name' => $project->leader->full_name,
                        'email' => $project->leader->user->email,
                        'research_domain' => $project->leader->research_domain,
                    ],
                    'members' => $project->members->map(function ($member) {
                        return [
                            'id' => $member->id,
                            'name' => $member->full_name,
                            'email' => $member->user->email,
                            'role' => $member->pivot->role ?? 'member',
                            'joined_at' => $member->pivot->created_at,
                        ];
                    }),
                    'publications' => $project->publications->map(function ($publication) {
                        return [
                            'id' => $publication->id,
                            'title' => $publication->title,
                            'type' => $publication->type,
                            'publication_year' => $publication->publication_year,
                            'doi' => $publication->doi,
                        ];
                    }),
                    'funding' => $project->funding->map(function ($funding) {
                        return [
                            'id' => $funding->id,
                            'source' => $funding->fundingSource->getName(),
                            'amount' => $funding->amount,
                            'currency' => $funding->currency,
                            'start_date' => $funding->start_date,
                            'end_date' => $funding->end_date,
                        ];
                    }),
                    'statistics' => $statistics,
                    'created_at' => $project->created_at,
                    'updated_at' => $project->updated_at,
                ]
            ]
        ]);
    }

    /**
     * Update the specified project
     * PUT /api/v1/projects/{id}
     */
    public function update(UpdateProjectRequest $request, Project $project): JsonResponse
    {
        $updatedProject = $this->projectService->updateProject($project, $request->validated());

        return response()->json([
            'status' => 'success',
            'data' => [
                'project' => [
                    'id' => $updatedProject->id,
                    'title' => $updatedProject->getTitle(),
                    'description' => $updatedProject->getDescription(),
                    'status' => $updatedProject->status,
                    'start_date' => $updatedProject->start_date,
                    'end_date' => $updatedProject->end_date,
                    'budget' => $updatedProject->budget,
                    'progress_percentage' => $updatedProject->getProgressPercentage(),
                ]
            ],
            'message' => 'Project updated successfully'
        ]);
    }

    /**
     * Remove the specified project
     * DELETE /api/v1/projects/{id}
     */
    public function destroy(Project $project): JsonResponse
    {
        $currentUser = auth()->user();

        if (!$currentUser->isAdmin() && !$currentUser->isLabManager() &&
            (!$currentUser->researcher || $currentUser->researcher->id !== $project->leader_id)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Access denied',
                'code' => 'INSUFFICIENT_PERMISSIONS'
            ], 403);
        }

        $this->projectService->deleteProject($project);

        return response()->json([
            'status' => 'success',
            'message' => 'Project deleted successfully'
        ]);
    }

    /**
     * Add member to project
     * POST /api/v1/projects/{id}/members
     */
    public function addMember(Request $request, Project $project): JsonResponse
    {
        $request->validate([
            'researcher_id' => 'required|exists:researchers,id',
            'role' => 'nullable|string|max:100',
        ]);

        $researcher = Researcher::findOrFail($request->researcher_id);

        $this->projectService->addProjectMember($project, $researcher, $request->role);

        return response()->json([
            'status' => 'success',
            'message' => 'Member added to project successfully'
        ]);
    }

    /**
     * Remove member from project
     * DELETE /api/v1/projects/{id}/members/{member_id}
     */
    public function removeMember(Project $project, Researcher $member): JsonResponse
    {
        $this->projectService->removeProjectMember($project, $member);

        return response()->json([
            'status' => 'success',
            'message' => 'Member removed from project successfully'
        ]);
    }

    /**
     * Update project status
     * PUT /api/v1/projects/{id}/status
     */
    public function updateStatus(Request $request, Project $project): JsonResponse
    {
        $request->validate([
            'status' => 'required|in:pending,active,completed,suspended',
            'reason' => 'nullable|string|max:500',
        ]);

        $updatedProject = $this->projectService->changeProjectStatus(
            $project,
            $request->status,
            $request->reason
        );

        return response()->json([
            'status' => 'success',
            'data' => [
                'project' => [
                    'id' => $updatedProject->id,
                    'status' => $updatedProject->status,
                ]
            ],
            'message' => 'Project status updated successfully'
        ]);
    }

    /**
     * Get project timeline
     * GET /api/v1/projects/{id}/timeline
     */
    public function timeline(Project $project): JsonResponse
    {
        $timeline = $this->projectService->getProjectTimeline($project);

        return response()->json([
            'status' => 'success',
            'data' => [
                'timeline' => $timeline
            ]
        ]);
    }

    /**
     * Upload project document
     * POST /api/v1/projects/{id}/documents
     */
    public function uploadDocument(Request $request, Project $project): JsonResponse
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf,doc,docx,ppt,pptx|max:20480',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'type' => 'required|string|in:proposal,report,presentation,other',
        ]);

        $filePath = $this->projectService->uploadProjectDocument(
            $project,
            $request->file('file'),
            $request->type,
            $request->only(['title', 'description'])
        );

        return response()->json([
            'status' => 'success',
            'data' => [
                'document' => [
                    'file_path' => $filePath,
                    'title' => $request->title,
                    'type' => $request->type,
                    'url' => url("storage/{$filePath}"),
                ]
            ],
            'message' => 'Document uploaded successfully'
        ]);
    }

    /**
     * Search projects
     * GET /api/v1/projects/search
     */
    public function search(Request $request): JsonResponse
    {
        $request->validate([
            'query' => 'required|string|min:2',
            'status' => 'nullable|string',
        ]);

        $projects = $this->projectService->searchProjects(
            $request->query,
            $request->only(['status'])
        );

        return response()->json([
            'status' => 'success',
            'data' => [
                'projects' => $projects->map(function ($project) {
                    return [
                        'id' => $project->id,
                        'title' => $project->getTitle(),
                        'status' => $project->status,
                        'principal_investigator' => $project->leader->full_name,
                        'start_date' => $project->start_date,
                    ];
                })
            ]
        ]);
    }
}