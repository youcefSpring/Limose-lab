<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Material;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Reservation::with(['user', 'material', 'validator']);

        // Filter by status
        $filter = $request->get('filter');
        if ($filter === 'pending') {
            $query->where('status', 'pending');
        } elseif ($filter === 'approved') {
            $query->where('status', 'approved');
        } elseif ($filter === 'rejected') {
            $query->where('status', 'rejected');
        } elseif ($filter === 'completed') {
            $query->where('status', 'completed');
        } elseif ($filter === 'cancelled') {
            $query->where('status', 'cancelled');
        } elseif ($filter === 'my') {
            $query->where('user_id', auth()->id());
        }

        // Search functionality
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($uq) use ($search) {
                    $uq->where('name', 'like', "%{$search}%");
                })->orWhereHas('material', function ($mq) use ($search) {
                    $mq->where('name', 'like', "%{$search}%");
                })->orWhere('purpose', 'like', "%{$search}%");
            });
        }

        $reservations = $query->latest()->paginate(20);

        return view('reservations.index', compact('reservations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $materials = Material::where('status', 'available')
            ->where('quantity', '>', 0)
            ->orderBy('name')
            ->get();

        // Get all users for admin to select from
        $users = \App\Models\User::orderBy('name')->get();

        return view('reservations.create', compact('materials', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'material_id' => 'required|exists:materials,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'quantity' => 'required|integer|min:1',
            'purpose' => 'required|string|max:1000',
            'notes' => 'nullable|string',
        ]);

        // Check material availability
        $material = Material::findOrFail($validated['material_id']);
        if ($material->quantity < $validated['quantity']) {
            return redirect()->back()
                ->withInput()
                ->with('error', __('The requested quantity is not available. Available: :count', ['count' => $material->quantity]));
        }

        // Check for conflicting reservations
        $hasConflict = Reservation::where('material_id', $validated['material_id'])
            ->whereIn('status', ['pending', 'approved'])
            ->where(function ($query) use ($validated) {
                $query->whereBetween('start_date', [$validated['start_date'], $validated['end_date']])
                    ->orWhereBetween('end_date', [$validated['start_date'], $validated['end_date']])
                    ->orWhere(function ($q) use ($validated) {
                        $q->where('start_date', '<=', $validated['start_date'])
                          ->where('end_date', '>=', $validated['end_date']);
                    });
            })
            ->sum('quantity');

        if (($hasConflict + $validated['quantity']) > $material->quantity) {
            return redirect()->back()
                ->withInput()
                ->with('error', __('The material is already reserved for this period. Available: :count', ['count' => $material->quantity - $hasConflict]));
        }

        // Determine user_id: Admin can select user, regular users create for themselves
        if (auth()->user()->hasRole('admin') && isset($validated['user_id'])) {
            $validated['user_id'] = $validated['user_id'];
        } else {
            $validated['user_id'] = auth()->id();
        }

        $validated['status'] = 'pending';

        Reservation::create($validated);

        return redirect()->route('reservations.index')->with('success', __('Reservation created successfully and is pending approval.'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Reservation $reservation)
    {
        $reservation->load(['user', 'material', 'validator']);
        return view('reservations.show', compact('reservation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reservation $reservation)
    {
        // Only allow editing of own pending reservations
        if ($reservation->user_id !== auth()->id() || $reservation->status !== 'pending') {
            return redirect()->route('reservations.index')
                ->with('error', __('You cannot edit this reservation.'));
        }

        $materials = Material::where('status', 'available')
            ->where('quantity', '>', 0)
            ->orderBy('name')
            ->get();

        return view('reservations.edit', compact('reservation', 'materials'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reservation $reservation)
    {
        // Only allow updating of own pending reservations
        if ($reservation->user_id !== auth()->id() || $reservation->status !== 'pending') {
            return redirect()->route('reservations.index')
                ->with('error', __('You cannot update this reservation.'));
        }

        $validated = $request->validate([
            'material_id' => 'required|exists:materials,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'quantity' => 'required|integer|min:1',
            'purpose' => 'required|string|max:1000',
            'notes' => 'nullable|string',
        ]);

        // Check material availability
        $material = Material::findOrFail($validated['material_id']);
        if ($material->quantity < $validated['quantity']) {
            return redirect()->back()
                ->withInput()
                ->with('error', __('The requested quantity is not available. Available: :count', ['count' => $material->quantity]));
        }

        // Check for conflicting reservations (excluding current reservation)
        $hasConflict = Reservation::where('material_id', $validated['material_id'])
            ->where('id', '!=', $reservation->id)
            ->whereIn('status', ['pending', 'approved'])
            ->where(function ($query) use ($validated) {
                $query->whereBetween('start_date', [$validated['start_date'], $validated['end_date']])
                    ->orWhereBetween('end_date', [$validated['start_date'], $validated['end_date']])
                    ->orWhere(function ($q) use ($validated) {
                        $q->where('start_date', '<=', $validated['start_date'])
                          ->where('end_date', '>=', $validated['end_date']);
                    });
            })
            ->sum('quantity');

        if (($hasConflict + $validated['quantity']) > $material->quantity) {
            return redirect()->back()
                ->withInput()
                ->with('error', __('The material is already reserved for this period. Available: :count', ['count' => $material->quantity - $hasConflict]));
        }

        $reservation->update($validated);

        return redirect()->route('reservations.show', $reservation)->with('success', __('Reservation updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservation $reservation)
    {
        // Only allow deleting own reservations
        if ($reservation->user_id !== auth()->id()) {
            return redirect()->route('reservations.index')
                ->with('error', __('You cannot delete this reservation.'));
        }

        $reservation->delete();

        return redirect()->route('reservations.index')->with('success', __('Reservation deleted successfully.'));
    }

    /**
     * Approve a reservation.
     */
    public function approve(Reservation $reservation)
    {
        if ($reservation->status !== 'pending') {
            return redirect()->back()->with('error', __('Only pending reservations can be approved.'));
        }

        $reservation->update([
            'status' => 'approved',
            'validated_by' => auth()->id(),
            'validated_at' => now(),
        ]);

        return redirect()->back()->with('success', __('Reservation approved successfully.'));
    }

    /**
     * Reject a reservation.
     */
    public function reject(Request $request, Reservation $reservation)
    {
        if ($reservation->status !== 'pending') {
            return redirect()->back()->with('error', __('Only pending reservations can be rejected.'));
        }

        $validated = $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $reservation->update([
            'status' => 'rejected',
            'validated_by' => auth()->id(),
            'validated_at' => now(),
            'rejection_reason' => $validated['rejection_reason'],
        ]);

        return redirect()->back()->with('success', __('Reservation rejected.'));
    }

    /**
     * Cancel a reservation.
     */
    public function cancel(Reservation $reservation)
    {
        // Only allow cancelling own reservations
        if ($reservation->user_id !== auth()->id()) {
            return redirect()->back()->with('error', __('You cannot cancel this reservation.'));
        }

        if (!$reservation->canBeCancelled()) {
            return redirect()->back()->with('error', __('This reservation cannot be cancelled.'));
        }

        $reservation->update(['status' => 'cancelled']);

        return redirect()->back()->with('success', __('Reservation cancelled successfully.'));
    }

    /**
     * Complete a reservation.
     */
    public function complete(Reservation $reservation)
    {
        if ($reservation->status !== 'approved') {
            return redirect()->back()->with('error', __('Only approved reservations can be completed.'));
        }

        $reservation->update(['status' => 'completed']);

        return redirect()->back()->with('success', __('Reservation marked as completed.'));
    }

    /**
     * Check material availability for given dates and quantity.
     */
    public function checkAvailability(Request $request)
    {
        $validated = $request->validate([
            'material_id' => 'required|exists:materials,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'quantity' => 'required|integer|min:1',
        ]);

        $material = Material::findOrFail($validated['material_id']);

        // Check if material has enough total quantity
        if ($material->quantity < $validated['quantity']) {
            return response()->json([
                'available' => false,
                'message' => __('The requested quantity is not available. Available: :count', ['count' => $material->quantity])
            ]);
        }

        // Check for conflicting reservations
        $reservedQuantity = Reservation::where('material_id', $validated['material_id'])
            ->whereIn('status', ['pending', 'approved'])
            ->where(function ($query) use ($validated) {
                $query->whereBetween('start_date', [$validated['start_date'], $validated['end_date']])
                    ->orWhereBetween('end_date', [$validated['start_date'], $validated['end_date']])
                    ->orWhere(function ($q) use ($validated) {
                        $q->where('start_date', '<=', $validated['start_date'])
                          ->where('end_date', '>=', $validated['end_date']);
                    });
            })
            ->sum('quantity');

        $availableQuantity = $material->quantity - $reservedQuantity;

        if ($validated['quantity'] <= $availableQuantity) {
            return response()->json([
                'available' => true,
                'message' => __(':count units available for the selected dates.', ['count' => $availableQuantity])
            ]);
        }

        return response()->json([
            'available' => false,
            'message' => __('Only :count units available for the selected dates.', ['count' => $availableQuantity])
        ]);
    }

    /**
     * Show calendar view of reservations.
     */
    public function calendar()
    {
        return view('reservations.calendar');
    }

    /**
     * Get calendar data in JSON format for FullCalendar.
     */
    public function calendarData()
    {
        $reservations = Reservation::with(['user', 'material'])
            ->whereIn('status', ['pending', 'approved', 'completed'])
            ->get();

        $events = $reservations->map(function ($reservation) {
            // Determine event color based on status
            $color = '#3B82F6';
            switch ($reservation->status) {
                case 'pending':
                    $color = '#f59e0b'; // amber
                    break;
                case 'approved':
                    $color = '#10b981'; // emerald
                    break;
                case 'completed':
                    $color = '#06b6d4'; // cyan
                    break;
                case 'rejected':
                case 'cancelled':
                    $color = '#f43f5e'; // rose
                    break;
            }

            return [
                'id' => $reservation->id,
                'title' => $reservation->material->name . ' - ' . $reservation->user->name,
                'start' => $reservation->start_date->format('Y-m-d'),
                'end' => $reservation->end_date->copy()->addDay()->format('Y-m-d'), // FullCalendar end date is exclusive
                'backgroundColor' => $color,
                'borderColor' => $color,
                'extendedProps' => [
                    'status' => $reservation->status,
                    'quantity' => $reservation->quantity,
                    'purpose' => $reservation->purpose,
                    'user' => $reservation->user->name,
                    'material' => $reservation->material->name,
                ]
            ];
        });

        return response()->json($events);
    }
}
