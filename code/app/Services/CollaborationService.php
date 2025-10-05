<?php

namespace App\Services;

use App\Models\Collaboration;
use App\Models\Researcher;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CollaborationService
{
    public function __construct(
        private FileUploadService $fileUploadService,
        private NotificationService $notificationService
    ) {}

    /**
     * Get paginated list of collaborations with filters.
     */
    public function getCollaborations(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Collaboration::with(['coordinator.user']);

        // Apply filters
        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->byTitle($filters['search'])
                  ->orByInstitution($filters['search']);
            });
        }

        if (!empty($filters['type'])) {
            $query->byType($filters['type']);
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['country'])) {
            $query->byCountry($filters['country']);
        }

        if (!empty($filters['coordinator_id'])) {
            $query->where('coordinator_id', $filters['coordinator_id']);
        }

        if (!empty($filters['active_only'])) {
            $query->active();
        }

        return $query->orderBy('start_date', 'desc')->paginate($perPage);
    }

    /**
     * Create a new collaboration.
     */
    public function createCollaboration(array $collaborationData, Researcher $coordinator): Collaboration
    {
        return DB::transaction(function () use ($collaborationData, $coordinator) {
            // Validate collaboration dates
            $this->validateCollaborationDates($collaborationData);

            // Create collaboration
            $collaboration = Collaboration::create([
                'title_ar' => $collaborationData['title_ar'],
                'title_fr' => $collaborationData['title_fr'],
                'title_en' => $collaborationData['title_en'],
                'institution_name' => $collaborationData['institution_name'],
                'country' => $collaborationData['country'],
                'contact_person' => $collaborationData['contact_person'] ?? null,
                'contact_email' => $collaborationData['contact_email'] ?? null,
                'start_date' => $collaborationData['start_date'],
                'end_date' => $collaborationData['end_date'] ?? null,
                'type' => $collaborationData['type'],
                'status' => 'active', // Default status
                'description_ar' => $collaborationData['description_ar'] ?? null,
                'description_fr' => $collaborationData['description_fr'] ?? null,
                'description_en' => $collaborationData['description_en'] ?? null,
                'coordinator_id' => $coordinator->id,
            ]);

            // Send notification about new collaboration
            $this->notificationService->notifyNewCollaboration($collaboration);

            return $collaboration->load(['coordinator.user']);
        });
    }

    /**
     * Update collaboration information.
     */
    public function updateCollaboration(Collaboration $collaboration, array $updateData): Collaboration
    {
        return DB::transaction(function () use ($collaboration, $updateData) {
            // Validate dates if provided
            if (isset($updateData['start_date']) || isset($updateData['end_date'])) {
                $this->validateCollaborationDates(array_merge($collaboration->toArray(), $updateData));
            }

            // Update collaboration
            $collaboration->update($updateData);

            return $collaboration->fresh(['coordinator.user']);
        });
    }

    /**
     * Change collaboration status.
     */
    public function changeCollaborationStatus(Collaboration $collaboration, string $newStatus, string $reason = null): Collaboration
    {
        $this->validateStatusTransition($collaboration->status, $newStatus);

        $oldStatus = $collaboration->status;
        $collaboration->update(['status' => $newStatus]);

        // Log status change
        \Log::info("Collaboration {$collaboration->id} status changed from {$oldStatus} to {$newStatus}", [
            'collaboration_id' => $collaboration->id,
            'old_status' => $oldStatus,
            'new_status' => $newStatus,
            'reason' => $reason,
        ]);

        return $collaboration;
    }

    /**
     * Get collaboration statistics.
     */
    public function getCollaborationStatistics(Collaboration $collaboration): array
    {
        return [
            'duration_days' => $collaboration->duration,
            'is_active' => $collaboration->isActive(),
            'is_ongoing' => $collaboration->isCurrentlyValid(),
            'type_category' => $collaboration->type,
            'partner_country' => $collaboration->country,
            'coordinator' => $collaboration->coordinator->full_name,
            'contact_available' => !empty($collaboration->contact_email),
            'has_end_date' => !is_null($collaboration->end_date),
            'time_remaining' => $collaboration->end_date ?
                max(0, now()->diffInDays($collaboration->end_date)) : null,
        ];
    }

    /**
     * Get collaborations dashboard for coordinator.
     */
    public function getCoordinatorDashboard(Researcher $coordinator): array
    {
        $collaborations = $coordinator->coordinatedCollaborations()->get();

        return [
            'collaborations' => $collaborations,
            'statistics' => [
                'total_collaborations' => $collaborations->count(),
                'active_collaborations' => $collaborations->where('status', 'active')->count(),
                'completed_collaborations' => $collaborations->where('status', 'completed')->count(),
                'ongoing_collaborations' => $collaborations->filter->isCurrentlyValid()->count(),
                'collaborations_by_type' => $collaborations->groupBy('type')->map->count(),
                'collaborations_by_country' => $collaborations->groupBy('country')->map->count(),
                'international_collaborations' => $collaborations->where('type', 'international')->count(),
            ],
        ];
    }

    /**
     * Search collaborations by multiple criteria.
     */
    public function searchCollaborations(string $query, array $filters = []): Collection
    {
        $searchQuery = Collaboration::with(['coordinator.user'])
            ->where(function ($q) use ($query) {
                $q->byTitle($query)
                  ->orByInstitution($query)
                  ->orByCountry($query);
            });

        // Apply filters
        if (!empty($filters['type'])) {
            $searchQuery->byType($filters['type']);
        }

        if (!empty($filters['status'])) {
            $searchQuery->where('status', $filters['status']);
        }

        if (!empty($filters['active_only'])) {
            $searchQuery->active();
        }

        return $searchQuery->limit(50)->get();
    }

    /**
     * Get collaboration network analysis.
     */
    public function getCollaborationNetwork(): array
    {
        // Get collaborations by country
        $countryStats = Collaboration::selectRaw('country, COUNT(*) as count,
                                                  SUM(CASE WHEN status = "active" THEN 1 ELSE 0 END) as active_count')
            ->groupBy('country')
            ->orderBy('count', 'desc')
            ->get();

        // Get collaborations by type
        $typeStats = Collaboration::selectRaw('type, COUNT(*) as count')
            ->groupBy('type')
            ->get();

        // Get most active coordinators
        $coordinatorStats = Collaboration::selectRaw('coordinator_id, COUNT(*) as collaboration_count')
            ->groupBy('coordinator_id')
            ->orderBy('collaboration_count', 'desc')
            ->limit(10)
            ->with(['coordinator.user'])
            ->get();

        return [
            'by_country' => $countryStats,
            'by_type' => $typeStats,
            'top_coordinators' => $coordinatorStats,
            'total_active' => Collaboration::active()->count(),
            'total_international' => Collaboration::where('type', 'international')->count(),
        ];
    }

    /**
     * Generate collaboration agreement template.
     */
    public function generateAgreementTemplate(Collaboration $collaboration): array
    {
        return [
            'collaboration_id' => $collaboration->id,
            'title' => $collaboration->getTitle(),
            'parties' => [
                'local_institution' => config('app.institution_name', 'Research Laboratory'),
                'partner_institution' => $collaboration->institution_name,
                'partner_country' => $collaboration->country,
            ],
            'coordinator' => [
                'name' => $collaboration->coordinator->full_name,
                'email' => $collaboration->coordinator->user->email,
            ],
            'partner_contact' => [
                'name' => $collaboration->contact_person,
                'email' => $collaboration->contact_email,
            ],
            'duration' => [
                'start_date' => $collaboration->start_date->format('Y-m-d'),
                'end_date' => $collaboration->end_date?->format('Y-m-d'),
                'duration_days' => $collaboration->duration,
            ],
            'type' => $collaboration->type,
            'description' => $collaboration->getDescription(),
            'template_generated_at' => now()->format('Y-m-d H:i:s'),
        ];
    }

    /**
     * Upload collaboration document.
     */
    public function uploadCollaborationDocument(Collaboration $collaboration, UploadedFile $file, string $documentType): string
    {
        $filePath = $this->fileUploadService->uploadCollaborationDocument($file);

        // Log document upload
        \Log::info("Document uploaded for collaboration {$collaboration->id}", [
            'collaboration_id' => $collaboration->id,
            'document_type' => $documentType,
            'file_path' => $filePath,
        ]);

        return $filePath;
    }

    /**
     * Get collaboration timeline.
     */
    public function getCollaborationTimeline(Collaboration $collaboration): array
    {
        $timeline = [];

        // Collaboration start
        $timeline[] = [
            'date' => $collaboration->start_date,
            'event' => 'Collaboration Started',
            'description' => 'Collaboration agreement became effective',
            'type' => 'start',
        ];

        // Status changes (would need to be tracked in a separate table)
        $timeline[] = [
            'date' => $collaboration->updated_at,
            'event' => 'Status: ' . ucfirst($collaboration->status),
            'description' => "Collaboration status is currently {$collaboration->status}",
            'type' => 'status',
        ];

        // Collaboration end (if applicable)
        if ($collaboration->end_date) {
            $timeline[] = [
                'date' => $collaboration->end_date,
                'event' => 'Collaboration End Date',
                'description' => 'Scheduled end of collaboration',
                'type' => 'end',
            ];
        }

        // Sort by date
        usort($timeline, function ($a, $b) {
            return $a['date']->timestamp - $b['date']->timestamp;
        });

        return $timeline;
    }

    /**
     * Get collaboration types with translations.
     */
    public function getCollaborationTypes(): array
    {
        return [
            'academic' => 'أكاديمي',
            'industrial' => 'صناعي',
            'governmental' => 'حكومي',
            'international' => 'دولي',
            'other' => 'أخرى',
        ];
    }

    /**
     * Get available countries for collaboration.
     */
    public function getCollaborationCountries(): array
    {
        // This could be enhanced to include a comprehensive country list
        return Collaboration::distinct('country')
            ->pluck('country')
            ->filter()
            ->sort()
            ->values()
            ->toArray();
    }

    /**
     * Validate collaboration dates.
     */
    private function validateCollaborationDates(array $collaborationData): void
    {
        $startDate = \Carbon\Carbon::parse($collaborationData['start_date']);

        if ($startDate->isPast()) {
            throw ValidationException::withMessages([
                'start_date' => ['تاريخ بداية التعاون لا يمكن أن يكون في الماضي'],
            ]);
        }

        if (!empty($collaborationData['end_date'])) {
            $endDate = \Carbon\Carbon::parse($collaborationData['end_date']);

            if ($endDate->lte($startDate)) {
                throw ValidationException::withMessages([
                    'end_date' => ['تاريخ انتهاء التعاون يجب أن يكون بعد تاريخ البداية'],
                ]);
            }
        }
    }

    /**
     * Validate status transition.
     */
    private function validateStatusTransition(string $currentStatus, string $newStatus): void
    {
        $allowedTransitions = [
            'active' => ['completed', 'suspended', 'cancelled'],
            'suspended' => ['active', 'cancelled'],
            'completed' => [], // No transitions from completed
            'cancelled' => [], // No transitions from cancelled
        ];

        if (!isset($allowedTransitions[$currentStatus]) ||
            !in_array($newStatus, $allowedTransitions[$currentStatus])) {
            throw ValidationException::withMessages([
                'status' => ["لا يمكن تغيير حالة التعاون من {$currentStatus} إلى {$newStatus}"],
            ]);
        }
    }

    /**
     * Archive completed collaborations.
     */
    public function archiveCollaboration(Collaboration $collaboration): bool
    {
        if ($collaboration->status !== 'completed') {
            throw ValidationException::withMessages([
                'status' => ['يمكن أرشفة التعاونات المكتملة فقط'],
            ]);
        }

        // In a real implementation, you might move to an archive table
        // For now, we'll keep the status as completed
        return true;
    }

    /**
     * Send collaboration invitation email.
     */
    public function sendCollaborationInvitation(Collaboration $collaboration, array $invitationData): bool
    {
        try {
            // This would send an email to the partner institution
            \Log::info("Collaboration invitation sent", [
                'collaboration_id' => $collaboration->id,
                'partner_email' => $collaboration->contact_email,
                'invitation_data' => $invitationData,
            ]);

            return true;
        } catch (\Exception $e) {
            \Log::error("Failed to send collaboration invitation", [
                'collaboration_id' => $collaboration->id,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }
}