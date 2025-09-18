<?php

namespace App\Services;

use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class EventService
{
    public function __construct(
        private NotificationService $notificationService
    ) {}

    /**
     * Get paginated list of events with filters.
     */
    public function getEvents(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Event::with(['organizer', 'registrations']);

        // Apply filters
        if (!empty($filters['search'])) {
            $query->byTitle($filters['search']);
        }

        if (!empty($filters['type'])) {
            $query->byType($filters['type']);
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['upcoming'])) {
            $query->upcoming();
        }

        if (!empty($filters['organizer_id'])) {
            $query->where('organizer_id', $filters['organizer_id']);
        }

        if (!empty($filters['date_from']) && !empty($filters['date_to'])) {
            $query->byDateRange($filters['date_from'], $filters['date_to']);
        }

        return $query->orderBy('start_date', 'desc')->paginate($perPage);
    }

    /**
     * Create a new event.
     */
    public function createEvent(array $eventData, User $organizer): Event
    {
        return DB::transaction(function () use ($eventData, $organizer) {
            // Validate event dates
            $this->validateEventDates($eventData);

            // Create event
            $event = Event::create([
                'title_ar' => $eventData['title_ar'],
                'title_fr' => $eventData['title_fr'],
                'title_en' => $eventData['title_en'],
                'description_ar' => $eventData['description_ar'] ?? null,
                'description_fr' => $eventData['description_fr'] ?? null,
                'description_en' => $eventData['description_en'] ?? null,
                'type' => $eventData['type'],
                'start_date' => $eventData['start_date'],
                'end_date' => $eventData['end_date'],
                'start_time' => $eventData['start_time'] ?? null,
                'end_time' => $eventData['end_time'] ?? null,
                'location_ar' => $eventData['location_ar'] ?? null,
                'location_fr' => $eventData['location_fr'] ?? null,
                'location_en' => $eventData['location_en'] ?? null,
                'max_participants' => $eventData['max_participants'] ?? null,
                'registration_deadline' => $eventData['registration_deadline'] ?? null,
                'status' => 'draft', // Always starts as draft
                'organizer_id' => $organizer->id,
            ]);

            return $event->load(['organizer']);
        });
    }

    /**
     * Update event information.
     */
    public function updateEvent(Event $event, array $updateData): Event
    {
        return DB::transaction(function () use ($event, $updateData) {
            // Validate dates if provided
            if (isset($updateData['start_date']) || isset($updateData['end_date'])) {
                $this->validateEventDates(array_merge($event->toArray(), $updateData));
            }

            // Check if event can be modified
            if ($event->status === 'completed') {
                throw ValidationException::withMessages([
                    'status' => ['لا يمكن تعديل الأحداث المكتملة'],
                ]);
            }

            // Update event
            $event->update($updateData);

            // Notify registered participants of significant changes
            if (isset($updateData['start_date']) || isset($updateData['location_ar'])) {
                $this->notificationService->notifyEventUpdated($event);
            }

            return $event->fresh(['organizer', 'registrations']);
        });
    }

    /**
     * Change event status.
     */
    public function changeEventStatus(Event $event, string $newStatus): Event
    {
        $this->validateStatusTransition($event->status, $newStatus);

        $event->update(['status' => $newStatus]);

        // Send notifications based on status
        switch ($newStatus) {
            case 'published':
                $this->notificationService->notifyEventPublished($event);
                break;
            case 'ongoing':
                $this->notificationService->notifyEventStarted($event);
                break;
            case 'completed':
                $this->generateEventCertificates($event);
                break;
            case 'cancelled':
                $this->notificationService->notifyEventCancelled($event);
                break;
        }

        return $event;
    }

    /**
     * Register user for event.
     */
    public function registerForEvent(Event $event, User $user, array $registrationData = []): EventRegistration
    {
        return DB::transaction(function () use ($event, $user, $registrationData) {
            // Validate registration eligibility
            $this->validateEventRegistration($event, $user);

            // Create registration
            $registration = EventRegistration::create([
                'event_id' => $event->id,
                'user_id' => $user->id,
                'registration_date' => now(),
                'status' => 'registered',
                'notes' => $registrationData['notes'] ?? null,
            ]);

            // Notify organizer
            $this->notificationService->notifyEventRegistration($registration);

            // Send confirmation to user
            $this->notificationService->sendRegistrationConfirmation($registration);

            return $registration->load(['event', 'user']);
        });
    }

    /**
     * Cancel event registration.
     */
    public function cancelRegistration(EventRegistration $registration): bool
    {
        if ($registration->status === 'attended') {
            throw ValidationException::withMessages([
                'status' => ['لا يمكن إلغاء التسجيل بعد الحضور'],
            ]);
        }

        $registration->update(['status' => 'cancelled']);

        // Notify organizer
        $this->notificationService->notifyRegistrationCancelled($registration);

        return true;
    }

    /**
     * Confirm event registration.
     */
    public function confirmRegistration(EventRegistration $registration): EventRegistration
    {
        $registration->update(['status' => 'confirmed']);

        return $registration;
    }

    /**
     * Mark participant as attended.
     */
    public function markAttendance(EventRegistration $registration): EventRegistration
    {
        if (!$registration->event->isOngoing() && !$registration->event->isCompleted()) {
            throw ValidationException::withMessages([
                'status' => ['يمكن تسجيل الحضور للأحداث الجارية أو المكتملة فقط'],
            ]);
        }

        $registration->update(['status' => 'attended']);

        return $registration;
    }

    /**
     * Generate event certificate for participant.
     */
    public function generateCertificate(EventRegistration $registration): string
    {
        if (!$registration->hasAttended()) {
            throw ValidationException::withMessages([
                'attendance' => ['الشهادة متاحة للحاضرين فقط'],
            ]);
        }

        if ($registration->hasCertificate()) {
            return $registration->certificate_path;
        }

        // Generate certificate (this would integrate with a PDF generation service)
        $certificatePath = $this->generateEventCertificatePDF($registration);

        $registration->update([
            'certificate_generated' => true,
            'certificate_path' => $certificatePath,
        ]);

        return $certificatePath;
    }

    /**
     * Get event statistics.
     */
    public function getEventStatistics(Event $event): array
    {
        $registrations = $event->registrations();

        return [
            'total_registrations' => $registrations->count(),
            'confirmed_registrations' => $registrations->confirmed()->count(),
            'attended_count' => $registrations->attended()->count(),
            'cancelled_count' => $registrations->cancelled()->count(),
            'certificates_generated' => $registrations->withCertificates()->count(),
            'registration_rate' => $event->max_participants ?
                round(($registrations->count() / $event->max_participants) * 100, 1) : null,
            'attendance_rate' => $registrations->count() > 0 ?
                round(($registrations->attended()->count() / $registrations->count()) * 100, 1) : 0,
            'available_spots' => $event->available_spots,
            'is_full' => $event->isFull(),
            'registration_timeline' => $this->getRegistrationTimeline($event),
        ];
    }

    /**
     * Get events dashboard for organizer.
     */
    public function getOrganizerDashboard(User $organizer): array
    {
        $events = $organizer->organizedEvents()->with(['registrations'])->get();

        return [
            'events' => $events,
            'statistics' => [
                'total_events' => $events->count(),
                'upcoming_events' => $events->where('start_date', '>=', now())->count(),
                'completed_events' => $events->where('status', 'completed')->count(),
                'total_participants' => $events->sum(function ($event) {
                    return $event->registrations->count();
                }),
                'total_attendees' => $events->sum(function ($event) {
                    return $event->registrations->where('status', 'attended')->count();
                }),
                'events_by_type' => $events->groupBy('type')->map->count(),
            ],
        ];
    }

    /**
     * Search events by multiple criteria.
     */
    public function searchEvents(string $query, array $filters = []): Collection
    {
        $searchQuery = Event::with(['organizer'])
            ->byTitle($query);

        // Apply filters
        if (!empty($filters['type'])) {
            $searchQuery->byType($filters['type']);
        }

        if (!empty($filters['upcoming'])) {
            $searchQuery->upcoming();
        }

        if (!empty($filters['published'])) {
            $searchQuery->published();
        }

        return $searchQuery->limit(50)->get();
    }

    /**
     * Get participant list for event.
     */
    public function getEventParticipants(Event $event, array $filters = []): Collection
    {
        $query = $event->registrations()->with(['user']);

        // Apply filters
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['attended_only'])) {
            $query->attended();
        }

        return $query->orderBy('registration_date')->get();
    }

    /**
     * Validate event dates and times.
     */
    private function validateEventDates(array $eventData): void
    {
        $startDate = \Carbon\Carbon::parse($eventData['start_date']);
        $endDate = \Carbon\Carbon::parse($eventData['end_date']);

        if ($startDate->gt($endDate)) {
            throw ValidationException::withMessages([
                'end_date' => ['تاريخ الانتهاء يجب أن يكون بعد تاريخ البداية'],
            ]);
        }

        if ($startDate->isPast()) {
            throw ValidationException::withMessages([
                'start_date' => ['تاريخ البداية لا يمكن أن يكون في الماضي'],
            ]);
        }

        // Validate registration deadline
        if (!empty($eventData['registration_deadline'])) {
            $deadline = \Carbon\Carbon::parse($eventData['registration_deadline']);
            if ($deadline->gte($startDate)) {
                throw ValidationException::withMessages([
                    'registration_deadline' => ['موعد انتهاء التسجيل يجب أن يكون قبل بداية الحدث'],
                ]);
            }
        }
    }

    /**
     * Validate event registration.
     */
    private function validateEventRegistration(Event $event, User $user): void
    {
        // Check if event is open for registration
        if (!$event->isRegistrationOpen()) {
            throw ValidationException::withMessages([
                'registration' => ['التسجيل غير متاح لهذا الحدث'],
            ]);
        }

        // Check if user is already registered
        if ($event->registrations()->where('user_id', $user->id)->exists()) {
            throw ValidationException::withMessages([
                'registration' => ['أنت مسجل بالفعل في هذا الحدث'],
            ]);
        }

        // Check if event is full
        if ($event->isFull()) {
            throw ValidationException::withMessages([
                'registration' => ['الحدث ممتلئ'],
            ]);
        }
    }

    /**
     * Validate status transition.
     */
    private function validateStatusTransition(string $currentStatus, string $newStatus): void
    {
        $allowedTransitions = [
            'draft' => ['published', 'cancelled'],
            'published' => ['ongoing', 'cancelled'],
            'ongoing' => ['completed'],
            'completed' => [], // No transitions from completed
            'cancelled' => [], // No transitions from cancelled
        ];

        if (!isset($allowedTransitions[$currentStatus]) ||
            !in_array($newStatus, $allowedTransitions[$currentStatus])) {
            throw ValidationException::withMessages([
                'status' => ["لا يمكن تغيير حالة الحدث من {$currentStatus} إلى {$newStatus}"],
            ]);
        }
    }

    /**
     * Generate certificates for all attendees.
     */
    private function generateEventCertificates(Event $event): void
    {
        $attendees = $event->registrations()->attended()->get();

        foreach ($attendees as $registration) {
            if (!$registration->hasCertificate()) {
                $this->generateCertificate($registration);
            }
        }
    }

    /**
     * Generate PDF certificate for registration.
     */
    private function generateEventCertificatePDF(EventRegistration $registration): string
    {
        // This would integrate with a PDF generation library
        // For now, return a placeholder path
        $fileName = "certificate_{$registration->event->id}_{$registration->user->id}.pdf";
        $filePath = "certificates/{$fileName}";

        // TODO: Implement actual PDF generation
        \Log::info("Certificate generated for registration {$registration->id}: {$filePath}");

        return $filePath;
    }

    /**
     * Get registration timeline for event.
     */
    private function getRegistrationTimeline(Event $event): array
    {
        return $event->registrations()
            ->selectRaw('DATE(registration_date) as date, COUNT(*) as registrations')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('registrations', 'date')
            ->toArray();
    }

    /**
     * Get event types.
     */
    public function getEventTypes(): array
    {
        return [
            'seminar' => 'ندوة',
            'workshop' => 'ورشة عمل',
            'conference' => 'مؤتمر',
            'summer_school' => 'مدرسة صيفية',
            'meeting' => 'اجتماع',
            'other' => 'أخرى',
        ];
    }
}