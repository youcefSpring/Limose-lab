<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\PublicationController as ApiPublicationController;
use App\Http\Requests\Publication\StorePublicationRequest;
use App\Http\Requests\Publication\UpdatePublicationRequest;
use App\Models\Publication;
use App\Services\PublicationService;
use App\Services\ResearcherService;
use App\Services\ProjectService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class PublicationController extends Controller
{
    public function __construct(
        private PublicationService $publicationService,
        private ResearcherService $researcherService,
        private ProjectService $projectService,
        private ApiPublicationController $apiController
    ) {
        $this->middleware('auth');
    }

    /**
     * Display a listing of publications
     */
    public function index(Request $request): View
    {
        $filters = $request->only([
            'search', 'type', 'status', 'researcher_id', 'project_id',
            'publication_year', 'journal', 'conference'
        ]);
        $perPage = min($request->input('per_page', 15), 100);

        $publications = $this->publicationService->getPublications($filters, $perPage);
        $researchers = $this->researcherService->getResearchers([], 1000);
        $projects = $this->projectService->getProjects([], 1000);

        return view('publications.index', compact('publications', 'filters', 'researchers', 'projects'));
    }

    /**
     * Show the form for creating a new publication
     */
    public function create(): View
    {
        $this->authorize('create', Publication::class);

        $researchers = $this->researcherService->getResearchers([], 1000);
        $projects = $this->projectService->getProjects([], 1000);

        return view('publications.create', compact('researchers', 'projects'));
    }

    /**
     * Store a newly created publication
     */
    public function store(StorePublicationRequest $request): RedirectResponse
    {
        $this->authorize('create', Publication::class);

        try {
            $publication = $this->publicationService->createPublication($request->validated());

            return redirect()
                ->route('publications.show', $publication)
                ->with('success', 'Publication created successfully.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Failed to create publication: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified publication
     */
    public function show(Publication $publication): View
    {
        $this->authorize('view', $publication);

        $publication->load(['authorResearchers', 'projects', 'files']);
        $statistics = $this->publicationService->getPublicationStatistics($publication);

        return view('publications.show', compact('publication', 'statistics'));
    }

    /**
     * Show the form for editing the specified publication
     */
    public function edit(Publication $publication): View
    {
        $this->authorize('update', $publication);

        $researchers = $this->researcherService->getResearchers([], 1000);
        $projects = $this->projectService->getProjects([], 1000);

        return view('publications.edit', compact('publication', 'researchers', 'projects'));
    }

    /**
     * Update the specified publication
     */
    public function update(UpdatePublicationRequest $request, Publication $publication): RedirectResponse
    {
        $this->authorize('update', $publication);

        try {
            $updatedPublication = $this->publicationService->updatePublication($publication, $request->validated());

            return redirect()
                ->route('publications.show', $updatedPublication)
                ->with('success', 'Publication updated successfully.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Failed to update publication: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified publication
     */
    public function destroy(Publication $publication): RedirectResponse
    {
        $this->authorize('delete', $publication);

        try {
            $this->publicationService->deletePublication($publication);

            return redirect()
                ->route('publications.index')
                ->with('success', 'Publication deleted successfully.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Failed to delete publication: ' . $e->getMessage());
        }
    }

    /**
     * Display publication authors
     */
    public function authors(Publication $publication): View
    {
        $this->authorize('view', $publication);

        $authors = $this->publicationService->getPublicationAuthors($publication);
        $availableResearchers = $this->researcherService->getResearchers([], 1000);

        return view('publications.authors', compact('publication', 'authors', 'availableResearchers'));
    }

    /**
     * Display publication files
     */
    public function files(Publication $publication): View
    {
        $this->authorize('view', $publication);

        $files = $this->publicationService->getPublicationFiles($publication);

        return view('publications.files', compact('publication', 'files'));
    }

    /**
     * Display publication metrics
     */
    public function metrics(Publication $publication): View
    {
        $this->authorize('view', $publication);

        $metrics = $this->publicationService->getPublicationMetrics($publication);

        return view('publications.metrics', compact('publication', 'metrics'));
    }

    /**
     * Display publication citations
     */
    public function citations(Publication $publication): View
    {
        $this->authorize('view', $publication);

        $citations = $this->publicationService->getPublicationCitations($publication);

        return view('publications.citations', compact('publication', 'citations'));
    }

    /**
     * Search publications (AJAX endpoint)
     */
    public function search(Request $request)
    {
        if ($request->expectsJson()) {
            return $this->apiController->search($request);
        }

        // For non-AJAX requests, redirect to index with search parameters
        return redirect()->route('publications.index', $request->only([
            'query', 'type', 'status', 'researcher_id', 'project_id', 'publication_year'
        ]));
    }

    /**
     * Export publications
     */
    public function export(Request $request)
    {
        $filters = $request->only([
            'search', 'type', 'status', 'researcher_id', 'project_id',
            'publication_year', 'journal', 'conference'
        ]);

        $format = $request->input('format', 'csv');

        try {
            return $this->publicationService->exportPublications($filters, $format);
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to export publications: ' . $e->getMessage());
        }
    }
}