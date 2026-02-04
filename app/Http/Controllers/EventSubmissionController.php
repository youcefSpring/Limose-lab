<?php

namespace App\Http\Controllers;

use App\Mail\EventSubmissionReceived;
use App\Mail\EventSubmissionStatusChanged;
use App\Models\Event;
use App\Models\EventSubmission;
use App\Models\Setting;
use App\Services\FileUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class EventSubmissionController extends Controller
{
    public function __construct(private FileUploadService $fileService)
    {
    }

    /**
     * Display a listing of submissions for an event.
     */
    public function index(Event $event): View
    {
        Gate::authorize('view', $event);

        $submissions = $event->submissions()
            ->with(['user', 'reviewer'])
            ->latest()
            ->paginate(20);

        return view('events.submissions.index', compact('event', 'submissions'));
    }

    /**
     * Show the form for creating a new submission.
     */
    public function create(Event $event): View
    {
        // Check if event accepts submissions
        if (!$event->acceptsSubmissions()) {
            abort(403, __('This event does not accept submissions.'));
        }

        // Check if user already submitted
        $existingSubmission = $event->submissions()
            ->where('user_id', auth()->id())
            ->first();

        if ($existingSubmission) {
            return redirect()->route('events.submissions.show', [$event, $existingSubmission])
                ->with('info', __('You have already submitted to this event.'));
        }

        return view('events.submissions.create', compact('event'));
    }

    /**
     * Store a newly created submission.
     */
    public function store(Request $request, Event $event): RedirectResponse
    {
        if (!$event->acceptsSubmissions()) {
            abort(403, __('This event does not accept submissions.'));
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'abstract' => 'required|string',
            'authors' => 'nullable|string',
            'submission_type' => 'required|in:paper,poster,abstract',
            'category' => 'nullable|string|max:255',
            'keywords' => 'nullable|string',
            'paper_file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'presentation_file' => 'nullable|file|mimes:pdf,ppt,pptx|max:10240',
            'author_notes' => 'nullable|string',
        ]);

        // Handle paper file upload
        if ($request->hasFile('paper_file')) {
            $fileData = $this->fileService->uploadPdf($request->file('paper_file'), 'submissions/papers');
            $validated['paper_file'] = $fileData['path'];
        }

        // Handle presentation file upload
        if ($request->hasFile('presentation_file')) {
            $fileData = $this->fileService->uploadPdf($request->file('presentation_file'), 'submissions/presentations');
            $validated['presentation_file'] = $fileData['path'];
        }

        $validated['event_id'] = $event->id;
        $validated['user_id'] = auth()->id();
        $validated['submitted_at'] = now();
        $validated['status'] = 'pending';

        $submission = EventSubmission::create($validated);

        // Send email to admin
        if (Setting::get('notify_admin_on_submission', true)) {
            $adminEmail = Setting::get('admin_notification_email');
            if ($adminEmail) {
                Mail::to($adminEmail)
                    ->send(new EventSubmissionReceived($submission));
            }
        }

        // Send confirmation to user
        if (Setting::get('notify_user_on_status_change', true)) {
            Mail::to(auth()->user()->email)
                ->send(new EventSubmissionReceived($submission));
        }

        return redirect()->route('events.show', $event)
            ->with('success', __('Submission created successfully!'));
    }

    /**
     * Display the specified submission.
     */
    public function show(Event $event, EventSubmission $submission): View
    {
        Gate::authorize('view', $submission);

        $submission->load(['user', 'reviewer', 'event']);

        return view('events.submissions.show', compact('event', 'submission'));
    }

    /**
     * Show the form for editing the specified submission.
     */
    public function edit(Event $event, EventSubmission $submission): View
    {
        Gate::authorize('update', $submission);

        return view('events.submissions.edit', compact('event', 'submission'));
    }

    /**
     * Update the specified submission.
     */
    public function update(Request $request, Event $event, EventSubmission $submission): RedirectResponse
    {
        Gate::authorize('update', $submission);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'abstract' => 'required|string',
            'authors' => 'nullable|string',
            'submission_type' => 'required|in:paper,poster,abstract',
            'category' => 'nullable|string|max:255',
            'keywords' => 'nullable|string',
            'paper_file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'presentation_file' => 'nullable|file|mimes:pdf,ppt,pptx|max:10240',
            'author_notes' => 'nullable|string',
        ]);

        // Handle paper file upload
        if ($request->hasFile('paper_file')) {
            $fileData = $this->fileService->replaceFile(
                $request->file('paper_file'),
                $submission->paper_file,
                'submissions/papers',
                'pdf'
            );
            $validated['paper_file'] = $fileData['path'];
        }

        // Handle presentation file upload
        if ($request->hasFile('presentation_file')) {
            $fileData = $this->fileService->replaceFile(
                $request->file('presentation_file'),
                $submission->presentation_file,
                'submissions/presentations',
                'pdf'
            );
            $validated['presentation_file'] = $fileData['path'];
        }

        $submission->update($validated);

        return redirect()->route('events.submissions.show', [$event, $submission])
            ->with('success', __('Submission updated successfully!'));
    }

    /**
     * Remove the specified submission.
     */
    public function destroy(Event $event, EventSubmission $submission): RedirectResponse
    {
        Gate::authorize('delete', $submission);

        // Delete files
        $this->fileService->deleteFile($submission->paper_file);
        $this->fileService->deleteFile($submission->presentation_file);

        $submission->delete();

        return redirect()->route('events.show', $event)
            ->with('success', __('Submission deleted successfully!'));
    }

    /**
     * Accept a submission.
     */
    public function accept(Request $request, Event $event, EventSubmission $submission): RedirectResponse
    {
        Gate::authorize('review', $submission);

        $oldStatus = $submission->status;

        $submission->accept($request->input('reviewer_notes'));

        // Send email to submitter
        if (Setting::get('notify_user_on_status_change', true)) {
            Mail::to($submission->user->email)
                ->send(new EventSubmissionStatusChanged($submission, $oldStatus));
        }

        // Notify admin
        if (Setting::get('notify_admin_on_submission', true)) {
            $adminEmail = Setting::get('admin_notification_email');
            if ($adminEmail) {
                Mail::to($adminEmail)
                    ->send(new EventSubmissionStatusChanged($submission, $oldStatus));
            }
        }

        return redirect()->back()
            ->with('success', __('Submission accepted!'));
    }

    /**
     * Reject a submission.
     */
    public function reject(Request $request, Event $event, EventSubmission $submission): RedirectResponse
    {
        Gate::authorize('review', $submission);

        $oldStatus = $submission->status;

        $submission->reject($request->input('reviewer_notes'));

        // Send email to submitter
        if (Setting::get('notify_user_on_status_change', true)) {
            Mail::to($submission->user->email)
                ->send(new EventSubmissionStatusChanged($submission, $oldStatus));
        }

        // Notify admin
        if (Setting::get('notify_admin_on_submission', true)) {
            $adminEmail = Setting::get('admin_notification_email');
            if ($adminEmail) {
                Mail::to($adminEmail)
                    ->send(new EventSubmissionStatusChanged($submission, $oldStatus));
            }
        }

        return redirect()->back()
            ->with('success', __('Submission rejected!'));
    }

    /**
     * Request revision for a submission.
     */
    public function requestRevision(Request $request, Event $event, EventSubmission $submission): RedirectResponse
    {
        Gate::authorize('review', $submission);

        $oldStatus = $submission->status;

        $submission->requestRevision($request->input('reviewer_notes'));

        // Send email to submitter
        if (Setting::get('notify_user_on_status_change', true)) {
            Mail::to($submission->user->email)
                ->send(new EventSubmissionStatusChanged($submission, $oldStatus));
        }

        return redirect()->back()
            ->with('success', __('Revision requested!'));
    }
}
