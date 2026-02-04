<?php

namespace App\Mail;

use App\Models\EventSubmission;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EventSubmissionStatusChanged extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public EventSubmission $submission,
        public string $oldStatus
    ) {
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $statusText = match($this->submission->status) {
            'accepted' => __('Accepted'),
            'rejected' => __('Rejected'),
            'under_review' => __('Under Review'),
            'revision_requested' => __('Revision Requested'),
            default => __('Updated'),
        };

        return new Envelope(
            subject: __('Submission Status') . ': ' . $statusText . ' - ' . $this->submission->title,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.event-submission-status-changed',
            with: [
                'submission' => $this->submission,
                'event' => $this->submission->event,
                'oldStatus' => $this->oldStatus,
                'newStatus' => $this->submission->status,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
