<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\CollaborationController as ApiCollaborationController;
use App\Http\Requests\Collaboration\StoreCollaborationRequest;
use App\Http\Requests\Collaboration\UpdateCollaborationRequest;
use App\Models\Collaboration;
use App\Services\CollaborationService;
use App\Services\ResearcherService;
use App\Services\ProjectService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class CollaborationController extends Controller
{
    public function __construct(
        private CollaborationService $collaborationService,
        private ResearcherService $researcherService,
        private ProjectService $projectService,
        private ApiCollaborationController $apiController
    ) {
       
    }

    /**
     * Display a listing of collaborations
     */
    public function index(Request $request): View
    {
        $filters = $request->only([
            'search', 'type', 'status', 'coordinator_id', 'country',
            'start_date_from', 'start_date_to'
        ]);
        $perPage = min($request->input('per_page', 15), 100);

        $collaborations = $this->collaborationService->getCollaborations($filters, $perPage);
        $researchers = $this->researcherService->getResearchers([], 1000);

        return view('collaborations.index', compact('collaborations', 'filters', 'researchers'));
    }

    /**
     * Show the form for creating a new collaboration
     */
    public function create(): View
    {
        $this->authorize('create', Collaboration::class);

        $researchers = $this->researcherService->getResearchers([], 1000);
        $projects = $this->projectService->getProjects([], 1000);

        return view('collaborations.create', compact('researchers', 'projects'));
    }

    /**
     * Store a newly created collaboration
     */
    public function store(StoreCollaborationRequest $request): RedirectResponse
    {
        $this->authorize('create', Collaboration::class);

        try {
            $collaboration = $this->collaborationService->createCollaboration($request->validated());

            return redirect()
                ->route('collaborations.show', $collaboration)
                ->with('success', 'Collaboration created successfully.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Failed to create collaboration: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified collaboration
     */
    public function show(Collaboration $collaboration): View
    {
        $this->authorize('view', $collaboration);

        $collaboration->load(['coordinator', 'participants', 'projects', 'publications']);
        $statistics = $this->collaborationService->getCollaborationStatistics($collaboration);

        return view('collaborations.show', compact('collaboration', 'statistics'));
    }

    /**
     * Show the form for editing the specified collaboration
     */
    public function edit(Collaboration $collaboration): View
    {
        $this->authorize('update', $collaboration);

        $researchers = $this->researcherService->getResearchers([], 1000);
        $projects = $this->projectService->getProjects([], 1000);

        return view('collaborations.edit', compact('collaboration', 'researchers', 'projects'));
    }

    /**
     * Update the specified collaboration
     */
    public function update(UpdateCollaborationRequest $request, Collaboration $collaboration): RedirectResponse
    {
        $this->authorize('update', $collaboration);

        try {
            $updatedCollaboration = $this->collaborationService->updateCollaboration($collaboration, $request->validated());

            return redirect()
                ->route('collaborations.show', $updatedCollaboration)
                ->with('success', 'Collaboration updated successfully.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Failed to update collaboration: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified collaboration
     */
    public function destroy(Collaboration $collaboration): RedirectResponse
    {
        $this->authorize('delete', $collaboration);

        try {
            $this->collaborationService->deleteCollaboration($collaboration);

            return redirect()
                ->route('collaborations.index')
                ->with('success', 'Collaboration deleted successfully.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Failed to delete collaboration: ' . $e->getMessage());
        }
    }

    /**
     * Display collaboration participants
     */
    public function participants(Collaboration $collaboration): View
    {
        $this->authorize('view', $collaboration);

        $participants = $this->collaborationService->getCollaborationParticipants($collaboration);
        $availableResearchers = $this->researcherService->getResearchers([], 1000);

        return view('collaborations.participants', compact('collaboration', 'participants', 'availableResearchers'));
    }

    /**
     * Add participant to collaboration
     */
    public function addParticipant(Request $request, Collaboration $collaboration): RedirectResponse
    {
        $this->authorize('update', $collaboration);

        $request->validate([
            'researcher_id' => 'required|exists:researchers,id',
            'role' => 'required|string|max:100',
            'institution' => 'nullable|string|max:255',
        ]);

        try {
            $this->collaborationService->addParticipant($collaboration, $request->validated());

            return redirect()
                ->route('collaborations.participants', $collaboration)
                ->with('success', 'Participant added successfully.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Failed to add participant: ' . $e->getMessage());
        }
    }

    /**
     * Remove participant from collaboration
     */
    public function removeParticipant(Collaboration $collaboration, $participantId): RedirectResponse
    {
        $this->authorize('update', $collaboration);

        try {
            $this->collaborationService->removeParticipant($collaboration, $participantId);

            return redirect()
                ->route('collaborations.participants', $collaboration)
                ->with('success', 'Participant removed successfully.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Failed to remove participant: ' . $e->getMessage());
        }
    }

    /**
     * Display collaboration projects
     */
    public function projects(Collaboration $collaboration): View
    {
        $this->authorize('view', $collaboration);

        $projects = $this->collaborationService->getCollaborationProjects($collaboration);
        $availableProjects = $this->projectService->getProjects([], 1000);

        return view('collaborations.projects', compact('collaboration', 'projects', 'availableProjects'));
    }

    /**
     * Display collaboration publications
     */
    public function publications(Collaboration $collaboration): View
    {
        $this->authorize('view', $collaboration);

        $publications = $this->collaborationService->getCollaborationPublications($collaboration);

        return view('collaborations.publications', compact('collaboration', 'publications'));
    }

    /**
     * Display collaboration timeline
     */
    public function timeline(Collaboration $collaboration): View
    {
        $this->authorize('view', $collaboration);

        $timeline = $this->collaborationService->getCollaborationTimeline($collaboration);

        return view('collaborations.timeline', compact('collaboration', 'timeline'));
    }

    /**
     * Display collaboration agreements
     */
    public function agreements(Collaboration $collaboration): View
    {
        $this->authorize('view', $collaboration);

        $agreements = $this->collaborationService->getCollaborationAgreements($collaboration);

        return view('collaborations.agreements', compact('collaboration', 'agreements'));
    }

    /**
     * Display collaboration reports
     */
    public function reports(Collaboration $collaboration): View
    {
        $this->authorize('view', $collaboration);

        $reports = $this->collaborationService->getCollaborationReports($collaboration);

        return view('collaborations.reports', compact('collaboration', 'reports'));
    }

    /**
     * Search collaborations (AJAX endpoint)
     */
    public function search(Request $request)
    {
        if ($request->expectsJson()) {
            return $this->apiController->search($request);
        }

        // For non-AJAX requests, redirect to index with search parameters
        return redirect()->route('collaborations.index', $request->only([
            'query', 'type', 'status', 'coordinator_id', 'country'
        ]));
    }

    /**
     * Export collaboration data
     */
    public function export(Request $request)
    {
        $filters = $request->only([
            'search', 'type', 'status', 'coordinator_id', 'country',
            'start_date_from', 'start_date_to'
        ]);

        $format = $request->input('format', 'csv');

        try {
            return $this->collaborationService->exportCollaborations($filters, $format);
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to export collaborations: ' . $e->getMessage());
        }
    }

    /**
     * Display collaboration map
     */
    public function map(Request $request): View
    {
        $filters = $request->only(['type', 'status']);
        $collaborations = $this->collaborationService->getCollaborationsForMap($filters);

        return view('collaborations.map', compact('collaborations', 'filters'));
    }
}