<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class RoomController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Room::class);

        $rooms = Room::with('roomType')
            ->orderBy('room_number')
            ->paginate(20);

        return view('rooms.index', compact('rooms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Room::class);

        $roomTypes = RoomType::orderBy('name')->get();

        return view('rooms.create', compact('roomTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Room::class);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'room_number' => 'required|string|max:255|unique:rooms,room_number',
            'room_type_id' => 'required|exists:room_types,id',
            'capacity' => 'nullable|integer|min:1',
            'floor' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:available,occupied,maintenance,reserved',
            'equipment' => 'nullable|string',
        ]);

        Room::create($validated);

        return redirect()->route('rooms.index')
            ->with('success', __('Room created successfully!'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Room $room)
    {
        $this->authorize('view', $room);

        $room->load('roomType');

        return view('rooms.show', compact('room'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Room $room)
    {
        $this->authorize('update', $room);

        $roomTypes = RoomType::orderBy('name')->get();

        return view('rooms.edit', compact('room', 'roomTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Room $room)
    {
        $this->authorize('update', $room);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'room_number' => 'required|string|max:255|unique:rooms,room_number,' . $room->id,
            'room_type_id' => 'required|exists:room_types,id',
            'capacity' => 'nullable|integer|min:1',
            'floor' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:available,occupied,maintenance,reserved',
            'equipment' => 'nullable|string',
        ]);

        $room->update($validated);

        return redirect()->route('rooms.index')
            ->with('success', __('Room updated successfully!'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        $this->authorize('delete', $room);

        $room->delete();

        return redirect()->route('rooms.index')
            ->with('success', __('Room deleted successfully!'));
    }
}
