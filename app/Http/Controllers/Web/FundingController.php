<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\FundingController as ApiFundingController;
use App\Http\Requests\Funding\StoreFundingRequest;
use App\Http\Requests\Funding\UpdateFundingRequest;
use App\Models\ProjectFunding;
use App\Services\FundingService;
use App\Services\ResearcherService;
use App\Services\ProjectService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class FundingController extends Controller
{
    public function __construct(
        private FundingService $fundingService,
        private ResearcherService $researcherService,
        private ProjectService $projectService,
        private ApiFundingController $apiController
    ) {
        $this->middleware('auth');
    }

    /**
     * Display a listing of funding
     */
    public function index(Request $request): View
    {
        $filters = $request->only([
            'search', 'type', 'status', 'source', 'researcher_id',
            'amount_from', 'amount_to', 'start_date_from', 'start_date_to'
        ]);
        $perPage = min($request->input('per_page', 15), 100);

        $funding = $this->fundingService->getFunding($filters, $perPage);
        $researchers = $this->researcherService->getResearchers([], 1000);

        return view('funding.index', compact('funding', 'filters', 'researchers'));
    }

    /**
     * Show the form for creating new funding
     */
    public function create(): View
    {
        $this->authorize('create', ProjectFunding::class);

        $researchers = $this->researcherService->getResearchers([], 1000);
        $projects = $this->projectService->getProjects([], 1000);

        return view('funding.create', compact('researchers', 'projects'));
    }

    /**
     * Store newly created funding
     */
    public function store(StoreFundingRequest $request): RedirectResponse
    {
        $this->authorize('create', ProjectFunding::class);

        try {
            $funding = $this->fundingService->createFunding($request->validated());

            return redirect()
                ->route('funding.show', $funding)
                ->with('success', 'Funding created successfully.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Failed to create funding: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified funding
     */
    public function show(ProjectFunding $funding): View
    {
        $this->authorize('view', $funding);

        $funding->load(['project', 'fundingSource']);
        $statistics = $this->fundingService->getProjectFundingSummary($funding->project);

        return view('funding.show', compact('funding', 'statistics'));
    }

    /**
     * Show the form for editing the specified funding
     */
    public function edit(ProjectFunding $funding): View
    {
        $this->authorize('update', $funding);

        $researchers = $this->researcherService->getResearchers([], 1000);
        $projects = $this->projectService->getProjects([], 1000);

        return view('funding.edit', compact('funding', 'researchers', 'projects'));
    }

    /**
     * Update the specified funding
     */
    public function update(UpdateFundingRequest $request, ProjectFunding $funding): RedirectResponse
    {
        $this->authorize('update', $funding);

        try {
            $updatedFunding = $this->fundingService->updateProjectFunding($funding, $request->validated());

            return redirect()
                ->route('funding.show', $updatedFunding)
                ->with('success', 'Funding updated successfully.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Failed to update funding: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified funding
     */
    public function destroy(ProjectFunding $funding): RedirectResponse
    {
        $this->authorize('delete', $funding);

        try {
            $this->fundingService->deleteProjectFunding($funding);

            return redirect()
                ->route('funding.index')
                ->with('success', 'Funding deleted successfully.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Failed to delete funding: ' . $e->getMessage());
        }
    }

    /**
     * Display funding budget breakdown
     */
    public function budget(Funding $funding): View
    {
        $this->authorize('view', $funding);

        $budgetItems = $this->fundingService->getFundingBudget($funding);
        $budgetSummary = $this->fundingService->getBudgetSummary($funding);

        return view('funding.budget', compact('funding', 'budgetItems', 'budgetSummary'));
    }

    /**
     * Display funding reports
     */
    public function reports(Funding $funding): View
    {
        $this->authorize('view', $funding);

        $reports = $this->fundingService->getFundingReports($funding);

        return view('funding.reports', compact('funding', 'reports'));
    }

    /**
     * Show form for creating funding report
     */
    public function createReport(Funding $funding): View
    {
        $this->authorize('update', $funding);

        return view('funding.create-report', compact('funding'));
    }

    /**
     * Store funding report
     */
    public function storeReport(Request $request, Funding $funding): RedirectResponse
    {
        $this->authorize('update', $funding);

        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:progress,financial,final',
            'period_start' => 'required|date',
            'period_end' => 'required|date|after:period_start',
            'content' => 'required|string',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|max:10240',
        ]);

        try {
            $this->fundingService->createFundingReport($funding, $request->validated());

            return redirect()
                ->route('funding.reports', $funding)
                ->with('success', 'Funding report created successfully.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Failed to create funding report: ' . $e->getMessage());
        }
    }

    /**
     * Display funding expenditures
     */
    public function expenditures(Funding $funding): View
    {
        $this->authorize('view', $funding);

        $expenditures = $this->fundingService->getFundingExpenditures($funding);
        $expenditureSummary = $this->fundingService->getExpenditureSummary($funding);

        return view('funding.expenditures', compact('funding', 'expenditures', 'expenditureSummary'));
    }

    /**
     * Display funding timeline
     */
    public function timeline(Funding $funding): View
    {
        $this->authorize('view', $funding);

        $timeline = $this->fundingService->getFundingTimeline($funding);

        return view('funding.timeline', compact('funding', 'timeline'));
    }

    /**
     * Display funding opportunities
     */
    public function opportunities(Request $request): View
    {
        $filters = $request->only(['type', 'deadline_from', 'deadline_to', 'amount_from', 'amount_to']);
        $opportunities = $this->fundingService->getFundingOpportunities($filters);

        return view('funding.opportunities', compact('opportunities', 'filters'));
    }

    /**
     * Display funding analytics
     */
    public function analytics(Request $request): View
    {
        $this->authorize('viewAnalytics', ProjectFunding::class);

        $filters = $request->only(['year', 'type', 'source']);
        $analytics = $this->fundingService->getFundingAnalytics($filters);

        return view('funding.analytics', compact('analytics', 'filters'));
    }

    /**
     * Search funding (AJAX endpoint)
     */
    public function search(Request $request)
    {
        if ($request->expectsJson()) {
            return $this->apiController->search($request);
        }

        // For non-AJAX requests, redirect to index with search parameters
        return redirect()->route('funding.index', $request->only([
            'query', 'type', 'status', 'source', 'researcher_id'
        ]));
    }

    /**
     * Export funding data
     */
    public function export(Request $request)
    {
        $filters = $request->only([
            'search', 'type', 'status', 'source', 'researcher_id',
            'amount_from', 'amount_to', 'start_date_from', 'start_date_to'
        ]);

        $format = $request->input('format', 'csv');

        try {
            return $this->fundingService->exportFunding($filters, $format);
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to export funding data: ' . $e->getMessage());
        }
    }

    /**
     * Display funding dashboard for researchers
     */
    public function dashboard(): View
    {
        $user = auth()->user();

        if (!$user->researcher) {
            return redirect()->route('dashboard.index')
                ->with('error', 'You need to complete your researcher profile first.');
        }

        $dashboard = $this->fundingService->getResearcherFundingDashboard($user->researcher);

        return view('funding.dashboard', compact('dashboard'));
    }
}