<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
use App\Services\CacheService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function __construct(
        private CacheService $cacheService
    ) {}

    public function index(Request $request): View
    {
        $query = Project::with(['creator', 'users']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $projects = $query->latest()->paginate(20);

        return view('projects.index', compact('projects'));
    }

    public function create(): View
    {
        return view('projects.create');
    }

    public function store(StoreProjectRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated['created_by'] = auth()->id();

        Project::create($validated);
        $this->cacheService->clearProjectCaches();

        return redirect()->route('projects.index')
            ->with('success', __('Project created successfully.'));
    }

    public function show(Project $project): View
    {
        $project->load(['creator', 'users', 'experiments']);

        return view('projects.show', compact('project'));
    }

    public function edit(Project $project): View
    {
        return view('projects.edit', compact('project'));
    }

    public function update(UpdateProjectRequest $request, Project $project): RedirectResponse
    {
        $project->update($request->validated());
        $this->cacheService->clearProjectCaches();

        return redirect()->route('projects.show', $project)
            ->with('success', __('Project updated successfully.'));
    }

    public function destroy(Project $project): RedirectResponse
    {
        $project->delete();
        $this->cacheService->clearProjectCaches();

        return redirect()->route('projects.index')
            ->with('success', __('Project deleted successfully.'));
    }

    public function members(Project $project): View
    {
        $project->load('users');

        return view('projects.members', compact('project'));
    }
}
