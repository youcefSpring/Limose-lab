<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Equipment\StoreEquipmentRequest;
use App\Http\Requests\Equipment\UpdateEquipmentRequest;
use App\Http\Requests\Equipment\StoreReservationRequest;
use App\Models\Equipment;
use App\Models\EquipmentReservation;
use App\Services\EquipmentService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class EquipmentController extends Controller
{
    public function __construct(
        private EquipmentService $equipmentService
    ) {}

    /**
     * Display a listing of equipment
     * GET /api/v1/equipment
     */
    public function index(Request $request): JsonResponse
    {
        $filters = $request->only(['search', 'category', 'status', 'location']);
        $perPage = min($request->input('per_page', 15), 100);

        $equipment = $this->equipmentService->getEquipment($filters, $perPage);

        return response()->json([
            'status' => 'success',
            'data' => [
                'equipment' => $equipment->items()->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'name' => $item->getName(),
                        'category' => $item->category,
                        'serial_number' => $item->serial_number,
                        'status' => $item->status,
                        'location' => $item->location,
                        'purchase_date' => $item->purchase_date,
                        'warranty_expiry' => $item->warranty_expiry,
                        'maintenance_schedule' => $item->maintenance_schedule,
                        'availability' => $item->isAvailable(),
                        'photo_url' => $item->photo_path ? url("storage/{$item->photo_path}") : null,
                        'created_at' => $item->created_at,
                    ];
                }),
                'pagination' => [
                    'current_page' => $equipment->currentPage(),
                    'total_pages' => $equipment->lastPage(),
                    'total_items' => $equipment->total(),
                    'per_page' => $equipment->perPage(),
                    'has_next_page' => $equipment->hasMorePages(),
                    'has_previous_page' => $equipment->currentPage() > 1,
                ]
            ]
        ]);
    }

    /**
     * Store a newly created equipment
     * POST /api/v1/equipment
     */
    public function store(StoreEquipmentRequest $request): JsonResponse
    {
        $equipment = $this->equipmentService->createEquipment($request->validated());

        return response()->json([
            'status' => 'success',
            'data' => [
                'equipment' => [
                    'id' => $equipment->id,
                    'name' => $equipment->getName(),
                    'category' => $equipment->category,
                    'serial_number' => $equipment->serial_number,
                    'status' => $equipment->status,
                    'location' => $equipment->location,
                    'purchase_date' => $equipment->purchase_date,
                    'warranty_expiry' => $equipment->warranty_expiry,
                    'photo_url' => $equipment->photo_path ? url("storage/{$equipment->photo_path}") : null,
                ]
            ],
            'message' => 'Equipment created successfully'
        ], 201);
    }

    /**
     * Display the specified equipment
     * GET /api/v1/equipment/{id}
     */
    public function show(Equipment $equipment): JsonResponse
    {
        $statistics = $this->equipmentService->getEquipmentStatistics($equipment);

        return response()->json([
            'status' => 'success',
            'data' => [
                'equipment' => [
                    'id' => $equipment->id,
                    'name' => $equipment->getName(),
                    'description' => $equipment->getDescription(),
                    'category' => $equipment->category,
                    'serial_number' => $equipment->serial_number,
                    'status' => $equipment->status,
                    'location' => $equipment->location,
                    'purchase_date' => $equipment->purchase_date,
                    'warranty_expiry' => $equipment->warranty_expiry,
                    'maintenance_schedule' => $equipment->maintenance_schedule,
                    'availability' => $equipment->isAvailable(),
                    'photo_url' => $equipment->photo_path ? url("storage/{$equipment->photo_path}") : null,
                    'manual_url' => $equipment->manual_path ? url("storage/{$equipment->manual_path}") : null,
                    'statistics' => $statistics,
                    'created_at' => $equipment->created_at,
                    'updated_at' => $equipment->updated_at,
                ]
            ]
        ]);
    }

    /**
     * Update the specified equipment
     * PUT /api/v1/equipment/{id}
     */
    public function update(UpdateEquipmentRequest $request, Equipment $equipment): JsonResponse
    {
        $updatedEquipment = $this->equipmentService->updateEquipment($equipment, $request->validated());

        return response()->json([
            'status' => 'success',
            'data' => [
                'equipment' => [
                    'id' => $updatedEquipment->id,
                    'name' => $updatedEquipment->getName(),
                    'category' => $updatedEquipment->category,
                    'status' => $updatedEquipment->status,
                    'location' => $updatedEquipment->location,
                ]
            ],
            'message' => 'Equipment updated successfully'
        ]);
    }

    /**
     * Remove the specified equipment
     * DELETE /api/v1/equipment/{id}
     */
    public function destroy(Equipment $equipment): JsonResponse
    {
        if (!auth()->user()->isAdmin() && !auth()->user()->isLabManager()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Access denied',
                'code' => 'INSUFFICIENT_PERMISSIONS'
            ], 403);
        }

        $this->equipmentService->deleteEquipment($equipment);

        return response()->json([
            'status' => 'success',
            'message' => 'Equipment deleted successfully'
        ]);
    }

    /**
     * Get equipment calendar/schedule
     * GET /api/v1/equipment/{id}/calendar
     */
    public function calendar(Request $request, Equipment $equipment): JsonResponse
    {
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $calendar = $this->equipmentService->getEquipmentCalendar(
            $equipment,
            $request->start_date,
            $request->end_date
        );

        return response()->json([
            'status' => 'success',
            'data' => [
                'calendar' => $calendar->map(function ($reservation) {
                    return [
                        'id' => $reservation->id,
                        'title' => $reservation->getPurpose(),
                        'start_datetime' => $reservation->start_datetime,
                        'end_datetime' => $reservation->end_datetime,
                        'status' => $reservation->status,
                        'researcher' => [
                            'id' => $reservation->researcher->id,
                            'name' => $reservation->researcher->full_name,
                        ],
                        'project' => $reservation->project ? [
                            'id' => $reservation->project->id,
                            'title' => $reservation->project->getTitle(),
                        ] : null,
                    ];
                })
            ]
        ]);
    }

    /**
     * Create equipment reservation
     * POST /api/v1/equipment/{id}/reservations
     */
    public function createReservation(StoreReservationRequest $request, Equipment $equipment): JsonResponse
    {
        $reservationData = $request->validated();
        $reservationData['equipment_id'] = $equipment->id;
        $reservationData['researcher_id'] = auth()->user()->researcher->id;

        $reservation = $this->equipmentService->createReservation($reservationData);

        return response()->json([
            'status' => 'success',
            'data' => [
                'reservation' => [
                    'id' => $reservation->id,
                    'equipment' => [
                        'id' => $reservation->equipment->id,
                        'name' => $reservation->equipment->getName(),
                    ],
                    'start_datetime' => $reservation->start_datetime,
                    'end_datetime' => $reservation->end_datetime,
                    'status' => $reservation->status,
                    'purpose' => $reservation->getPurpose(),
                ]
            ],
            'message' => 'Reservation created successfully'
        ], 201);
    }

    /**
     * Update equipment status
     * PUT /api/v1/equipment/{id}/status
     */
    public function updateStatus(Request $request, Equipment $equipment): JsonResponse
    {
        $request->validate([
            'status' => 'required|in:available,reserved,maintenance,out_of_order',
            'reason' => 'nullable|string|max:500',
        ]);

        if (!auth()->user()->isAdmin() && !auth()->user()->isLabManager()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Access denied',
                'code' => 'INSUFFICIENT_PERMISSIONS'
            ], 403);
        }

        $updatedEquipment = $this->equipmentService->changeEquipmentStatus(
            $equipment,
            $request->status,
            $request->reason
        );

        return response()->json([
            'status' => 'success',
            'data' => [
                'equipment' => [
                    'id' => $updatedEquipment->id,
                    'status' => $updatedEquipment->status,
                ]
            ],
            'message' => 'Equipment status updated successfully'
        ]);
    }

    /**
     * Search equipment
     * GET /api/v1/equipment/search
     */
    public function search(Request $request): JsonResponse
    {
        $request->validate([
            'query' => 'required|string|min:2',
            'category' => 'nullable|string',
            'available_only' => 'nullable|boolean',
        ]);

        $equipment = $this->equipmentService->searchEquipment(
            $request->query,
            $request->only(['category', 'available_only'])
        );

        return response()->json([
            'status' => 'success',
            'data' => [
                'equipment' => $equipment->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'name' => $item->getName(),
                        'category' => $item->category,
                        'status' => $item->status,
                        'location' => $item->location,
                        'availability' => $item->isAvailable(),
                    ];
                })
            ]
        ]);
    }

    /**
     * Get categories
     * GET /api/v1/equipment/categories
     */
    public function categories(): JsonResponse
    {
        $categories = $this->equipmentService->getEquipmentCategories();

        return response()->json([
            'status' => 'success',
            'data' => [
                'categories' => $categories
            ]
        ]);
    }
}

/**
 * Equipment Reservation Controller
 */
class EquipmentReservationController extends Controller
{
    public function __construct(
        private EquipmentService $equipmentService
    ) {}

    /**
     * Get user reservations
     * GET /api/v1/reservations
     */
    public function index(Request $request): JsonResponse
    {
        $filters = $request->only(['status', 'equipment_id', 'start_date', 'end_date']);
        $perPage = min($request->input('per_page', 15), 100);

        $reservations = $this->equipmentService->getUserReservations(
            auth()->user()->researcher,
            $filters,
            $perPage
        );

        return response()->json([
            'status' => 'success',
            'data' => [
                'reservations' => $reservations->items()->map(function ($reservation) {
                    return [
                        'id' => $reservation->id,
                        'equipment' => [
                            'id' => $reservation->equipment->id,
                            'name' => $reservation->equipment->getName(),
                            'location' => $reservation->equipment->location,
                        ],
                        'start_datetime' => $reservation->start_datetime,
                        'end_datetime' => $reservation->end_datetime,
                        'status' => $reservation->status,
                        'purpose' => $reservation->getPurpose(),
                        'notes' => $reservation->notes,
                        'project' => $reservation->project ? [
                            'id' => $reservation->project->id,
                            'title' => $reservation->project->getTitle(),
                        ] : null,
                        'created_at' => $reservation->created_at,
                    ];
                }),
                'pagination' => [
                    'current_page' => $reservations->currentPage(),
                    'total_pages' => $reservations->lastPage(),
                    'total_items' => $reservations->total(),
                    'per_page' => $reservations->perPage(),
                ]
            ]
        ]);
    }

    /**
     * Update reservation
     * PUT /api/v1/reservations/{id}
     */
    public function update(Request $request, EquipmentReservation $reservation): JsonResponse
    {
        // Check authorization
        if (auth()->user()->researcher->id !== $reservation->researcher_id &&
            !auth()->user()->isAdmin() && !auth()->user()->isLabManager()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Access denied',
                'code' => 'INSUFFICIENT_PERMISSIONS'
            ], 403);
        }

        $request->validate([
            'start_datetime' => 'sometimes|required|date|after:now',
            'end_datetime' => 'sometimes|required|date|after:start_datetime',
            'purpose_ar' => 'nullable|string|max:500',
            'purpose_fr' => 'nullable|string|max:500',
            'purpose_en' => 'nullable|string|max:500',
            'notes' => 'nullable|string|max:1000',
        ]);

        $updatedReservation = $this->equipmentService->updateReservation(
            $reservation,
            $request->validated()
        );

        return response()->json([
            'status' => 'success',
            'data' => [
                'reservation' => [
                    'id' => $updatedReservation->id,
                    'start_datetime' => $updatedReservation->start_datetime,
                    'end_datetime' => $updatedReservation->end_datetime,
                    'status' => $updatedReservation->status,
                    'purpose' => $updatedReservation->getPurpose(),
                ]
            ],
            'message' => 'Reservation updated successfully'
        ]);
    }

    /**
     * Cancel reservation
     * DELETE /api/v1/reservations/{id}
     */
    public function destroy(EquipmentReservation $reservation): JsonResponse
    {
        // Check authorization
        if (auth()->user()->researcher->id !== $reservation->researcher_id &&
            !auth()->user()->isAdmin() && !auth()->user()->isLabManager()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Access denied',
                'code' => 'INSUFFICIENT_PERMISSIONS'
            ], 403);
        }

        $this->equipmentService->cancelReservation($reservation);

        return response()->json([
            'status' => 'success',
            'message' => 'Reservation cancelled successfully'
        ]);
    }

    /**
     * Approve reservation (Admin/Lab Manager only)
     * PUT /api/v1/reservations/{id}/approve
     */
    public function approve(EquipmentReservation $reservation): JsonResponse
    {
        if (!auth()->user()->isAdmin() && !auth()->user()->isLabManager()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Access denied',
                'code' => 'INSUFFICIENT_PERMISSIONS'
            ], 403);
        }

        $approvedReservation = $this->equipmentService->approveReservation($reservation);

        return response()->json([
            'status' => 'success',
            'data' => [
                'reservation' => [
                    'id' => $approvedReservation->id,
                    'status' => $approvedReservation->status,
                ]
            ],
            'message' => 'Reservation approved successfully'
        ]);
    }

    /**
     * Reject reservation (Admin/Lab Manager only)
     * PUT /api/v1/reservations/{id}/reject
     */
    public function reject(Request $request, EquipmentReservation $reservation): JsonResponse
    {
        if (!auth()->user()->isAdmin() && !auth()->user()->isLabManager()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Access denied',
                'code' => 'INSUFFICIENT_PERMISSIONS'
            ], 403);
        }

        $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        $rejectedReservation = $this->equipmentService->rejectReservation(
            $reservation,
            $request->reason
        );

        return response()->json([
            'status' => 'success',
            'data' => [
                'reservation' => [
                    'id' => $rejectedReservation->id,
                    'status' => $rejectedReservation->status,
                ]
            ],
            'message' => 'Reservation rejected successfully'
        ]);
    }
}