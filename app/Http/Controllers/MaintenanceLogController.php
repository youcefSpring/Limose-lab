<?php

namespace App\Http\Controllers;

use App\Models\MaintenanceLog;
use App\Models\Material;
use App\Models\User;
use Illuminate\Http\Request;

class MaintenanceLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = MaintenanceLog::with(['material', 'technician']);

        // Search functionality
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                  ->orWhere('notes', 'like', "%{$search}%")
                  ->orWhereHas('material', function ($mq) use ($search) {
                      $mq->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Filter by maintenance type
        if ($request->has('type') && $request->type !== '') {
            $query->where('maintenance_type', $request->type);
        }

        // Filter by material
        if ($request->has('material') && $request->material !== '') {
            $query->where('material_id', $request->material);
        }

        // Filter by technician
        if ($request->has('technician') && $request->technician !== '') {
            $query->where('technician_id', $request->technician);
        }

        $logs = $query->latest('scheduled_date')->paginate(12);

        return view('maintenance.index', compact('logs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $materials = Material::orderBy('name')->get();
        $technicians = User::role('technician')->orderBy('name')->get();

        return view('maintenance.create', compact('materials', 'technicians'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'material_id' => 'required|exists:materials,id',
            'technician_id' => 'nullable|exists:users,id',
            'maintenance_type' => 'required|in:preventive,corrective,inspection,calibration',
            'description' => 'required|string',
            'scheduled_date' => 'required|date',
            'completed_date' => 'nullable|date|after_or_equal:scheduled_date',
            'cost' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'status' => 'required|in:scheduled,in_progress,completed,cancelled',
        ]);

        MaintenanceLog::create($validated);

        // Update material status if maintenance is scheduled
        if ($validated['status'] === 'scheduled' || $validated['status'] === 'in_progress') {
            $material = Material::find($validated['material_id']);
            $material->update(['status' => 'maintenance']);
        }

        return redirect()->route('maintenance.index')->with('success', __('Maintenance log created successfully.'));
    }

    /**
     * Display the specified resource.
     */
    public function show(MaintenanceLog $maintenance)
    {
        $log = $maintenance->load(['material', 'technician']);
        return view('maintenance.show', compact('log'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MaintenanceLog $maintenance)
    {
        $log = $maintenance;
        $materials = Material::orderBy('name')->get();
        $technicians = User::role('technician')->orderBy('name')->get();

        return view('maintenance.edit', compact('log', 'materials', 'technicians'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MaintenanceLog $maintenance)
    {
        $validated = $request->validate([
            'material_id' => 'required|exists:materials,id',
            'technician_id' => 'nullable|exists:users,id',
            'maintenance_type' => 'required|in:preventive,corrective,inspection,calibration',
            'description' => 'required|string',
            'scheduled_date' => 'required|date',
            'completed_date' => 'nullable|date|after_or_equal:scheduled_date',
            'cost' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'status' => 'required|in:scheduled,in_progress,completed,cancelled',
        ]);

        $maintenance->update($validated);

        // Update material status based on maintenance status
        $material = Material::find($validated['material_id']);
        if ($validated['status'] === 'completed' || $validated['status'] === 'cancelled') {
            // Check if there are other ongoing maintenances for this material
            $hasOtherMaintenance = MaintenanceLog::where('material_id', $material->id)
                ->where('id', '!=', $maintenance->id)
                ->whereIn('status', ['scheduled', 'in_progress'])
                ->exists();

            if (!$hasOtherMaintenance) {
                $material->update(['status' => 'available']);
            }
        } elseif ($validated['status'] === 'scheduled' || $validated['status'] === 'in_progress') {
            $material->update(['status' => 'maintenance']);
        }

        return redirect()->route('maintenance.show', $maintenance)->with('success', __('Maintenance log updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MaintenanceLog $maintenance)
    {
        $materialId = $maintenance->material_id;
        $maintenance->delete();

        // Update material status if no other maintenances exist
        $hasOtherMaintenance = MaintenanceLog::where('material_id', $materialId)
            ->whereIn('status', ['scheduled', 'in_progress'])
            ->exists();

        if (!$hasOtherMaintenance) {
            Material::find($materialId)->update(['status' => 'available']);
        }

        return redirect()->route('maintenance.index')->with('success', __('Maintenance log deleted successfully.'));
    }

    /**
     * Start maintenance.
     */
    public function start(MaintenanceLog $maintenance)
    {
        if ($maintenance->status !== 'scheduled') {
            return redirect()->back()->with('error', __('Only scheduled maintenance can be started.'));
        }

        $maintenance->update(['status' => 'in_progress']);

        // Update material status
        $maintenance->material->update(['status' => 'maintenance']);

        return redirect()->back()->with('success', __('Maintenance started successfully.'));
    }

    /**
     * Complete maintenance.
     */
    public function complete(Request $request, MaintenanceLog $maintenance)
    {
        if ($maintenance->status === 'completed') {
            return redirect()->back()->with('error', __('This maintenance is already completed.'));
        }

        $validated = $request->validate([
            'completed_date' => 'required|date',
            'cost' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $maintenance->update([
            'status' => 'completed',
            'completed_date' => $validated['completed_date'],
            'cost' => $validated['cost'] ?? $maintenance->cost,
            'notes' => $validated['notes'] ?? $maintenance->notes,
        ]);

        // Update material status if no other ongoing maintenances
        $hasOtherMaintenance = MaintenanceLog::where('material_id', $maintenance->material_id)
            ->where('id', '!=', $maintenance->id)
            ->whereIn('status', ['scheduled', 'in_progress'])
            ->exists();

        if (!$hasOtherMaintenance) {
            $maintenance->material->update(['status' => 'available']);
        }

        return redirect()->back()->with('success', __('Maintenance completed successfully.'));
    }

    /**
     * Cancel maintenance.
     */
    public function cancel(Request $request, MaintenanceLog $maintenance)
    {
        if ($maintenance->status === 'completed') {
            return redirect()->back()->with('error', __('Completed maintenance cannot be cancelled.'));
        }

        $validated = $request->validate([
            'notes' => 'required|string|max:500',
        ]);

        $maintenance->update([
            'status' => 'cancelled',
            'notes' => ($maintenance->notes ? $maintenance->notes . "\n\n" : '') . 'Cancellation reason: ' . $validated['notes'],
        ]);

        // Update material status if no other ongoing maintenances
        $hasOtherMaintenance = MaintenanceLog::where('material_id', $maintenance->material_id)
            ->where('id', '!=', $maintenance->id)
            ->whereIn('status', ['scheduled', 'in_progress'])
            ->exists();

        if (!$hasOtherMaintenance) {
            $maintenance->material->update(['status' => 'available']);
        }

        return redirect()->back()->with('success', __('Maintenance cancelled successfully.'));
    }

    /**
     * Show calendar view of scheduled maintenances.
     */
    public function calendar()
    {
        $maintenances = MaintenanceLog::with(['material', 'technician'])
            ->whereIn('status', ['scheduled', 'in_progress'])
            ->get();

        return view('maintenance.calendar', compact('maintenances'));
    }
}
