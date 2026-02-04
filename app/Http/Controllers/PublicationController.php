<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePublicationRequest;
use App\Http\Requests\UpdatePublicationRequest;
use App\Mail\PublicationStatusChanged;
use App\Models\Publication;
use App\Models\Setting;
use App\Services\CacheService;
use App\Services\FileUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PublicationController extends Controller
{
    public function __construct(
        private FileUploadService $fileService,
        private CacheService $cacheService
    ) {
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
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
    public function publicIndex(Request $request): View
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
        $featured = Publication::with('user')->public()->published()->featured()->limit(3)->get();

        return view('frontend.publications', compact('publications', 'featured'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        Gate::authorize('create', Publication::class);

        return view('publications.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePublicationRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        // Handle PDF upload using FileUploadService
        if ($request->hasFile('pdf_file')) {
            $fileData = $this->fileService->uploadPdf($request->file('pdf_file'), 'publications');
            $validated['pdf_file'] = $fileData['path'];
            $validated['pdf_original_name'] = $fileData['original_name'];
            $validated['pdf_file_size'] = $fileData['size'];
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

        // Clear publication caches
        $this->cacheService->clearPublicationCaches();

        return redirect()->route('publications.index')
            ->with('success', __('Publication created successfully!'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Publication $publication): View
    {
        Gate::authorize('view', $publication);

        $publication->load('user');

        return view('publications.show', compact('publication'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Publication $publication): View
    {
        Gate::authorize('update', $publication);

        return view('publications.edit', compact('publication'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePublicationRequest $request, Publication $publication): RedirectResponse
    {
        $validated = $request->validated();

        // Handle PDF upload using FileUploadService
        if ($request->hasFile('pdf_file')) {
            $fileData = $this->fileService->replaceFile(
                $request->file('pdf_file'),
                $publication->pdf_file,
                'publications',
                'pdf'
            );
            $validated['pdf_file'] = $fileData['path'];
            $validated['pdf_original_name'] = $fileData['original_name'];
            $validated['pdf_file_size'] = $fileData['size'];
        }

        // Admin can change visibility and featured status
        if (auth()->user()->hasRole('admin')) {
            $validated['visibility'] = $request->input('visibility', $publication->visibility);
            $validated['is_featured'] = $request->has('is_featured');
        }

        $validated['is_open_access'] = $request->has('is_open_access');

        $publication->update($validated);

        // Clear publication caches
        $this->cacheService->clearPublicationCaches();

        return redirect()->route('publications.index')
            ->with('success', __('Publication updated successfully!'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Publication $publication): RedirectResponse
    {
        Gate::authorize('delete', $publication);

        // Delete PDF file using FileUploadService
        $this->fileService->deleteFile($publication->pdf_file);

        $publication->delete();

        // Clear publication caches
        $this->cacheService->clearPublicationCaches();

        return redirect()->route('publications.index')
            ->with('success', __('Publication deleted successfully!'));
    }

    /**
     * Approve publication (admin only)
     */
    public function approve(Publication $publication): RedirectResponse
    {
        Gate::authorize('approve', $publication);

        $publication->update(['visibility' => 'public']);

        // Send email notification to author
        if (Setting::get('notify_user_on_status_change', true)) {
            Mail::to($publication->user->email)
                ->send(new PublicationStatusChanged($publication, 'approved'));
        }

        // Send notification to admin
        if (Setting::get('notify_admin_on_submission', true)) {
            $adminEmail = Setting::get('admin_notification_email');
            if ($adminEmail) {
                Mail::to($adminEmail)
                    ->send(new PublicationStatusChanged($publication, 'approved'));
            }
        }

        return redirect()->back()
            ->with('success', __('Publication approved successfully!'));
    }

    /**
     * Reject publication (admin only)
     */
    public function reject(Publication $publication): RedirectResponse
    {
        Gate::authorize('approve', $publication);

        $publication->update(['visibility' => 'private']);

        // Send email notification to author
        if (Setting::get('notify_user_on_status_change', true)) {
            Mail::to($publication->user->email)
                ->send(new PublicationStatusChanged($publication, 'rejected'));
        }

        // Send notification to admin
        if (Setting::get('notify_admin_on_submission', true)) {
            $adminEmail = Setting::get('admin_notification_email');
            if ($adminEmail) {
                Mail::to($adminEmail)
                    ->send(new PublicationStatusChanged($publication, 'rejected'));
            }
        }

        return redirect()->back()
            ->with('success', __('Publication rejected!'));
    }
}
