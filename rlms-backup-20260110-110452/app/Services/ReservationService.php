<?php

namespace App\Services;

use App\Models\Material;
use App\Models\Reservation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReservationService
{
    /**
     * Configuration constants
     */
    const MAX_ACTIVE_RESERVATIONS = 3;
    const MAX_DURATION_DAYS = 30;

    /**
     * Create a new reservation with conflict detection.
     *
     * @param User $user
     * @param array $data
     * @return array ['success' => bool, 'reservation' => Reservation|null, 'errors' => array]
     */
    public function createReservation(User $user, array $data): array
    {
        // Validate material exists and is available
        $material = Material::find($data['material_id']);

        if (!$material) {
            return $this->errorResponse('Material not found');
        }

        if (!$material->isAvailable()) {
            return $this->errorResponse('Material is not available for reservation');
        }

        // Check user's active reservations limit
        if (!$this->canUserCreateReservation($user)) {
            return $this->errorResponse("You have reached the maximum of " . self::MAX_ACTIVE_RESERVATIONS . " active reservations");
        }

        // Validate duration
        $startDate = Carbon::parse($data['start_date']);
        $endDate = Carbon::parse($data['end_date']);
        $duration = $startDate->diffInDays($endDate);

        if ($duration > self::MAX_DURATION_DAYS) {
            return $this->errorResponse("Reservation duration cannot exceed " . self::MAX_DURATION_DAYS . " days");
        }

        // Check quantity availability
        if ($data['quantity'] > $material->quantity) {
            return $this->errorResponse('Requested quantity exceeds available quantity');
        }

        // Check for conflicts
        if ($this->hasConflict($material->id, $startDate, $endDate, $data['quantity'])) {
            return $this->errorResponse('The requested quantity is not available for the selected period due to overlapping reservations');
        }

        // Create reservation
        try {
            $reservation = DB::transaction(function () use ($user, $data) {
                return Reservation::create([
                    'user_id' => $user->id,
                    'material_id' => $data['material_id'],
                    'start_date' => $data['start_date'],
                    'end_date' => $data['end_date'],
                    'quantity' => $data['quantity'],
                    'purpose' => $data['purpose'],
                    'notes' => $data['notes'] ?? null,
                    'status' => 'pending',
                ]);
            });

            return [
                'success' => true,
                'reservation' => $reservation,
                'message' => 'Reservation created successfully. Awaiting approval.',
            ];
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to create reservation: ' . $e->getMessage());
        }
    }

    /**
     * Check if material has conflicting reservations for the period.
     *
     * @param int $materialId
     * @param Carbon $startDate
     * @param Carbon $endDate
     * @param int $requestedQuantity
     * @param int|null $excludeReservationId
     * @return bool
     */
    public function hasConflict(
        int $materialId,
        Carbon $startDate,
        Carbon $endDate,
        int $requestedQuantity,
        ?int $excludeReservationId = null
    ): bool {
        $material = Material::find($materialId);

        if (!$material) {
            return true;
        }

        // Get overlapping approved reservations
        $overlappingReservations = Reservation::where('material_id', $materialId)
            ->where('status', 'approved')
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('start_date', [$startDate, $endDate])
                    ->orWhereBetween('end_date', [$startDate, $endDate])
                    ->orWhere(function ($q) use ($startDate, $endDate) {
                        $q->where('start_date', '<=', $startDate)
                          ->where('end_date', '>=', $endDate);
                    });
            })
            ->when($excludeReservationId, function ($query, $id) {
                return $query->where('id', '!=', $id);
            })
            ->get();

        // Calculate maximum concurrent quantity reserved
        $maxReservedQuantity = $overlappingReservations->sum('quantity');

        // Check if requested quantity + existing reservations exceeds material quantity
        return ($maxReservedQuantity + $requestedQuantity) > $material->quantity;
    }

    /**
     * Approve a reservation.
     *
     * @param Reservation $reservation
     * @param User $validator
     * @return array
     */
    public function approveReservation(Reservation $reservation, User $validator): array
    {
        if (!$reservation->isPending()) {
            return $this->errorResponse('Only pending reservations can be approved');
        }

        // Re-check for conflicts
        if ($this->hasConflict(
            $reservation->material_id,
            Carbon::parse($reservation->start_date),
            Carbon::parse($reservation->end_date),
            $reservation->quantity,
            $reservation->id
        )) {
            return $this->errorResponse('Cannot approve: reservation conflicts with other approved reservations');
        }

        $reservation->update([
            'status' => 'approved',
            'validated_by' => $validator->id,
            'validated_at' => now(),
        ]);

        return [
            'success' => true,
            'reservation' => $reservation->fresh(),
            'message' => 'Reservation approved successfully',
        ];
    }

    /**
     * Reject a reservation.
     *
     * @param Reservation $reservation
     * @param User $validator
     * @param string $reason
     * @return array
     */
    public function rejectReservation(Reservation $reservation, User $validator, string $reason): array
    {
        if (!$reservation->isPending()) {
            return $this->errorResponse('Only pending reservations can be rejected');
        }

        $reservation->update([
            'status' => 'rejected',
            'validated_by' => $validator->id,
            'validated_at' => now(),
            'rejection_reason' => $reason,
        ]);

        return [
            'success' => true,
            'reservation' => $reservation->fresh(),
            'message' => 'Reservation rejected',
        ];
    }

    /**
     * Cancel a reservation.
     *
     * @param Reservation $reservation
     * @param User $user
     * @return array
     */
    public function cancelReservation(Reservation $reservation, User $user): array
    {
        if (!$reservation->canBeCancelled()) {
            return $this->errorResponse('This reservation cannot be cancelled');
        }

        // Only owner or admin can cancel
        if ($reservation->user_id !== $user->id && !$user->hasRole('admin')) {
            return $this->errorResponse('You are not authorized to cancel this reservation');
        }

        $reservation->update(['status' => 'cancelled']);

        return [
            'success' => true,
            'reservation' => $reservation->fresh(),
            'message' => 'Reservation cancelled successfully',
        ];
    }

    /**
     * Complete a reservation (auto or manual).
     *
     * @param Reservation $reservation
     * @return array
     */
    public function completeReservation(Reservation $reservation): array
    {
        if ($reservation->status !== 'approved') {
            return $this->errorResponse('Only approved reservations can be completed');
        }

        $reservation->update(['status' => 'completed']);

        return [
            'success' => true,
            'reservation' => $reservation->fresh(),
            'message' => 'Reservation marked as completed',
        ];
    }

    /**
     * Check if user can create another reservation.
     *
     * @param User $user
     * @return bool
     */
    public function canUserCreateReservation(User $user): bool
    {
        $activeReservations = Reservation::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'approved'])
            ->count();

        return $activeReservations < self::MAX_ACTIVE_RESERVATIONS;
    }

    /**
     * Get available quantity for a material in a date range.
     *
     * @param int $materialId
     * @param Carbon $startDate
     * @param Carbon $endDate
     * @return int
     */
    public function getAvailableQuantity(int $materialId, Carbon $startDate, Carbon $endDate): int
    {
        $material = Material::find($materialId);

        if (!$material || !$material->isAvailable()) {
            return 0;
        }

        $maxReserved = Reservation::where('material_id', $materialId)
            ->where('status', 'approved')
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('start_date', [$startDate, $endDate])
                    ->orWhereBetween('end_date', [$startDate, $endDate])
                    ->orWhere(function ($q) use ($startDate, $endDate) {
                        $q->where('start_date', '<=', $startDate)
                          ->where('end_date', '>=', $endDate);
                    });
            })
            ->sum('quantity');

        return max(0, $material->quantity - $maxReserved);
    }

    /**
     * Cancel all future reservations for a material (when it goes to maintenance).
     *
     * @param Material $material
     * @return int Number of cancelled reservations
     */
    public function cancelFutureReservations(Material $material): int
    {
        return Reservation::where('material_id', $material->id)
            ->whereIn('status', ['pending', 'approved'])
            ->where('start_date', '>', now())
            ->update(['status' => 'cancelled']);
    }

    /**
     * Auto-complete reservations that have passed their end date.
     *
     * @return int Number of completed reservations
     */
    public function autoCompleteExpiredReservations(): int
    {
        return Reservation::where('status', 'approved')
            ->where('end_date', '<', now())
            ->update(['status' => 'completed']);
    }

    /**
     * Helper method to format error response.
     *
     * @param string $message
     * @return array
     */
    private function errorResponse(string $message): array
    {
        return [
            'success' => false,
            'reservation' => null,
            'errors' => [$message],
        ];
    }
}
