<?php

namespace App\Services;

use App\Models\MaintenanceLog;
use App\Models\Material;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MaintenanceService
{
    /**
     * Create a maintenance log.
     *
     * @param array $data
     * @return MaintenanceLog
     */
    public function createMaintenanceLog(array $data): MaintenanceLog
    {
        return DB::transaction(function () use ($data) {
            $log = MaintenanceLog::create([
                'material_id' => $data['material_id'],
                'technician_id' => $data['technician_id'] ?? null,
                'maintenance_type' => $data['maintenance_type'],
                'description' => $data['description'],
                'scheduled_date' => $data['scheduled_date'],
                'completed_date' => $data['completed_date'] ?? null,
                'cost' => $data['cost'] ?? null,
                'notes' => $data['notes'] ?? null,
                'status' => $data['status'] ?? 'scheduled',
            ]);

            // Update material status if maintenance is starting
            if ($log->status === 'in_progress') {
                $material = Material::find($log->material_id);
                if ($material && $material->status === 'available') {
                    $material->update(['status' => 'maintenance']);
                }
            }

            return $log->fresh(['material', 'technician']);
        });
    }

    /**
     * Update a maintenance log.
     *
     * @param MaintenanceLog $log
     * @param array $data
     * @return MaintenanceLog
     */
    public function updateMaintenanceLog(MaintenanceLog $log, array $data): MaintenanceLog
    {
        $log->update([
            'technician_id' => $data['technician_id'] ?? $log->technician_id,
            'maintenance_type' => $data['maintenance_type'] ?? $log->maintenance_type,
            'description' => $data['description'] ?? $log->description,
            'scheduled_date' => $data['scheduled_date'] ?? $log->scheduled_date,
            'completed_date' => $data['completed_date'] ?? $log->completed_date,
            'cost' => $data['cost'] ?? $log->cost,
            'notes' => $data['notes'] ?? $log->notes,
            'status' => $data['status'] ?? $log->status,
        ]);

        return $log->fresh();
    }

    /**
     * Start maintenance (change status to in_progress).
     *
     * @param MaintenanceLog $log
     * @param MaterialService|null $materialService
     * @return MaintenanceLog
     */
    public function startMaintenance(MaintenanceLog $log, ?MaterialService $materialService = null): MaintenanceLog
    {
        $log->update(['status' => 'in_progress']);

        // Update material status to maintenance
        if (!$materialService) {
            $materialService = app(MaterialService::class);
        }

        $material = $log->material;
        if ($material->status !== 'maintenance') {
            $materialService->changeStatus($material, 'maintenance');
        }

        return $log->fresh();
    }

    /**
     * Complete maintenance.
     *
     * @param MaintenanceLog $log
     * @param array $data
     * @return MaintenanceLog
     */
    public function completeMaintenance(MaintenanceLog $log, array $data = []): MaintenanceLog
    {
        DB::transaction(function () use ($log, $data) {
            // Update maintenance log
            $log->update([
                'status' => 'completed',
                'completed_date' => $data['completed_date'] ?? now(),
                'cost' => $data['cost'] ?? $log->cost,
                'notes' => $data['notes'] ?? $log->notes,
            ]);

            // Update material: set last_maintenance_date and status back to available
            $material = $log->material;
            $material->update([
                'last_maintenance_date' => $log->completed_date,
                'status' => 'available',
            ]);
        });

        return $log->fresh();
    }

    /**
     * Cancel maintenance.
     *
     * @param MaintenanceLog $log
     * @return MaintenanceLog
     */
    public function cancelMaintenance(MaintenanceLog $log): MaintenanceLog
    {
        DB::transaction(function () use ($log) {
            $log->update(['status' => 'cancelled']);

            // If material is in maintenance, set it back to available
            $material = $log->material;
            if ($material->status === 'maintenance') {
                // Check if there are other active maintenance logs
                $otherActiveMaintenance = MaintenanceLog::where('material_id', $material->id)
                    ->where('id', '!=', $log->id)
                    ->whereIn('status', ['scheduled', 'in_progress'])
                    ->exists();

                if (!$otherActiveMaintenance) {
                    $material->update(['status' => 'available']);
                }
            }
        });

        return $log->fresh();
    }

    /**
     * Delete a maintenance log.
     *
     * @param MaintenanceLog $log
     * @return bool
     * @throws \Exception
     */
    public function deleteMaintenanceLog(MaintenanceLog $log): bool
    {
        // Cannot delete completed maintenance logs (for audit trail)
        if ($log->status === 'completed') {
            throw new \Exception('Cannot delete completed maintenance logs');
        }

        return $log->delete();
    }

    /**
     * Assign technician to maintenance.
     *
     * @param MaintenanceLog $log
     * @param User $technician
     * @return MaintenanceLog
     */
    public function assignTechnician(MaintenanceLog $log, User $technician): MaintenanceLog
    {
        $log->update(['technician_id' => $technician->id]);
        return $log->fresh();
    }

    /**
     * Get scheduled maintenance for a material.
     *
     * @param Material $material
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getMaterialMaintenance(Material $material)
    {
        return MaintenanceLog::where('material_id', $material->id)
            ->with('technician')
            ->orderBy('scheduled_date', 'desc')
            ->get();
    }

    /**
     * Get upcoming scheduled maintenance.
     *
     * @param int $days
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getUpcomingMaintenance(int $days = 30)
    {
        $endDate = now()->addDays($days);

        return MaintenanceLog::scheduled()
            ->whereBetween('scheduled_date', [now(), $endDate])
            ->with('material', 'technician')
            ->orderBy('scheduled_date')
            ->get();
    }

    /**
     * Get overdue maintenance.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getOverdueMaintenance()
    {
        return MaintenanceLog::whereIn('status', ['scheduled', 'in_progress'])
            ->where('scheduled_date', '<', now())
            ->with('material', 'technician')
            ->orderBy('scheduled_date')
            ->get();
    }

    /**
     * Get maintenance logs for a technician.
     *
     * @param User $technician
     * @param string|null $status
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getTechnicianMaintenance(User $technician, ?string $status = null)
    {
        $query = MaintenanceLog::where('technician_id', $technician->id)
            ->with('material');

        if ($status) {
            $query->where('status', $status);
        }

        return $query->orderBy('scheduled_date', 'desc')->get();
    }

    /**
     * Get maintenance statistics.
     *
     * @param Carbon|null $startDate
     * @param Carbon|null $endDate
     * @return array
     */
    public function getMaintenanceStatistics(?Carbon $startDate = null, ?Carbon $endDate = null): array
    {
        $startDate = $startDate ?? now()->subMonths(6);
        $endDate = $endDate ?? now();

        $query = MaintenanceLog::whereBetween('scheduled_date', [$startDate, $endDate]);

        $total = $query->count();
        $completed = (clone $query)->completed()->count();
        $inProgress = (clone $query)->inProgress()->count();
        $scheduled = (clone $query)->scheduled()->count();
        $overdue = (clone $query)->whereIn('status', ['scheduled', 'in_progress'])
            ->where('scheduled_date', '<', now())
            ->count();

        $totalCost = MaintenanceLog::completed()
            ->whereBetween('completed_date', [$startDate, $endDate])
            ->sum('cost');

        $averageCost = MaintenanceLog::completed()
            ->whereBetween('completed_date', [$startDate, $endDate])
            ->avg('cost');

        return [
            'total_maintenance' => $total,
            'completed' => $completed,
            'in_progress' => $inProgress,
            'scheduled' => $scheduled,
            'overdue' => $overdue,
            'total_cost' => $totalCost,
            'average_cost' => round($averageCost, 2),
            'completion_rate' => $total > 0 ? round(($completed / $total) * 100, 2) : 0,
        ];
    }

    /**
     * Auto-schedule maintenance based on material maintenance_schedule.
     *
     * @param Material $material
     * @return MaintenanceLog|null
     */
    public function autoScheduleMaintenance(Material $material): ?MaintenanceLog
    {
        if (!$material->maintenance_schedule) {
            return null;
        }

        $lastDate = $material->last_maintenance_date ?? now();
        $nextDate = $this->calculateNextMaintenanceDate($lastDate, $material->maintenance_schedule);

        // Check if maintenance already scheduled
        $existingSchedule = MaintenanceLog::where('material_id', $material->id)
            ->whereIn('status', ['scheduled', 'in_progress'])
            ->where('scheduled_date', '>=', $nextDate->subDays(7)) // Within 7 days
            ->exists();

        if ($existingSchedule) {
            return null;
        }

        return $this->createMaintenanceLog([
            'material_id' => $material->id,
            'maintenance_type' => 'preventive',
            'description' => 'Auto-scheduled ' . $material->maintenance_schedule . ' maintenance',
            'scheduled_date' => $nextDate,
            'status' => 'scheduled',
        ]);
    }

    /**
     * Calculate next maintenance date based on schedule.
     *
     * @param Carbon $lastDate
     * @param string $schedule
     * @return Carbon
     */
    private function calculateNextMaintenanceDate(Carbon $lastDate, string $schedule): Carbon
    {
        return match ($schedule) {
            'weekly' => $lastDate->copy()->addWeek(),
            'monthly' => $lastDate->copy()->addMonth(),
            'quarterly' => $lastDate->copy()->addMonths(3),
            'yearly' => $lastDate->copy()->addYear(),
            default => $lastDate->copy()->addMonth(),
        };
    }
}
