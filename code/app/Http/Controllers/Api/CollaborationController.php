<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Collaboration\StoreCollaborationRequest;
use App\Http\Requests\Collaboration\UpdateCollaborationRequest;
use App\Models\Collaboration;
use App\Services\CollaborationService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CollaborationController extends Controller
{
    public function __construct(
        private CollaborationService $collaborationService
    ) {}

    /**
     * Display a listing of collaborations
     * GET /api/v1/collaborations
     */
    public function index(Request $request): JsonResponse
    {
        $filters = $request->only([
            'search', 'type', 'status', 'country', 'coordinator_id', 'active_only'
        ]);
        $perPage = min($request->input('per_page', 15), 100);

        $collaborations = $this->collaborationService->getCollaborations($filters, $perPage);

        return response()->json([
            'status' => 'success',
            'data' => [
                'collaborations' => $collaborations->items()->map(function ($collaboration) {
                    return [
                        'id' => $collaboration->id,
                        'title' => $collaboration->getTitle(),
                        'description' => $collaboration->getDescription(),
                        'institution_name' => $collaboration->institution_name,
                        'country' => $collaboration->country,
                        'type' => $collaboration->type,
                        'status' => $collaboration->status,
                        'start_date' => $collaboration->start_date,
                        'end_date' => $collaboration->end_date,
                        'duration_days' => $collaboration->duration,
                        'is_active' => $collaboration->isActive(),
                        'is_ongoing' => $collaboration->isCurrentlyValid(),
                        'coordinator' => [
                            'id' => $collaboration->coordinator->id,
                            'name' => $collaboration->coordinator->full_name,
                        ],
                        'contact_person' => $collaboration->contact_person,
                        'contact_email' => $collaboration->contact_email,
                        'created_at' => $collaboration->created_at,
                    ];
                }),
                'pagination' => [
                    'current_page' => $collaborations->currentPage(),
                    'total_pages' => $collaborations->lastPage(),
                    'total_items' => $collaborations->total(),
                    'per_page' => $collaborations->perPage(),
                    'has_next_page' => $collaborations->hasMorePages(),
                    'has_previous_page' => $collaborations->currentPage() > 1,
                ]
            ]
        ]);
    }

    /**
     * Store a newly created collaboration
     * POST /api/v1/collaborations
     */
    public function store(StoreCollaborationRequest $request): JsonResponse
    {
        $coordinatorId = $request->coordinator_id ?? auth()->user()->researcher->id;
        $coordinator = \App\Models\Researcher::findOrFail($coordinatorId);

        $collaboration = $this->collaborationService->createCollaboration(
            $request->validated(),
            $coordinator
        );

        return response()->json([
            'status' => 'success',
            'data' => [
                'collaboration' => [
                    'id' => $collaboration->id,
                    'title' => $collaboration->getTitle(),
                    'description' => $collaboration->getDescription(),
                    'institution_name' => $collaboration->institution_name,
                    'country' => $collaboration->country,
                    'type' => $collaboration->type,
                    'status' => $collaboration->status,
                    'start_date' => $collaboration->start_date,
                    'end_date' => $collaboration->end_date,
                    'coordinator' => [
                        'id' => $collaboration->coordinator->id,
                        'name' => $collaboration->coordinator->full_name,
                        'email' => $collaboration->coordinator->user->email,
                    ],
                    'contact_person' => $collaboration->contact_person,
                    'contact_email' => $collaboration->contact_email,
                ]
            ],
            'message' => 'Collaboration created successfully'
        ], 201);
    }

    /**
     * Display the specified collaboration
     * GET /api/v1/collaborations/{id}
     */
    public function show(Collaboration $collaboration): JsonResponse
    {
        $statistics = $this->collaborationService->getCollaborationStatistics($collaboration);
        $timeline = $this->collaborationService->getCollaborationTimeline($collaboration);

        return response()->json([
            'status' => 'success',
            'data' => [
                'collaboration' => [
                    'id' => $collaboration->id,
                    'title' => $collaboration->getTitle(),
                    'description' => $collaboration->getDescription(),
                    'institution_name' => $collaboration->institution_name,
                    'country' => $collaboration->country,
                    'type' => $collaboration->type,
                    'status' => $collaboration->status,
                    'start_date' => $collaboration->start_date,
                    'end_date' => $collaboration->end_date,
                    'coordinator' => [
                        'id' => $collaboration->coordinator->id,
                        'name' => $collaboration->coordinator->full_name,
                        'email' => $collaboration->coordinator->user->email,
                        'research_domain' => $collaboration->coordinator->research_domain,
                    ],
                    'contact_person' => $collaboration->contact_person,
                    'contact_email' => $collaboration->contact_email,
                    'statistics' => $statistics,
                    'timeline' => $timeline,
                    'created_at' => $collaboration->created_at,
                    'updated_at' => $collaboration->updated_at,
                ]
            ]
        ]);
    }

    /**
     * Update the specified collaboration
     * PUT /api/v1/collaborations/{id}
     */
    public function update(UpdateCollaborationRequest $request, Collaboration $collaboration): JsonResponse
    {
        $updatedCollaboration = $this->collaborationService->updateCollaboration(
            $collaboration,
            $request->validated()
        );

        return response()->json([
            'status' => 'success',
            'data' => [
                'collaboration' => [
                    'id' => $updatedCollaboration->id,
                    'title' => $updatedCollaboration->getTitle(),
                    'description' => $updatedCollaboration->getDescription(),
                    'institution_name' => $updatedCollaboration->institution_name,
                    'country' => $updatedCollaboration->country,
                    'type' => $updatedCollaboration->type,
                    'status' => $updatedCollaboration->status,
                    'start_date' => $updatedCollaboration->start_date,
                    'end_date' => $updatedCollaboration->end_date,
                ]
            ],
            'message' => 'Collaboration updated successfully'
        ]);
    }

    /**
     * Remove the specified collaboration
     * DELETE /api/v1/collaborations/{id}
     */
    public function destroy(Collaboration $collaboration): JsonResponse
    {
        $currentUser = auth()->user();

        if (!$currentUser->isAdmin() && !$currentUser->isLabManager() &&
            (!$currentUser->researcher || $currentUser->researcher->id !== $collaboration->coordinator_id)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Access denied',
                'code' => 'INSUFFICIENT_PERMISSIONS'
            ], 403);
        }

        $collaboration->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Collaboration deleted successfully'
        ]);
    }

    /**
     * Update collaboration status
     * PUT /api/v1/collaborations/{id}/status
     */
    public function updateStatus(Request $request, Collaboration $collaboration): JsonResponse
    {
        $request->validate([
            'status' => 'required|in:active,completed,suspended,cancelled',
            'reason' => 'nullable|string|max:500',
        ]);

        $currentUser = auth()->user();

        if (!$currentUser->isAdmin() && !$currentUser->isLabManager() &&
            (!$currentUser->researcher || $currentUser->researcher->id !== $collaboration->coordinator_id)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Access denied',
                'code' => 'INSUFFICIENT_PERMISSIONS'
            ], 403);
        }

        $updatedCollaboration = $this->collaborationService->changeCollaborationStatus(
            $collaboration,
            $request->status,
            $request->reason
        );

        return response()->json([
            'status' => 'success',
            'data' => [
                'collaboration' => [
                    'id' => $updatedCollaboration->id,
                    'status' => $updatedCollaboration->status,
                ]
            ],
            'message' => 'Collaboration status updated successfully'
        ]);
    }

    /**
     * Send collaboration invitation
     * POST /api/v1/collaborations/{id}/invitations
     */
    public function sendInvitation(Request $request, Collaboration $collaboration): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
            'message' => 'nullable|string|max:1000',
            'role' => 'nullable|string|max:100',
        ]);

        $currentUser = auth()->user();

        if (!$currentUser->isAdmin() && !$currentUser->isLabManager() &&
            (!$currentUser->researcher || $currentUser->researcher->id !== $collaboration->coordinator_id)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Access denied',
                'code' => 'INSUFFICIENT_PERMISSIONS'
            ], 403);
        }

        $invitationSent = $this->collaborationService->sendCollaborationInvitation(
            $collaboration,
            $request->validated()
        );

        if ($invitationSent) {
            return response()->json([
                'status' => 'success',
                'message' => 'Invitation sent successfully'
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to send invitation',
                'code' => 'INVITATION_SEND_FAILED'
            ], 500);
        }
    }

    /**
     * Generate collaboration agreement template
     * GET /api/v1/collaborations/{id}/agreement
     */
    public function generateAgreement(Collaboration $collaboration): JsonResponse
    {
        $currentUser = auth()->user();

        if (!$currentUser->isAdmin() && !$currentUser->isLabManager() &&
            (!$currentUser->researcher || $currentUser->researcher->id !== $collaboration->coordinator_id)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Access denied',
                'code' => 'INSUFFICIENT_PERMISSIONS'
            ], 403);
        }

        $agreement = $this->collaborationService->generateAgreementTemplate($collaboration);

        return response()->json([
            'status' => 'success',
            'data' => [
                'agreement' => $agreement
            ]
        ]);
    }

    /**
     * Upload collaboration document
     * POST /api/v1/collaborations/{id}/documents
     */
    public function uploadDocument(Request $request, Collaboration $collaboration): JsonResponse
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf,doc,docx|max:10240',
            'document_type' => 'required|string|in:agreement,proposal,report,other',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        $currentUser = auth()->user();

        if (!$currentUser->isAdmin() && !$currentUser->isLabManager() &&
            (!$currentUser->researcher || $currentUser->researcher->id !== $collaboration->coordinator_id)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Access denied',
                'code' => 'INSUFFICIENT_PERMISSIONS'
            ], 403);
        }

        $filePath = $this->collaborationService->uploadCollaborationDocument(
            $collaboration,
            $request->file('file'),
            $request->document_type
        );

        return response()->json([
            'status' => 'success',
            'data' => [
                'document' => [
                    'file_path' => $filePath,
                    'document_type' => $request->document_type,
                    'title' => $request->title,
                    'url' => url("storage/{$filePath}"),
                ]
            ],
            'message' => 'Document uploaded successfully'
        ]);
    }

    /**
     * Get collaboration network analysis
     * GET /api/v1/collaborations/network
     */
    public function networkAnalysis(): JsonResponse
    {
        if (!auth()->user()->isAdmin() && !auth()->user()->isLabManager()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Access denied',
                'code' => 'INSUFFICIENT_PERMISSIONS'
            ], 403);
        }

        $network = $this->collaborationService->getCollaborationNetwork();

        return response()->json([
            'status' => 'success',
            'data' => [
                'network' => $network
            ]
        ]);
    }

    /**
     * Search collaborations
     * GET /api/v1/collaborations/search
     */
    public function search(Request $request): JsonResponse
    {
        $request->validate([
            'query' => 'required|string|min:2',
            'type' => 'nullable|string',
            'status' => 'nullable|string',
            'active_only' => 'nullable|boolean',
        ]);

        $collaborations = $this->collaborationService->searchCollaborations(
            $request->query,
            $request->only(['type', 'status', 'active_only'])
        );

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
                        'coordinator' => $collaboration->coordinator->full_name,
                    ];
                })
            ]
        ]);
    }

    /**
     * Get collaboration types
     * GET /api/v1/collaborations/types
     */
    public function types(): JsonResponse
    {
        $types = $this->collaborationService->getCollaborationTypes();

        return response()->json([
            'status' => 'success',
            'data' => [
                'types' => $types
            ]
        ]);
    }

    /**
     * Get collaboration countries
     * GET /api/v1/collaborations/countries
     */
    public function countries(): JsonResponse
    {
        $countries = $this->collaborationService->getCollaborationCountries();

        return response()->json([
            'status' => 'success',
            'data' => [
                'countries' => $countries
            ]
        ]);
    }

    /**
     * Archive collaboration
     * POST /api/v1/collaborations/{id}/archive
     */
    public function archive(Collaboration $collaboration): JsonResponse
    {
        if (!auth()->user()->isAdmin() && !auth()->user()->isLabManager()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Access denied',
                'code' => 'INSUFFICIENT_PERMISSIONS'
            ], 403);
        }

        try {
            $archived = $this->collaborationService->archiveCollaboration($collaboration);

            if ($archived) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Collaboration archived successfully'
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to archive collaboration',
                    'code' => 'ARCHIVE_FAILED'
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'code' => 'ARCHIVE_VALIDATION_FAILED'
            ], 422);
        }
    }

    /**
     * Get coordinator dashboard
     * GET /api/v1/collaborations/dashboard
     */
    public function coordinatorDashboard(): JsonResponse
    {
        $currentUser = auth()->user();

        if (!$currentUser->researcher) {
            return response()->json([
                'status' => 'error',
                'message' => 'Researcher profile not found',
                'code' => 'RESEARCHER_PROFILE_REQUIRED'
            ], 404);
        }

        $dashboard = $this->collaborationService->getCoordinatorDashboard($currentUser->researcher);

        return response()->json([
            'status' => 'success',
            'data' => $dashboard
        ]);
    }
}