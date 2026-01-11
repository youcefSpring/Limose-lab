<?php

namespace App\Http\Controllers;

use App\Models\Experiment;
use App\Models\Project;
use Illuminate\Http\Request;

class ExperimentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Experiment::with(['user', 'project']);

        // Search functionality
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('experiment_type', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Filter by project
        if ($request->has('project') && $request->project !== '') {
            $query->where('project_id', $request->project);
        }

        // Filter by user's experiments
        if ($request->has('my') && $request->my === '1') {
            $query->where('user_id', auth()->id());
        }

        $experiments = $query->latest('experiment_date')->paginate(20);

        return view('experiments.index', compact('experiments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $projects = Project::where('status', 'active')
            ->orderBy('title')
            ->get();

        return view('experiments.create', compact('projects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'nullable|exists:projects,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'experiment_type' => 'required|string|max:255',
            'experiment_date' => 'required|date',
            'hypothesis' => 'nullable|string',
            'procedure' => 'nullable|string',
            'results' => 'nullable|string',
            'conclusions' => 'nullable|string',
            'status' => 'required|in:planned,in_progress,completed,cancelled',
            'duration' => 'nullable|numeric|min:0',
        ]);

        $validated['user_id'] = auth()->id();

        Experiment::create($validated);

        return redirect()->route('experiments.index')->with('success', __('Experiment created successfully.'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Experiment $experiment)
    {
        $experiment->load(['user', 'project', 'files', 'comments.user']);
        return view('experiments.show', compact('experiment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Experiment $experiment)
    {
        $projects = Project::where('status', 'active')
            ->orderBy('title')
            ->get();

        return view('experiments.edit', compact('experiment', 'projects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Experiment $experiment)
    {
        $validated = $request->validate([
            'project_id' => 'nullable|exists:projects,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'experiment_type' => 'required|string|max:255',
            'experiment_date' => 'required|date',
            'hypothesis' => 'nullable|string',
            'procedure' => 'nullable|string',
            'results' => 'nullable|string',
            'conclusions' => 'nullable|string',
            'status' => 'required|in:planned,in_progress,completed,cancelled',
            'duration' => 'nullable|numeric|min:0',
        ]);

        $experiment->update($validated);

        return redirect()->route('experiments.show', $experiment)->with('success', __('Experiment updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Experiment $experiment)
    {
        // Delete associated files
        foreach ($experiment->files as $file) {
            if ($file->file_path) {
                \Storage::disk('public')->delete($file->file_path);
            }
            $file->delete();
        }

        $experiment->delete();

        return redirect()->route('experiments.index')->with('success', __('Experiment deleted successfully.'));
    }

    /**
     * Upload file for an experiment.
     */
    public function uploadFile(Request $request, Experiment $experiment)
    {
        $validated = $request->validate([
            'file' => 'required|file|mimes:jpeg,jpg,png,gif,svg,webp,pdf,doc,docx,odt,txt|max:10240',
            'file_name' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:500',
        ]);

        $filePath = $request->file('file')->store('experiments', 'public');
        $originalName = $request->file('file')->getClientOriginalName();
        $fileSize = $request->file('file')->getSize();
        $mimeType = $request->file('file')->getMimeType();

        $experiment->files()->create([
            'file_name' => $validated['file_name'] ?? $originalName,
            'file_path' => $filePath,
            'file_size' => $fileSize,
            'mime_type' => $mimeType,
            'description' => $validated['description'] ?? null,
            'uploaded_by' => auth()->id(),
        ]);

        return redirect()->back()->with('success', __('File uploaded successfully.'));
    }

    /**
     * Delete a file from an experiment.
     */
    public function deleteFile(Experiment $experiment, $fileId)
    {
        $file = $experiment->files()->findOrFail($fileId);

        if ($file->file_path) {
            \Storage::disk('public')->delete($file->file_path);
        }

        $file->delete();

        return redirect()->back()->with('success', __('File deleted successfully.'));
    }

    /**
     * Add a comment to an experiment.
     */
    public function addComment(Request $request, Experiment $experiment)
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

    /**
     * Update experiment status.
     */
    public function updateStatus(Request $request, Experiment $experiment)
    {
        $validated = $request->validate([
            'status' => 'required|in:planned,in_progress,completed,cancelled',
        ]);

        $experiment->update(['status' => $validated['status']]);

        return redirect()->back()->with('success', __('Experiment status updated successfully.'));
    }
}
