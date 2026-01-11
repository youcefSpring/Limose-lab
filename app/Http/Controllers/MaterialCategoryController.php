<?php

namespace App\Http\Controllers;

use App\Models\MaterialCategory;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class MaterialCategoryController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('manage', MaterialCategory::class);

        $categories = MaterialCategory::withCount('materials')
            ->orderBy('name')
            ->paginate(20);

        return view('material-categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('manage', MaterialCategory::class);

        return view('material-categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('manage', MaterialCategory::class);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:material_categories,name',
            'description' => 'nullable|string|max:1000',
        ]);

        MaterialCategory::create($validated);

        return redirect()->route('material-categories.index')
            ->with('success', __('Category created successfully!'));
    }

    /**
     * Display the specified resource.
     */
    public function show(MaterialCategory $materialCategory)
    {
        $this->authorize('manage', MaterialCategory::class);

        $materialCategory->load(['materials' => function ($query) {
            $query->latest()->limit(10);
        }]);

        return view('material-categories.show', compact('materialCategory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MaterialCategory $materialCategory)
    {
        $this->authorize('manage', MaterialCategory::class);

        return view('material-categories.edit', compact('materialCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MaterialCategory $materialCategory)
    {
        $this->authorize('manage', MaterialCategory::class);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:material_categories,name,' . $materialCategory->id,
            'description' => 'nullable|string|max:1000',
        ]);

        $materialCategory->update($validated);

        return redirect()->route('material-categories.index')
            ->with('success', __('Category updated successfully!'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MaterialCategory $materialCategory)
    {
        $this->authorize('manage', MaterialCategory::class);

        // Check if category has materials
        if ($materialCategory->materials()->count() > 0) {
            return redirect()->route('material-categories.index')
                ->with('error', __('Cannot delete category with existing materials. Please reassign or delete the materials first.'));
        }

        $materialCategory->delete();

        return redirect()->route('material-categories.index')
            ->with('success', __('Category deleted successfully!'));
    }
}
