<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExperimentRequest;
use App\Models\Experiment;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ExperimentController extends Controller
{
    public function index(Request $request): View
    {
        $query = Experiment::with(['user', 'project']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('experiment_type', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('project')) {
            $query->where('project_id', $request->project);
        }

        if ($request->filled('my') && $request->my === '1') {
            $query->where('user_id', auth()->id());
        }

        $experiments = $query->latest('experiment_date')->paginate(20);

        return view('experiments.index', compact('experiments'));
    }

    public function create(): View
    {
        $projects = Project::active()->orderBy('title')->get();

        return view('experiments.create', compact('projects'));
    }

    public function store(StoreExperimentRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated['user_id'] = auth()->id();

        Experiment::create($validated);

        return redirect()->route('experiments.index')
            ->with('success', __('Experiment created successfully.'));
    }

    public function show(Experiment $experiment): View
    {
        $experiment->load(['user', 'project', 'files', 'comments.user']);

        return view('experiments.show', compact('experiment'));
    }

    public function edit(Experiment $experiment): View
    {
        $projects = Project::active()->orderBy('title')->get();

        return view('experiments.edit', compact('experiment', 'projects'));
    }

    public function update(StoreExperimentRequest $request, Experiment $experiment): RedirectResponse
    {
        $validated = $request->validated();
        $experiment->update($validated);

        // Handle file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('experiments', 'public');

            $experiment->files()->create([
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $path,
                'file_type' => $file->getMimeType(),
                'file_size' => $file->getSize(),
                'user_id' => auth()->id(),
            ]);
        }

        return redirect()->route('experiments.show', $experiment)
            ->with('success', __('Experiment updated successfully.'));
    }

    public function destroy(Experiment $experiment): RedirectResponse
    {
        $experiment->files()->each(function ($file) {
            if ($file->file_path) {
                Storage::disk('public')->delete($file->file_path);
            }
            $file->delete();
        });

        $experiment->delete();

        return redirect()->route('experiments.index')
            ->with('success', __('Experiment deleted successfully.'));
    }

    public function uploadFile(Request $request, Experiment $experiment): RedirectResponse
    {
        $validated = $request->validate([
            'file' => 'required|file|mimes:jpeg,jpg,png,gif,svg,webp,pdf,doc,docx,odt,txt|max:10240',
            'file_name' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:500',
        ]);

        $file = $request->file('file');

        $experiment->files()->create([
            'file_name' => $validated['file_name'] ?? $file->getClientOriginalName(),
            'file_path' => $file->store('experiments', 'public'),
            'file_size' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
            'description' => $validated['description'] ?? null,
            'uploaded_by' => auth()->id(),
        ]);

        return redirect()->back()->with('success', __('File uploaded successfully.'));
    }

    public function deleteFile(Experiment $experiment, $fileId): RedirectResponse
    {
        $file = $experiment->files()->findOrFail($fileId);

        if ($file->file_path) {
            Storage::disk('public')->delete($file->file_path);
        }

        $file->delete();

        return redirect()->back()->with('success', __('File deleted successfully.'));
    }

    public function addComment(Request $request, Experiment $experiment): RedirectResponse
    {
        $validated = $request->validate([
            'comment' => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:experiment_comments,id',
        ]);

        $experiment->comments()->create([
            'user_id' => auth()->id(),
            'comment' => $validated['comment'],
            'parent_id' => $validated['parent_id'] ?? null,
        ]);

        return redirect()->back()->with('success', __('Comment added successfully.'));
    }

    public function updateStatus(Request $request, Experiment $experiment): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:planned,in_progress,completed,cancelled',
        ]);

        $experiment->update(['status' => $validated['status']]);

        return redirect()->back()->with('success', __('Experiment status updated successfully.'));
    }
}
