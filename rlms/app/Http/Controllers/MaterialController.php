<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Material::query();

        // Search functionality
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('serial_number', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Filter by category
        if ($request->has('category') && $request->category !== '') {
            $query->where('category_id', $request->category);
        }

        $materials = $query->with('category')->paginate(12);
        $categories = \App\Models\MaterialCategory::orderBy('name')->get();

        return view('materials.index', compact('materials', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('materials.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:material_categories,id',
            'quantity' => 'required|integer|min:0',
            'min_quantity' => 'nullable|integer|min:0',
            'status' => 'required|in:available,maintenance,retired',
            'location' => 'nullable|string|max:255',
            'serial_number' => 'nullable|string|max:255|unique:materials',
            'purchase_date' => 'nullable|date',
            'maintenance_schedule' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('materials', 'public');
        }

        Material::create($validated);

        return redirect()->route('materials.index')->with('success', __('Material created successfully.'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Material $material)
    {
        $material->load('category');
        return view('materials.show', compact('material'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Material $material)
    {
        return view('materials.edit', compact('material'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Material $material)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:material_categories,id',
            'quantity' => 'required|integer|min:0',
            'min_quantity' => 'nullable|integer|min:0',
            'status' => 'required|in:available,maintenance,retired',
            'location' => 'nullable|string|max:255',
            'serial_number' => 'nullable|string|max:255|unique:materials,serial_number,' . $material->id,
            'purchase_date' => 'nullable|date',
            'maintenance_schedule' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($material->image) {
                \Storage::disk('public')->delete($material->image);
            }
            $validated['image'] = $request->file('image')->store('materials', 'public');
        }

        $material->update($validated);

        return redirect()->route('materials.show', $material)->with('success', __('Material updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Material $material)
    {
        // Delete image if exists
        if ($material->image) {
            \Storage::disk('public')->delete($material->image);
        }

        $material->delete();

        return redirect()->route('materials.index')->with('success', __('Material deleted successfully.'));
    }
}
