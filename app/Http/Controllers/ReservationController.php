<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReservationController extends Controller
{
    public function index(Request $request): View
    {
        $query = Reservation::with(['user', 'material', 'validator']);

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

        if ($request->filled('search')) {
            $search = $request->search;
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

    public function create(): View
    {
        $materials = Material::where('status', 'available')
            ->where('quantity', '>', 0)
            ->orderBy('name')
            ->get();

        $users = User::orderBy('name')->get();

        return view('reservations.create', compact('materials', 'users'));
    }

    public function store(Request $request): RedirectResponse
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

        $material = Material::findOrFail($validated['material_id']);

        if (! $this->isAvailable($material, $validated)) {
            return redirect()->back()
                ->withInput()
                ->with('error', __('The requested quantity is not available.'));
        }

        if (auth()->user()->hasRole('admin') && ! empty($validated['user_id'])) {
            $validated['user_id'] = $validated['user_id'];
        } else {
            $validated['user_id'] = auth()->id();
        }

        $validated['status'] = 'pending';

        Reservation::create($validated);

        return redirect()->route('reservations.index')
            ->with('success', __('Reservation created successfully and is pending approval.'));
    }

    public function show(Reservation $reservation): View
    {
        $reservation->load(['user', 'material', 'validator']);

        return view('reservations.show', compact('reservation'));
    }

    public function edit(Reservation $reservation): View
    {
        if (! $this->canUserEdit($reservation)) {
            return redirect()->route('reservations.index')
                ->with('error', __('You cannot edit this reservation.'));
        }

        $materials = Material::where('status', 'available')
            ->where('quantity', '>', 0)
            ->orderBy('name')
            ->get();

        return view('reservations.edit', compact('reservation', 'materials'));
    }

    public function update(Request $request, Reservation $reservation): RedirectResponse
    {
        if (! $this->canUserEdit($reservation)) {
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

        $material = Material::findOrFail($validated['material_id']);

        if (! $this->isAvailable($material, $validated, $reservation->id)) {
            return redirect()->back()
                ->withInput()
                ->with('error', __('The requested quantity is not available.'));
        }

        $reservation->update($validated);

        return redirect()->route('reservations.show', $reservation)
            ->with('success', __('Reservation updated successfully.'));
    }

    public function destroy(Reservation $reservation): RedirectResponse
    {
        if ($reservation->user_id !== auth()->id()) {
            return redirect()->route('reservations.index')
                ->with('error', __('You cannot delete this reservation.'));
        }

        $reservation->delete();

        return redirect()->route('reservations.index')
            ->with('success', __('Reservation deleted successfully.'));
    }

    public function approve(Reservation $reservation): RedirectResponse
    {
        if (! $this->canUserApproveReject($reservation)) {
            return redirect()->back()->with('error', __('Only pending reservations can be approved.'));
        }

        $reservation->update([
            'status' => 'approved',
            'validated_by' => auth()->id(),
            'validated_at' => now(),
        ]);

        return redirect()->back()->with('success', __('Reservation approved successfully.'));
    }

    public function reject(Request $request, Reservation $reservation): RedirectResponse
    {
        if (! $this->canUserApproveReject($reservation)) {
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

    public function cancel(Reservation $reservation): RedirectResponse
    {
        if ($reservation->user_id !== auth()->id()) {
            return redirect()->back()->with('error', __('You cannot cancel this reservation.'));
        }

        if (! $reservation->canBeCancelled()) {
            return redirect()->back()->with('error', __('This reservation cannot be cancelled.'));
        }

        $reservation->update(['status' => 'cancelled']);

        return redirect()->back()->with('success', __('Reservation cancelled successfully.'));
    }

    public function complete(Reservation $reservation): RedirectResponse
    {
        if (! $this->canUserApproveReject($reservation)) {
            return redirect()->back()->with('error', __('Only approved reservations can be completed.'));
        }

        $reservation->update(['status' => 'completed']);

        return redirect()->back()->with('success', __('Reservation marked as completed.'));
    }

    public function checkAvailability(Request $request)
    {
        $validated = $request->validate([
            'material_id' => 'required|exists:materials,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'quantity' => 'required|integer|min:1',
        ]);

        $material = Material::findOrFail($validated['material_id']);

        if ($material->quantity < $validated['quantity']) {
            return response()->json([
                'available' => false,
                'message' => __('The requested quantity is not available. Available: :count', ['count' => $material->quantity]),
            ]);
        }

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
                'message' => __(':count units available for the selected dates.', ['count' => $availableQuantity]),
            ]);
        }

        return response()->json([
            'available' => false,
            'message' => __('Only :count units available for the selected dates.', ['count' => $availableQuantity]),
        ]);
    }

    public function calendar(): View
    {
        return view('reservations.calendar');
    }

    public function calendarData()
    {
        $reservations = Reservation::with(['user', 'material'])
            ->whereIn('status', ['pending', 'approved', 'completed'])
            ->get();

        $events = $reservations->map(function ($reservation) {
            $color = match ($reservation->status) {
                'pending' => '#f59e0b',
                'approved' => '#10b981',
                'completed' => '#06b6d4',
                default => '#f43f5e',
            };

            return [
                'id' => $reservation->id,
                'title' => $reservation->material->name.' - '.$reservation->user->name,
                'start' => $reservation->start_date->format('Y-m-d'),
                'end' => $reservation->end_date->copy()->addDay()->format('Y-m-d'),
                'backgroundColor' => $color,
                'borderColor' => $color,
                'extendedProps' => [
                    'status' => $reservation->status,
                    'quantity' => $reservation->quantity,
                    'purpose' => $reservation->purpose,
                    'user' => $reservation->user->name,
                    'material' => $reservation->material->name,
                ],
            ];
        });

        return response()->json($events);
    }

    private function canUserEdit(Reservation $reservation): bool
    {
        return $reservation->user_id === auth()->id() && $reservation->status === 'pending';
    }

    private function canUserApproveReject(Reservation $reservation): bool
    {
        return $reservation->status === 'pending' && auth()->user()->hasRole('admin');
    }

    private function isAvailable(Material $material, array $data, ?int $excludeId = null): bool
    {
        $query = Reservation::where('material_id', $material->id)
            ->whereIn('status', ['pending', 'approved'])
            ->where(function ($query) use ($data) {
                $query->whereBetween('start_date', [$data['start_date'], $data['end_date']])
                    ->orWhereBetween('end_date', [$data['start_date'], $data['end_date']])
                    ->orWhere(function ($q) use ($data) {
                        $q->where('start_date', '<=', $data['start_date'])
                            ->where('end_date', '>=', $data['end_date']);
                    });
            });

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        $reservedQuantity = $query->sum('quantity');

        return ($reservedQuantity + $data['quantity']) <= $material->quantity;
    }
}
