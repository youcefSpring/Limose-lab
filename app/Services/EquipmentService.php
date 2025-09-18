<?php

namespace App\Services;

use App\Models\Equipment;
use App\Models\EquipmentReservation;
use App\Models\Researcher;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class EquipmentService
{
    public function __construct(
        private NotificationService $notificationService
    ) {}

    /**
     * Get paginated list of equipment with filters.
     */
    public function getEquipment(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Equipment::with(['reservations' => function ($q) {
            $q->where('status', 'approved')->orderBy('start_datetime');
        }]);

        // Apply filters
        if (!empty($filters['search'])) {
            $query->byName($filters['search']);
        }

        if (!empty($filters['category'])) {
            $query->byCategory($filters['category']);
        }

        if (!empty($filters['location'])) {
            $query->byLocation($filters['location']);
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['available_only'])) {
            $query->available();
        }

        return $query->orderBy('name_en')->paginate($perPage);
    }

    /**
     * Create equipment reservation.
     */
    public function createReservation(array $reservationData, Researcher $researcher): EquipmentReservation
    {
        return DB::transaction(function () use ($reservationData, $researcher) {
            $equipment = Equipment::findOrFail($reservationData['equipment_id']);

            // Validate equipment availability
            $this->validateEquipmentAvailability(
                $equipment,
                $reservationData['start_datetime'],
                $reservationData['end_datetime']
            );

            // Validate reservation times
            $this->validateReservationTimes(
                $reservationData['start_datetime'],
                $reservationData['end_datetime']
            );

            // Create reservation
            $reservation = EquipmentReservation::create([
                'equipment_id' => $equipment->id,
                'researcher_id' => $researcher->id,
                'project_id' => $reservationData['project_id'] ?? null,
                'start_datetime' => $reservationData['start_datetime'],
                'end_datetime' => $reservationData['end_datetime'],
                'purpose_ar' => $reservationData['purpose_ar'] ?? null,
                'purpose_fr' => $reservationData['purpose_fr'] ?? null,
                'purpose_en' => $reservationData['purpose_en'] ?? null,
                'status' => 'pending',
                'notes' => $reservationData['notes'] ?? null,
            ]);

            // Update equipment status to reserved if auto-approved
            if ($this->shouldAutoApprove($equipment, $researcher)) {
                $this->approveReservation($reservation, null, 'Auto-approved for trusted researcher');
            } else {
                // Notify administrators for approval
                $this->notificationService->notifyAdminsOfNewReservation($reservation);
            }

            return $reservation->load(['equipment', 'researcher.user', 'project']);
        });
    }

    /**
     * Approve equipment reservation.
     */
    public function approveReservation(EquipmentReservation $reservation, ?User $approver = null, string $notes = null): EquipmentReservation
    {
        return DB::transaction(function () use ($reservation, $approver, $notes) {
            // Double-check availability
            $this->validateEquipmentAvailability(
                $reservation->equipment,
                $reservation->start_datetime,
                $reservation->end_datetime,
                $reservation->id
            );

            // Update reservation
            $reservation->update([
                'status' => 'approved',
                'approved_by' => $approver?->id,
                'notes' => $notes ? ($reservation->notes . "\n" . $notes) : $reservation->notes,
            ]);

            // Update equipment status if needed
            if ($reservation->isCurrentlyActive()) {
                $reservation->equipment->update(['status' => 'reserved']);
            }

            // Notify researcher
            $this->notificationService->notifyReservationApproved($reservation);

            return $reservation;
        });
    }

    /**
     * Reject equipment reservation.
     */
    public function rejectReservation(EquipmentReservation $reservation, User $rejector, string $reason): EquipmentReservation
    {
        $reservation->update([
            'status' => 'rejected',
            'approved_by' => $rejector->id,
            'notes' => $reservation->notes . "\nRejected: " . $reason,
        ]);

        // Notify researcher
        $this->notificationService->notifyReservationRejected($reservation, $reason);

        return $reservation;
    }

    /**
     * Cancel equipment reservation.
     */
    public function cancelReservation(EquipmentReservation $reservation, string $reason = null): EquipmentReservation
    {
        if (!in_array($reservation->status, ['pending', 'approved'])) {
            throw ValidationException::withMessages([
                'status' => ['لا يمكن إلغاء الحجز بالحالة الحالية'],
            ]);
        }

        $reservation->update([
            'status' => 'cancelled',
            'notes' => $reservation->notes . "\nCancelled: " . ($reason ?? 'No reason provided'),
        ]);

        // Update equipment status if it was reserved
        if ($reservation->equipment->status === 'reserved' && $reservation->isCurrentlyActive()) {
            $reservation->equipment->update(['status' => 'available']);
        }

        return $reservation;
    }

    /**
     * Complete equipment reservation (check-out).
     */
    public function completeReservation(EquipmentReservation $reservation, array $completionData = []): EquipmentReservation
    {
        if ($reservation->status !== 'approved') {
            throw ValidationException::withMessages([
                'status' => ['يمكن إنهاء الحجوزات المعتمدة فقط'],
            ]);
        }

        $reservation->update([
            'status' => 'completed',
            'notes' => $reservation->notes . "\nCompleted: " . ($completionData['notes'] ?? 'Equipment returned'),
        ]);

        // Update equipment status
        $reservation->equipment->update(['status' => 'available']);

        return $reservation;
    }

    /**
     * Check equipment availability for a time period.
     */
    public function checkAvailability(Equipment $equipment, string $startDateTime, string $endDateTime, ?int $excludeReservationId = null): array
    {
        $start = Carbon::parse($startDateTime);
        $end = Carbon::parse($endDateTime);

        // Check if equipment is available
        if (!$equipment->isAvailable() && $equipment->status !== 'reserved') {
            return [
                'available' => false,
                'reason' => 'معدة غير متاحة - ' . $equipment->status,
                'conflicts' => [],
            ];
        }

        // Check for conflicting reservations
        $conflicts = $equipment->reservations()
            ->whereIn('status', ['approved', 'pending'])
            ->when($excludeReservationId, function ($query) use ($excludeReservationId) {
                $query->where('id', '!=', $excludeReservationId);
            })
            ->where(function ($query) use ($start, $end) {
                $query->whereBetween('start_datetime', [$start, $end])
                      ->orWhereBetween('end_datetime', [$start, $end])
                      ->orWhere(function ($q) use ($start, $end) {
                          $q->where('start_datetime', '<=', $start)
                            ->where('end_datetime', '>=', $end);
                      });
            })
            ->with(['researcher.user'])
            ->get();

        return [
            'available' => $conflicts->isEmpty(),
            'reason' => $conflicts->isNotEmpty() ? 'يتعارض مع حجوزات أخرى' : null,
            'conflicts' => $conflicts->map(function ($reservation) {
                return [
                    'id' => $reservation->id,
                    'researcher' => $reservation->researcher->full_name,
                    'start' => $reservation->start_datetime,
                    'end' => $reservation->end_datetime,
                    'status' => $reservation->status,
                ];
            }),
        ];
    }

    /**
     * Get equipment calendar for a specific month.
     */
    public function getEquipmentCalendar(Equipment $equipment, int $year, int $month): array
    {
        $startDate = Carbon::create($year, $month, 1)->startOfMonth();
        $endDate = $startDate->copy()->endOfMonth();

        $reservations = $equipment->reservations()
            ->whereIn('status', ['approved', 'pending'])
            ->whereBetween('start_datetime', [$startDate, $endDate])
            ->orWhereBetween('end_datetime', [$startDate, $endDate])
            ->orWhere(function ($query) use ($startDate, $endDate) {
                $query->where('start_datetime', '<=', $startDate)
                      ->where('end_datetime', '>=', $endDate);
            })
            ->with(['researcher.user', 'project'])
            ->orderBy('start_datetime')
            ->get();

        return [
            'equipment' => $equipment,
            'month' => $month,
            'year' => $year,
            'reservations' => $reservations->map(function ($reservation) {
                return [
                    'id' => $reservation->id,
                    'title' => $reservation->researcher->full_name,
                    'start' => $reservation->start_datetime,
                    'end' => $reservation->end_datetime,
                    'status' => $reservation->status,
                    'purpose' => $reservation->getPurpose(),
                    'project' => $reservation->project?->getTitle(),
                    'researcher' => $reservation->researcher->full_name,
                    'duration_hours' => $reservation->getDurationInHours(),
                ];
            }),
        ];
    }

    /**
     * Get equipment usage statistics.
     */
    public function getEquipmentStatistics(Equipment $equipment, ?string $period = 'month'): array
    {
        $startDate = match ($period) {
            'week' => now()->startOfWeek(),
            'month' => now()->startOfMonth(),
            'quarter' => now()->startOfQuarter(),
            'year' => now()->startOfYear(),
            default => now()->startOfMonth(),
        };

        $reservations = $equipment->reservations()
            ->where('created_at', '>=', $startDate)
            ->with(['researcher']);

        return [
            'total_reservations' => $reservations->count(),
            'approved_reservations' => $reservations->clone()->approved()->count(),
            'pending_reservations' => $reservations->clone()->pending()->count(),
            'completed_reservations' => $reservations->clone()->where('status', 'completed')->count(),
            'total_usage_hours' => $reservations->clone()->approved()->get()->sum('duration_in_hours'),
            'unique_users' => $reservations->clone()->distinct('researcher_id')->count(),
            'most_active_users' => $reservations->clone()
                ->selectRaw('researcher_id, COUNT(*) as reservation_count')
                ->groupBy('researcher_id')
                ->orderBy('reservation_count', 'desc')
                ->limit(5)
                ->with(['researcher'])
                ->get(),
            'usage_by_month' => $equipment->reservations()
                ->selectRaw('YEAR(start_datetime) as year, MONTH(start_datetime) as month, COUNT(*) as count')
                ->where('status', 'approved')
                ->where('start_datetime', '>=', now()->subYear())
                ->groupBy('year', 'month')
                ->orderBy('year', 'desc')
                ->orderBy('month', 'desc')
                ->get(),
        ];
    }

    /**
     * Get researcher's reservations.
     */
    public function getResearcherReservations(Researcher $researcher, array $filters = []): Collection
    {
        $query = $researcher->equipmentReservations()
            ->with(['equipment', 'project']);

        // Apply filters
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['equipment_id'])) {
            $query->where('equipment_id', $filters['equipment_id']);
        }

        if (!empty($filters['date_from'])) {
            $query->where('start_datetime', '>=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $query->where('end_datetime', '<=', $filters['date_to']);
        }

        return $query->orderBy('start_datetime', 'desc')->get();
    }

    /**
     * Validate equipment availability.
     */
    private function validateEquipmentAvailability(Equipment $equipment, string $startDateTime, string $endDateTime, ?int $excludeReservationId = null): void
    {
        $availability = $this->checkAvailability($equipment, $startDateTime, $endDateTime, $excludeReservationId);

        if (!$availability['available']) {
            throw ValidationException::withMessages([
                'equipment_id' => [$availability['reason']],
            ]);
        }
    }

    /**
     * Validate reservation times.
     */
    private function validateReservationTimes(string $startDateTime, string $endDateTime): void
    {
        $start = Carbon::parse($startDateTime);
        $end = Carbon::parse($endDateTime);

        if ($start->gte($end)) {
            throw ValidationException::withMessages([
                'end_datetime' => ['وقت الانتهاء يجب أن يكون بعد وقت البداية'],
            ]);
        }

        if ($start->isPast()) {
            throw ValidationException::withMessages([
                'start_datetime' => ['لا يمكن حجز المعدة في الماضي'],
            ]);
        }

        // Check maximum reservation duration (e.g., 30 days)
        if ($start->diffInDays($end) > 30) {
            throw ValidationException::withMessages([
                'end_datetime' => ['لا يمكن أن تتجاوز مدة الحجز 30 يومًا'],
            ]);
        }
    }

    /**
     * Check if reservation should be auto-approved.
     */
    private function shouldAutoApprove(Equipment $equipment, Researcher $researcher): bool
    {
        // Auto-approve for equipment that doesn't require approval
        // or for trusted researchers (e.g., lab managers)
        return $researcher->user->isLabManager() || $researcher->user->isAdmin();
    }

    /**
     * Get equipment categories.
     */
    public function getEquipmentCategories(): array
    {
        return Equipment::distinct('category')
            ->pluck('category')
            ->filter()
            ->sort()
            ->values()
            ->toArray();
    }

    /**
     * Get equipment maintenance schedule.
     */
    public function getMaintenanceSchedule(Equipment $equipment): array
    {
        // This would integrate with maintenance management system
        // For now, return basic information
        return [
            'next_maintenance' => $this->calculateNextMaintenance($equipment),
            'maintenance_history' => [], // Would come from maintenance logs
            'warranty_status' => [
                'expires_at' => $equipment->warranty_expiry,
                'is_expired' => $equipment->isWarrantyExpired(),
                'days_remaining' => $equipment->warranty_expiry ?
                    max(0, now()->diffInDays($equipment->warranty_expiry)) : null,
            ],
        ];
    }

    /**
     * Calculate next maintenance date.
     */
    private function calculateNextMaintenance(Equipment $equipment): ?Carbon
    {
        if (!$equipment->maintenance_schedule) {
            return null;
        }

        // Simple calculation based on schedule
        return match (strtolower($equipment->maintenance_schedule)) {
            'weekly' => now()->addWeek(),
            'monthly' => now()->addMonth(),
            'quarterly' => now()->addQuarter(),
            'yearly' => now()->addYear(),
            default => null,
        };
    }
}