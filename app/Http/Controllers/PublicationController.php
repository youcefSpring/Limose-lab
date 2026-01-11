<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;

class PublicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Publication::with('user');

        // Filter by user's own publications if not admin
        if (!auth()->user()->hasRole('admin')) {
            $query->where('user_id', auth()->id());
        } else {
            // Admin can filter by user
            if ($request->has('user_id')) {
                $query->where('user_id', $request->user_id);
            }
        }

        // Filter by type
        if ($request->has('type') && $request->type) {
            $query->ofType($request->type);
        }

        // Filter by year
        if ($request->has('year') && $request->year) {
            $query->byYear($request->year);
        }

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Filter by visibility (admin only)
        if (auth()->user()->hasRole('admin') && $request->has('visibility')) {
            $query->where('visibility', $request->visibility);
        }

        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('authors', 'like', "%{$search}%")
                  ->orWhere('abstract', 'like', "%{$search}%");
            });
        }

        $publications = $query->latest()->paginate(20);

        return view('publications.index', compact('publications'));
    }

    /**
     * Display public publications (frontend)
     */
    public function publicIndex(Request $request)
    {
        $query = Publication::with('user')
            ->public()
            ->published();

        // Filter by type
        if ($request->has('type') && $request->type) {
            $query->ofType($request->type);
        }

        // Filter by year
        if ($request->has('year') && $request->year) {
            $query->byYear($request->year);
        }

        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('authors', 'like', "%{$search}%")
                  ->orWhere('abstract', 'like', "%{$search}%");
            });
        }

        $publications = $query->latest('publication_date')->paginate(20);
        $featured = Publication::public()->published()->featured()->limit(3)->get();

        return view('frontend.publications', compact('publications', 'featured'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Publication::class);

        return view('publications.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', Publication::class);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'title_fr' => 'nullable|string|max:255',
            'title_ar' => 'nullable|string|max:255',
            'abstract' => 'nullable|string',
            'abstract_fr' => 'nullable|string',
            'abstract_ar' => 'nullable|string',
            'authors' => 'required|string',
            'journal' => 'nullable|string|max:255',
            'conference' => 'nullable|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 5),
            'volume' => 'nullable|string|max:50',
            'issue' => 'nullable|string|max:50',
            'pages' => 'nullable|string|max:50',
            'doi' => 'nullable|string|max:255',
            'isbn' => 'nullable|string|max:50',
            'url' => 'nullable|url|max:255',
            'pdf_file' => 'nullable|file|mimes:pdf,doc,docx,odt|max:10240',
            'type' => 'required|in:journal,conference,book,chapter,thesis,preprint,other',
            'status' => 'required|in:published,in_press,submitted,draft',
            'publication_date' => 'nullable|date',
            'keywords' => 'nullable|string',
            'research_areas' => 'nullable|string',
            'is_open_access' => 'boolean',
            'citations_count' => 'nullable|integer|min:0',
        ]);

        // Handle PDF upload
        if ($request->hasFile('pdf_file')) {
            $validated['pdf_file'] = $request->file('pdf_file')->store('publications', 'public');
        }

        // Set user_id
        $validated['user_id'] = auth()->id();

        // Set visibility based on role
        if (auth()->user()->hasRole('admin')) {
            $validated['visibility'] = 'public';
        } else {
            $validated['visibility'] = 'pending';
        }

        // Set defaults
        $validated['is_featured'] = false;
        $validated['is_open_access'] = $request->has('is_open_access');

        $publication = Publication::create($validated);

        return redirect()->route('publications.index')
            ->with('success', __('Publication created successfully!'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Publication $publication)
    {
        Gate::authorize('view', $publication);

        $publication->load('user');

        return view('publications.show', compact('publication'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Publication $publication)
    {
        Gate::authorize('update', $publication);

        return view('publications.edit', compact('publication'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Publication $publication)
    {
        Gate::authorize('update', $publication);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'title_fr' => 'nullable|string|max:255',
            'title_ar' => 'nullable|string|max:255',
            'abstract' => 'nullable|string',
            'abstract_fr' => 'nullable|string',
            'abstract_ar' => 'nullable|string',
            'authors' => 'required|string',
            'journal' => 'nullable|string|max:255',
            'conference' => 'nullable|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 5),
            'volume' => 'nullable|string|max:50',
            'issue' => 'nullable|string|max:50',
            'pages' => 'nullable|string|max:50',
            'doi' => 'nullable|string|max:255',
            'isbn' => 'nullable|string|max:50',
            'url' => 'nullable|url|max:255',
            'pdf_file' => 'nullable|file|mimes:pdf,doc,docx,odt|max:10240',
            'type' => 'required|in:journal,conference,book,chapter,thesis,preprint,other',
            'status' => 'required|in:published,in_press,submitted,draft',
            'publication_date' => 'nullable|date',
            'keywords' => 'nullable|string',
            'research_areas' => 'nullable|string',
            'is_open_access' => 'boolean',
            'citations_count' => 'nullable|integer|min:0',
            'visibility' => 'nullable|in:public,private,pending',
            'is_featured' => 'boolean',
        ]);

        // Handle PDF upload
        if ($request->hasFile('pdf_file')) {
            // Delete old PDF if exists
            if ($publication->pdf_file && Storage::disk('public')->exists($publication->pdf_file)) {
                Storage::disk('public')->delete($publication->pdf_file);
            }

            $validated['pdf_file'] = $request->file('pdf_file')->store('publications', 'public');
        }

        // Admin can change visibility and featured status
        if (auth()->user()->hasRole('admin')) {
            $validated['visibility'] = $request->input('visibility', $publication->visibility);
            $validated['is_featured'] = $request->has('is_featured');
        }

        $validated['is_open_access'] = $request->has('is_open_access');

        $publication->update($validated);

        return redirect()->route('publications.index')
            ->with('success', __('Publication updated successfully!'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Publication $publication)
    {
        Gate::authorize('delete', $publication);

        // Delete PDF file if exists
        if ($publication->pdf_file && Storage::disk('public')->exists($publication->pdf_file)) {
            Storage::disk('public')->delete($publication->pdf_file);
        }

        $publication->delete();

        return redirect()->route('publications.index')
            ->with('success', __('Publication deleted successfully!'));
    }

    /**
     * Approve publication (admin only)
     */
    public function approve(Publication $publication)
    {
        Gate::authorize('approve', $publication);

        $publication->update(['visibility' => 'public']);

        return redirect()->back()
            ->with('success', __('Publication approved successfully!'));
    }

    /**
     * Reject publication (admin only)
     */
    public function reject(Publication $publication)
    {
        Gate::authorize('approve', $publication);

        $publication->update(['visibility' => 'private']);

        return redirect()->back()
            ->with('success', __('Publication rejected!'));
    }
}
