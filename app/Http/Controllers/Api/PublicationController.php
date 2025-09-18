<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Publication\StorePublicationRequest;
use App\Http\Requests\Publication\UpdatePublicationRequest;
use App\Models\Publication;
use App\Services\PublicationService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PublicationController extends Controller
{
    public function __construct(
        private PublicationService $publicationService
    ) {}

    /**
     * Display a listing of publications
     * GET /api/v1/publications
     */
    public function index(Request $request): JsonResponse
    {
        $filters = $request->only([
            'search', 'type', 'year', 'researcher_id', 'project_id'
        ]);
        $perPage = min($request->input('per_page', 15), 100);

        $publications = $this->publicationService->getPublications($filters, $perPage);

        return response()->json([
            'status' => 'success',
            'data' => [
                'publications' => $publications->items()->map(function ($publication) {
                    return [
                        'id' => $publication->id,
                        'title' => $publication->title,
                        'type' => $publication->type,
                        'journal' => $publication->journal,
                        'conference' => $publication->conference,
                        'publisher' => $publication->publisher,
                        'publication_year' => $publication->publication_year,
                        'doi' => $publication->doi,
                        'volume' => $publication->volume,
                        'issue' => $publication->issue,
                        'pages' => $publication->pages,
                        'status' => $publication->status,
                        'authors' => $publication->authorResearchers->map(function ($author) {
                            return [
                                'id' => $author->id,
                                'name' => $author->full_name,
                                'order' => $author->pivot->author_order,
                                'is_corresponding' => $author->pivot->is_corresponding_author,
                            ];
                        }),
                        'project' => $publication->project ? [
                            'id' => $publication->project->id,
                            'title' => $publication->project->getTitle(),
                        ] : null,
                        'created_at' => $publication->created_at,
                    ];
                }),
                'pagination' => [
                    'current_page' => $publications->currentPage(),
                    'total_pages' => $publications->lastPage(),
                    'total_items' => $publications->total(),
                    'per_page' => $publications->perPage(),
                    'has_next_page' => $publications->hasMorePages(),
                    'has_previous_page' => $publications->currentPage() > 1,
                ]
            ]
        ]);
    }

    /**
     * Store a newly created publication
     * POST /api/v1/publications
     */
    public function store(StorePublicationRequest $request): JsonResponse
    {
        $publication = $this->publicationService->createPublication($request->validated());

        return response()->json([
            'status' => 'success',
            'data' => [
                'publication' => [
                    'id' => $publication->id,
                    'title' => $publication->title,
                    'type' => $publication->type,
                    'journal' => $publication->journal,
                    'conference' => $publication->conference,
                    'publication_year' => $publication->publication_year,
                    'doi' => $publication->doi,
                    'status' => $publication->status,
                    'authors' => $publication->authorResearchers->map(function ($author) {
                        return [
                            'id' => $author->id,
                            'name' => $author->full_name,
                            'order' => $author->pivot->author_order,
                            'is_corresponding' => $author->pivot->is_corresponding_author,
                        ];
                    }),
                ]
            ],
            'message' => 'Publication created successfully'
        ], 201);
    }

    /**
     * Display the specified publication
     * GET /api/v1/publications/{id}
     */
    public function show(Publication $publication): JsonResponse
    {
        $statistics = $this->publicationService->getPublicationStatistics($publication);

        return response()->json([
            'status' => 'success',
            'data' => [
                'publication' => [
                    'id' => $publication->id,
                    'title' => $publication->title,
                    'authors' => $publication->authors,
                    'type' => $publication->type,
                    'journal' => $publication->journal,
                    'conference' => $publication->conference,
                    'publisher' => $publication->publisher,
                    'publication_year' => $publication->publication_year,
                    'doi' => $publication->doi,
                    'volume' => $publication->volume,
                    'issue' => $publication->issue,
                    'pages' => $publication->pages,
                    'status' => $publication->status,
                    'pdf_url' => $publication->pdf_path ? url("storage/{$publication->pdf_path}") : null,
                    'author_researchers' => $publication->authorResearchers->map(function ($author) {
                        return [
                            'id' => $author->id,
                            'name' => $author->full_name,
                            'email' => $author->user->email,
                            'research_domain' => $author->research_domain,
                            'order' => $author->pivot->author_order,
                            'is_corresponding' => $author->pivot->is_corresponding_author,
                        ];
                    }),
                    'project' => $publication->project ? [
                        'id' => $publication->project->id,
                        'title' => $publication->project->getTitle(),
                        'principal_investigator' => $publication->project->leader->full_name,
                    ] : null,
                    'statistics' => $statistics,
                    'created_at' => $publication->created_at,
                    'updated_at' => $publication->updated_at,
                ]
            ]
        ]);
    }

    /**
     * Update the specified publication
     * PUT /api/v1/publications/{id}
     */
    public function update(UpdatePublicationRequest $request, Publication $publication): JsonResponse
    {
        $updatedPublication = $this->publicationService->updatePublication($publication, $request->validated());

        return response()->json([
            'status' => 'success',
            'data' => [
                'publication' => [
                    'id' => $updatedPublication->id,
                    'title' => $updatedPublication->title,
                    'type' => $updatedPublication->type,
                    'journal' => $updatedPublication->journal,
                    'conference' => $updatedPublication->conference,
                    'publication_year' => $updatedPublication->publication_year,
                    'doi' => $updatedPublication->doi,
                    'status' => $updatedPublication->status,
                ]
            ],
            'message' => 'Publication updated successfully'
        ]);
    }

    /**
     * Remove the specified publication
     * DELETE /api/v1/publications/{id}
     */
    public function destroy(Publication $publication): JsonResponse
    {
        $currentUser = auth()->user();

        // Check if user has permission to delete
        $canDelete = $currentUser->isAdmin() || $currentUser->isLabManager() ||
                    ($currentUser->researcher &&
                     $publication->authorResearchers()->where('researcher_id', $currentUser->researcher->id)->exists());

        if (!$canDelete) {
            return response()->json([
                'status' => 'error',
                'message' => 'Access denied',
                'code' => 'INSUFFICIENT_PERMISSIONS'
            ], 403);
        }

        $this->publicationService->deletePublication($publication);

        return response()->json([
            'status' => 'success',
            'message' => 'Publication deleted successfully'
        ]);
    }

    /**
     * Import publications from BibTeX
     * POST /api/v1/publications/import/bibtex
     */
    public function importBibTeX(Request $request): JsonResponse
    {
        $request->validate([
            'bibtex_content' => 'required|string',
        ]);

        try {
            $publications = $this->publicationService->importFromBibTeX($request->bibtex_content);

            return response()->json([
                'status' => 'success',
                'data' => [
                    'imported_count' => count($publications),
                    'publications' => collect($publications)->map(function ($publication) {
                        return [
                            'id' => $publication->id,
                            'title' => $publication->title,
                            'type' => $publication->type,
                            'publication_year' => $publication->publication_year,
                        ];
                    })
                ],
                'message' => 'Publications imported successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to import BibTeX: ' . $e->getMessage(),
                'code' => 'BIBTEX_IMPORT_FAILED'
            ], 422);
        }
    }

    /**
     * Export publication to BibTeX format
     * GET /api/v1/publications/{id}/bibtex
     */
    public function exportBibTeX(Publication $publication): JsonResponse
    {
        $bibtex = $this->publicationService->generateBibTeX($publication);

        return response()->json([
            'status' => 'success',
            'data' => [
                'bibtex' => $bibtex
            ]
        ]);
    }

    /**
     * Generate citation for publication
     * GET /api/v1/publications/{id}/citation
     */
    public function citation(Request $request, Publication $publication): JsonResponse
    {
        $request->validate([
            'style' => 'nullable|string|in:apa,mla,chicago,ieee',
        ]);

        $style = $request->input('style', 'apa');
        $citation = $this->publicationService->generateCitation($publication, $style);

        return response()->json([
            'status' => 'success',
            'data' => [
                'citation' => $citation,
                'style' => $style
            ]
        ]);
    }

    /**
     * Update publication status
     * PUT /api/v1/publications/{id}/status
     */
    public function updateStatus(Request $request, Publication $publication): JsonResponse
    {
        $request->validate([
            'status' => 'required|in:draft,submitted,published,archived',
        ]);

        $updatedPublication = $this->publicationService->changePublicationStatus(
            $publication,
            $request->status
        );

        return response()->json([
            'status' => 'success',
            'data' => [
                'publication' => [
                    'id' => $updatedPublication->id,
                    'status' => $updatedPublication->status,
                ]
            ],
            'message' => 'Publication status updated successfully'
        ]);
    }

    /**
     * Search publications
     * GET /api/v1/publications/search
     */
    public function search(Request $request): JsonResponse
    {
        $request->validate([
            'query' => 'required|string|min:2',
            'type' => 'nullable|string',
            'year' => 'nullable|integer',
        ]);

        $publications = $this->publicationService->searchPublications(
            $request->query,
            $request->only(['type', 'year'])
        );

        return response()->json([
            'status' => 'success',
            'data' => [
                'publications' => $publications->map(function ($publication) {
                    return [
                        'id' => $publication->id,
                        'title' => $publication->title,
                        'type' => $publication->type,
                        'publication_year' => $publication->publication_year,
                        'doi' => $publication->doi,
                        'authors_count' => $publication->authorResearchers->count(),
                    ];
                })
            ]
        ]);
    }

    /**
     * Get publication metrics
     * GET /api/v1/publications/{id}/metrics
     */
    public function metrics(Publication $publication): JsonResponse
    {
        $metrics = $this->publicationService->getPublicationMetrics($publication);

        return response()->json([
            'status' => 'success',
            'data' => [
                'metrics' => $metrics
            ]
        ]);
    }
}