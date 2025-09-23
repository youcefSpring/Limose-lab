<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\ProjectController as ApiProjectController;
use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Models\Project;
use App\Services\ProjectService;
use App\Services\ResearcherService;
use App\Services\FundingService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ProjectController extends Controller
{
    public function __construct(
        private ProjectService $projectService,
        private ResearcherService $researcherService,
        private FundingService $fundingService,
        private ApiProjectController $apiController
    ) {
        $this->middleware('auth');
    }

    /**
     * Display a listing of projects
     */
    public function index(Request $request): View
    {
        $this->authorize('viewAny', Project::class);

        $filters = $request->only([
            'search', 'status', 'researcher_id', 'funding_id',
            'start_date_from', 'start_date_to'
        ]);
        $perPage = min($request->input('per_page', 15), 100);

        $projects = $this->projectService->getProjects($filters, $perPage);
        $researchers = $this->researcherService->getResearchers([], 1000);
        $fundingSources = $this->fundingService->getFunding([], 1000);

        return view('projects.index', compact('projects', 'filters', 'researchers', 'fundingSources'));
    }

    /**
     * Show the form for creating a new project
     */
    public function create(): View
    {
        $this->authorize('create', Project::class);

        $researchers = $this->researcherService->getResearchers([], 1000);
        $fundingSources = $this->fundingService->getFunding([], 1000);

        return view('projects.create', compact('researchers', 'fundingSources'));
    }

    /**
     * Store a newly created project
     */
    public function store(StoreProjectRequest $request): RedirectResponse
    {
        $this->authorize('create', Project::class);

        try {
            $project = $this->projectService->createProject($request->validated());

            return redirect()
                ->route('projects.show', $project)
                ->with('success', 'Project created successfully.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Failed to create project: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified project
     */
    public function show(Project $project): View
    {
        $this->authorize('view', $project);

        $project->load(['leader', 'members', 'publications', 'funding', 'collaborations']);
        $statistics = $this->projectService->getProjectStatistics($project);

        return view('projects.show', compact('project', 'statistics'));
    }

    /**
     * Show the form for editing the specified project
     */
    public function edit(Project $project): View
    {
        $this->authorize('update', $project);

        $researchers = $this->researcherService->getResearchers([], 1000);
        $fundingSources = $this->fundingService->getFunding([], 1000);

        return view('projects.edit', compact('project', 'researchers', 'fundingSources'));
    }

    /**
     * Update the specified project
     */
    public function update(UpdateProjectRequest $request, Project $project): RedirectResponse
    {
        $this->authorize('update', $project);

        try {
            $updatedProject = $this->projectService->updateProject($project, $request->validated());

            return redirect()
                ->route('projects.show', $updatedProject)
                ->with('success', 'Project updated successfully.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Failed to update project: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified project
     */
    public function destroy(Project $project): RedirectResponse
    {
        $this->authorize('delete', $project);

        try {
            $this->projectService->deleteProject($project);

            return redirect()
                ->route('projects.index')
                ->with('success', 'Project deleted successfully.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Failed to delete project: ' . $e->getMessage());
        }
    }

    /**
     * Display project members
     */
    public function members(Project $project): View
    {
        $this->authorize('view', $project);

        $members = $this->projectService->getProjectMembers($project);
        $availableResearchers = $this->researcherService->getResearchers([], 1000);

        return view('projects.members', compact('project', 'members', 'availableResearchers'));
    }

    /**
     * Display project publications
     */
    public function publications(Project $project): View
    {
        $this->authorize('view', $project);

        $publications = $this->projectService->getProjectPublications($project);

        return view('projects.publications', compact('project', 'publications'));
    }

    /**
     * Display project timeline
     */
    public function timeline(Project $project): View
    {
        $this->authorize('view', $project);

        $timeline = $this->projectService->getProjectTimeline($project);

        return view('projects.timeline', compact('project', 'timeline'));
    }

    /**
     * Display project reports
     */
    public function reports(Project $project): View
    {
        $this->authorize('view', $project);

        $reports = $this->projectService->getProjectReports($project);

        return view('projects.reports', compact('project', 'reports'));
    }

    /**
     * Search projects (AJAX endpoint)
     */
    public function search(Request $request)
    {
        if ($request->expectsJson()) {
            return $this->apiController->search($request);
        }

        // For non-AJAX requests, redirect to index with search parameters
        return redirect()->route('projects.index', $request->only([
            'query', 'status', 'researcher_id', 'funding_id'
        ]));
    }
}