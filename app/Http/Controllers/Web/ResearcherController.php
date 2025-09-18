<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\ResearcherController as ApiResearcherController;
use App\Http\Requests\Researcher\StoreResearcherRequest;
use App\Http\Requests\Researcher\UpdateResearcherRequest;
use App\Models\Researcher;
use App\Services\ResearcherService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ResearcherController extends Controller
{
    public function __construct(
        private ResearcherService $researcherService,
        private ApiResearcherController $apiController
    ) {
        $this->middleware('auth');
    }

    /**
     * Display a listing of researchers
     */
    public function index(Request $request): View
    {
        $filters = $request->only(['search', 'research_domain', 'status']);
        $perPage = min($request->input('per_page', 15), 100);

        $researchers = $this->researcherService->getResearchers($filters, $perPage);

        return view('researchers.index', compact('researchers', 'filters'));
    }

    /**
     * Show the form for creating a new researcher
     */
    public function create(): View
    {
        $this->authorize('create', Researcher::class);

        return view('researchers.create');
    }

    /**
     * Store a newly created researcher
     */
    public function store(StoreResearcherRequest $request): RedirectResponse
    {
        $this->authorize('create', Researcher::class);

        try {
            $researcher = $this->researcherService->createResearcher($request->validated());

            return redirect()
                ->route('researchers.show', $researcher)
                ->with('success', 'Researcher profile created successfully.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Failed to create researcher profile: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified researcher
     */
    public function show(Researcher $researcher): View
    {
        $this->authorize('view', $researcher);

        $researcher->load(['user', 'leadProjects', 'projects', 'publications', 'coordinatedCollaborations']);
        $statistics = $this->researcherService->getResearcherStatistics($researcher);

        return view('researchers.show', compact('researcher', 'statistics'));
    }

    /**
     * Show the form for editing the specified researcher
     */
    public function edit(Researcher $researcher): View
    {
        $this->authorize('update', $researcher);

        return view('researchers.edit', compact('researcher'));
    }

    /**
     * Update the specified researcher
     */
    public function update(UpdateResearcherRequest $request, Researcher $researcher): RedirectResponse
    {
        $this->authorize('update', $researcher);

        try {
            $updatedResearcher = $this->researcherService->updateResearcher($researcher, $request->validated());

            return redirect()
                ->route('researchers.show', $updatedResearcher)
                ->with('success', 'Researcher profile updated successfully.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Failed to update researcher profile: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified researcher
     */
    public function destroy(Researcher $researcher): RedirectResponse
    {
        $this->authorize('delete', $researcher);

        try {
            $this->researcherService->deleteResearcher($researcher);

            return redirect()
                ->route('researchers.index')
                ->with('success', 'Researcher profile deleted successfully.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Failed to delete researcher profile: ' . $e->getMessage());
        }
    }

    /**
     * Display researcher projects
     */
    public function projects(Researcher $researcher): View
    {
        $this->authorize('view', $researcher);

        $projects = $this->researcherService->getResearcherProjects($researcher);

        return view('researchers.projects', compact('researcher', 'projects'));
    }

    /**
     * Display researcher publications
     */
    public function publications(Researcher $researcher): View
    {
        $this->authorize('view', $researcher);

        $publications = $this->researcherService->getResearcherPublications($researcher);

        return view('researchers.publications', compact('researcher', 'publications'));
    }

    /**
     * Display researcher collaborations
     */
    public function collaborations(Researcher $researcher): View
    {
        $this->authorize('view', $researcher);

        $collaborations = $this->researcherService->getResearcherCollaborations($researcher);

        return view('researchers.collaborations', compact('researcher', 'collaborations'));
    }

    /**
     * Search researchers (AJAX endpoint)
     */
    public function search(Request $request)
    {
        if ($request->expectsJson()) {
            return $this->apiController->search($request);
        }

        // For non-AJAX requests, redirect to index with search parameters
        return redirect()->route('researchers.index', $request->only(['query', 'research_domain']));
    }
}