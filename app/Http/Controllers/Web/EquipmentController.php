<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\EquipmentController as ApiEquipmentController;
use App\Http\Requests\Equipment\StoreEquipmentRequest;
use App\Http\Requests\Equipment\UpdateEquipmentRequest;
use App\Models\Equipment;
use App\Services\EquipmentService;
use App\Services\ResearcherService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class EquipmentController extends Controller
{
    public function __construct(
        private EquipmentService $equipmentService,
        private ResearcherService $researcherService,
        private ApiEquipmentController $apiController
    ) {
        $this->middleware('auth');
    }

    /**
     * Display a listing of equipment
     */
    public function index(Request $request): View
    {
        $filters = $request->only([
            'search', 'type', 'status', 'location', 'available_from', 'available_to'
        ]);
        $perPage = min($request->input('per_page', 15), 100);

        $equipment = $this->equipmentService->getEquipment($filters, $perPage);

        return view('equipment.index', compact('equipment', 'filters'));
    }

    /**
     * Show the form for creating new equipment
     */
    public function create(): View
    {
        $this->authorize('create', Equipment::class);

        return view('equipment.create');
    }

    /**
     * Store newly created equipment
     */
    public function store(StoreEquipmentRequest $request): RedirectResponse
    {
        $this->authorize('create', Equipment::class);

        try {
            $equipment = $this->equipmentService->createEquipment($request->validated());

            return redirect()
                ->route('equipment.show', $equipment)
                ->with('success', 'Equipment created successfully.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Failed to create equipment: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified equipment
     */
    public function show(Equipment $equipment): View
    {
        $this->authorize('view', $equipment);

        $equipment->load(['reservations.researcher', 'maintenanceRecords']);
        $statistics = $this->equipmentService->getEquipmentStatistics($equipment);

        return view('equipment.show', compact('equipment', 'statistics'));
    }

    /**
     * Show the form for editing the specified equipment
     */
    public function edit(Equipment $equipment): View
    {
        $this->authorize('update', $equipment);

        return view('equipment.edit', compact('equipment'));
    }

    /**
     * Update the specified equipment
     */
    public function update(UpdateEquipmentRequest $request, Equipment $equipment): RedirectResponse
    {
        $this->authorize('update', $equipment);

        try {
            $updatedEquipment = $this->equipmentService->updateEquipment($equipment, $request->validated());

            return redirect()
                ->route('equipment.show', $updatedEquipment)
                ->with('success', 'Equipment updated successfully.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Failed to update equipment: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified equipment
     */
    public function destroy(Equipment $equipment): RedirectResponse
    {
        $this->authorize('delete', $equipment);

        try {
            $this->equipmentService->deleteEquipment($equipment);

            return redirect()
                ->route('equipment.index')
                ->with('success', 'Equipment deleted successfully.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Failed to delete equipment: ' . $e->getMessage());
        }
    }

    /**
     * Display equipment reservations
     */
    public function reservations(Request $request): View
    {
        $filters = $request->only([
            'equipment_id', 'researcher_id', 'status', 'date_from', 'date_to'
        ]);
        $perPage = min($request->input('per_page', 15), 100);

        $reservations = $this->equipmentService->getReservations($filters, $perPage);
        $equipment = $this->equipmentService->getEquipment([], 1000);
        $researchers = $this->researcherService->getResearchers([], 1000);

        return view('equipment.reservations', compact('reservations', 'equipment', 'researchers', 'filters'));
    }

    /**
     * Show equipment reservation form
     */
    public function reserve(Equipment $equipment): View
    {
        $this->authorize('reserve', $equipment);

        return view('equipment.reserve', compact('equipment'));
    }

    /**
     * Store equipment reservation
     */
    public function storeReservation(Request $request, Equipment $equipment): RedirectResponse
    {
        $this->authorize('reserve', $equipment);

        $request->validate([
            'start_datetime' => 'required|date|after:now',
            'end_datetime' => 'required|date|after:start_datetime',
            'purpose' => 'required|string|max:1000',
        ]);

        try {
            $reservation = $this->equipmentService->createReservation($equipment, $request->validated());

            return redirect()
                ->route('equipment.reservations')
                ->with('success', 'Equipment reservation created successfully.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Failed to create reservation: ' . $e->getMessage());
        }
    }

    /**
     * Display equipment maintenance records
     */
    public function maintenance(Equipment $equipment): View
    {
        $this->authorize('view', $equipment);

        $maintenanceRecords = $this->equipmentService->getMaintenanceRecords($equipment);

        return view('equipment.maintenance', compact('equipment', 'maintenanceRecords'));
    }

    /**
     * Display equipment usage statistics
     */
    public function usage(Equipment $equipment): View
    {
        $this->authorize('view', $equipment);

        $usageStats = $this->equipmentService->getUsageStatistics($equipment);

        return view('equipment.usage', compact('equipment', 'usageStats'));
    }

    /**
     * Display equipment calendar
     */
    public function calendar(Equipment $equipment = null): View
    {
        $equipmentList = $this->equipmentService->getEquipment([], 1000);
        $reservations = $this->equipmentService->getCalendarReservations($equipment);

        return view('equipment.calendar', compact('equipment', 'equipmentList', 'reservations'));
    }

    /**
     * Search equipment (AJAX endpoint)
     */
    public function search(Request $request)
    {
        if ($request->expectsJson()) {
            return $this->apiController->search($request);
        }

        // For non-AJAX requests, redirect to index with search parameters
        return redirect()->route('equipment.index', $request->only([
            'query', 'type', 'status', 'location'
        ]));
    }

    /**
     * Check equipment availability (AJAX endpoint)
     */
    public function checkAvailability(Request $request, Equipment $equipment)
    {
        $request->validate([
            'start_datetime' => 'required|date',
            'end_datetime' => 'required|date|after:start_datetime',
        ]);

        $availability = $this->equipmentService->checkAvailability(
            $equipment,
            $request->start_datetime,
            $request->end_datetime
        );

        return response()->json([
            'available' => $availability['available'],
            'conflicts' => $availability['conflicts'] ?? [],
            'suggestions' => $availability['suggestions'] ?? []
        ]);
    }
}