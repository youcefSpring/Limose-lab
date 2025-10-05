<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Researcher\StoreResearcherRequest;
use App\Http\Requests\Researcher\UpdateResearcherRequest;
use App\Models\Researcher;
use App\Services\ResearcherService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ResearcherController extends Controller
{
    public function __construct(
        private ResearcherService $researcherService
    ) {}

    /**
     * Display a listing of researchers
     * GET /api/v1/researchers
     */
    public function index(Request $request): JsonResponse
    {
        $filters = $request->only(['search', 'research_domain', 'status']);
        $perPage = min($request->input('per_page', 15), 100);

        $researchers = $this->researcherService->getResearchers($filters, $perPage);

        return response()->json([
            'status' => 'success',
            'data' => [
                'researchers' => $researchers->items()->map(function ($researcher) {
                    return [
                        'id' => $researcher->id,
                        'user_id' => $researcher->user_id,
                        'name' => $researcher->full_name,
                        'first_name' => $researcher->first_name,
                        'last_name' => $researcher->last_name,
                        'research_domain' => $researcher->research_domain,
                        'google_scholar_url' => $researcher->google_scholar_url,
                        'projects_count' => $researcher->leadProjects()->count() + $researcher->projects()->count(),
                        'publications_count' => $researcher->publications()->count(),
                        'collaborations_count' => $researcher->coordinatedCollaborations()->count(),
                        'bio' => $researcher->getBio(),
                        'photo_url' => $researcher->photo_path ? url("storage/{$researcher->photo_path}") : null,
                        'created_at' => $researcher->created_at,
                    ];
                }),
                'pagination' => [
                    'current_page' => $researchers->currentPage(),
                    'total_pages' => $researchers->lastPage(),
                    'total_items' => $researchers->total(),
                    'per_page' => $researchers->perPage(),
                    'has_next_page' => $researchers->hasMorePages(),
                    'has_previous_page' => $researchers->currentPage() > 1,
                ]
            ]
        ]);
    }

    /**
     * Store a newly created researcher
     * POST /api/v1/researchers
     */
    public function store(StoreResearcherRequest $request): JsonResponse
    {
        $researcher = $this->researcherService->createResearcher($request->validated());

        return response()->json([
            'status' => 'success',
            'data' => [
                'researcher' => [
                    'id' => $researcher->id,
                    'user_id' => $researcher->user_id,
                    'name' => $researcher->full_name,
                    'first_name' => $researcher->first_name,
                    'last_name' => $researcher->last_name,
                    'research_domain' => $researcher->research_domain,
                    'google_scholar_url' => $researcher->google_scholar_url,
                    'bio' => $researcher->getBio(),
                    'photo_url' => $researcher->photo_path ? url("storage/{$researcher->photo_path}") : null,
                    'cv_url' => $researcher->cv_path ? url("storage/{$researcher->cv_path}") : null,
                ]
            ],
            'message' => 'Researcher profile created successfully'
        ], 201);
    }

    /**
     * Display the specified researcher
     * GET /api/v1/researchers/{id}
     */
    public function show(Researcher $researcher): JsonResponse
    {
        $statistics = $this->researcherService->getResearcherStatistics($researcher);

        return response()->json([
            'status' => 'success',
            'data' => [
                'researcher' => [
                    'id' => $researcher->id,
                    'user_id' => $researcher->user_id,
                    'name' => $researcher->full_name,
                    'first_name' => $researcher->first_name,
                    'last_name' => $researcher->last_name,
                    'research_domain' => $researcher->research_domain,
                    'google_scholar_url' => $researcher->google_scholar_url,
                    'bio' => $researcher->getBio(),
                    'photo_url' => $researcher->photo_path ? url("storage/{$researcher->photo_path}") : null,
                    'cv_url' => $researcher->cv_path ? url("storage/{$researcher->cv_path}") : null,
                    'user' => [
                        'id' => $researcher->user->id,
                        'name' => $researcher->user->name,
                        'email' => $researcher->user->email,
                        'role' => $researcher->user->role,
                        'orcid' => $researcher->user->orcid,
                        'phone' => $researcher->user->phone,
                    ],
                    'statistics' => $statistics,
                    'created_at' => $researcher->created_at,
                    'updated_at' => $researcher->updated_at,
                ]
            ]
        ]);
    }

    /**
     * Update the specified researcher
     * PUT /api/v1/researchers/{id}
     */
    public function update(UpdateResearcherRequest $request, Researcher $researcher): JsonResponse
    {
        $updatedResearcher = $this->researcherService->updateResearcher($researcher, $request->validated());

        return response()->json([
            'status' => 'success',
            'data' => [
                'researcher' => [
                    'id' => $updatedResearcher->id,
                    'user_id' => $updatedResearcher->user_id,
                    'name' => $updatedResearcher->full_name,
                    'first_name' => $updatedResearcher->first_name,
                    'last_name' => $updatedResearcher->last_name,
                    'research_domain' => $updatedResearcher->research_domain,
                    'google_scholar_url' => $updatedResearcher->google_scholar_url,
                    'bio' => $updatedResearcher->getBio(),
                    'photo_url' => $updatedResearcher->photo_path ? url("storage/{$updatedResearcher->photo_path}") : null,
                    'cv_url' => $updatedResearcher->cv_path ? url("storage/{$updatedResearcher->cv_path}") : null,
                ]
            ],
            'message' => 'Researcher profile updated successfully'
        ]);
    }

    /**
     * Remove the specified researcher
     * DELETE /api/v1/researchers/{id}
     */
    public function destroy(Researcher $researcher): JsonResponse
    {
        if (!auth()->user()->isAdmin() && !auth()->user()->isLabManager()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Access denied',
                'code' => 'INSUFFICIENT_PERMISSIONS'
            ], 403);
        }

        $this->researcherService->deleteResearcher($researcher);

        return response()->json([
            'status' => 'success',
            'message' => 'Researcher profile deleted successfully'
        ]);
    }

    /**
     * Get researcher projects
     * GET /api/v1/researchers/{id}/projects
     */
    public function projects(Request $request, Researcher $researcher): JsonResponse
    {
        $projects = $this->researcherService->getResearcherProjects($researcher);

        return response()->json([
            'status' => 'success',
            'data' => [
                'projects' => $projects->map(function ($project) {
                    return [
                        'id' => $project->id,
                        'title' => $project->getTitle(),
                        'status' => $project->status,
                        'start_date' => $project->start_date,
                        'end_date' => $project->end_date,
                        'budget' => $project->budget,
                        'role' => $project->pivot->role ?? ($project->leader_id === $project->id ? 'leader' : 'member'),
                    ];
                })
            ]
        ]);
    }

    /**
     * Get researcher publications
     * GET /api/v1/researchers/{id}/publications
     */
    public function publications(Request $request, Researcher $researcher): JsonResponse
    {
        $publications = $this->researcherService->getResearcherPublications($researcher);

        return response()->json([
            'status' => 'success',
            'data' => [
                'publications' => $publications->map(function ($publication) {
                    return [
                        'id' => $publication->id,
                        'title' => $publication->title,
                        'type' => $publication->type,
                        'journal' => $publication->journal,
                        'conference' => $publication->conference,
                        'publication_year' => $publication->publication_year,
                        'doi' => $publication->doi,
                        'author_order' => $publication->pivot->author_order ?? null,
                        'is_corresponding_author' => $publication->pivot->is_corresponding_author ?? false,
                    ];
                })
            ]
        ]);
    }

    /**
     * Get researcher collaborations
     * GET /api/v1/researchers/{id}/collaborations
     */
    public function collaborations(Request $request, Researcher $researcher): JsonResponse
    {
        $collaborations = $this->researcherService->getResearcherCollaborations($researcher);

        return response()->json([
            'status' => 'success',
            'data' => [
                'collaborations' => $collaborations->map(function ($collaboration) {
                    return [
                        'id' => $collaboration->id,
                        'title' => $collaboration->getTitle(),
                        'institution_name' => $collaboration->institution_name,
                        'country' => $collaboration->country,
                        'type' => $collaboration->type,
                        'status' => $collaboration->status,
                        'start_date' => $collaboration->start_date,
                        'end_date' => $collaboration->end_date,
                    ];
                })
            ]
        ]);
    }

    /**
     * Get researcher dashboard
     * GET /api/v1/researchers/{id}/dashboard
     */
    public function dashboard(Request $request, Researcher $researcher): JsonResponse
    {
        // Only allow researchers to view their own dashboard unless admin
        $currentUser = auth()->user();
        if (!$currentUser->isAdmin() && (!$currentUser->researcher || $currentUser->researcher->id !== $researcher->id)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Access denied',
                'code' => 'INSUFFICIENT_PERMISSIONS'
            ], 403);
        }

        $dashboard = $this->researcherService->getResearcherDashboard($researcher);

        return response()->json([
            'status' => 'success',
            'data' => $dashboard
        ]);
    }

    /**
     * Search researchers
     * GET /api/v1/researchers/search
     */
    public function search(Request $request): JsonResponse
    {
        $request->validate([
            'query' => 'required|string|min:2',
            'research_domain' => 'nullable|string',
        ]);

        $researchers = $this->researcherService->searchResearchers(
            $request->query,
            $request->only(['research_domain'])
        );

        return response()->json([
            'status' => 'success',
            'data' => [
                'researchers' => $researchers->map(function ($researcher) {
                    return [
                        'id' => $researcher->id,
                        'name' => $researcher->full_name,
                        'research_domain' => $researcher->research_domain,
                        'photo_url' => $researcher->photo_path ? url("storage/{$researcher->photo_path}") : null,
                    ];
                })
            ]
        ]);
    }
}