<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMaterialRequest;
use App\Http\Requests\UpdateMaterialRequest;
use App\Models\Material;
use App\Models\MaterialCategory;
use App\Services\CacheService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class MaterialController extends Controller
{
    public function __construct(
        private CacheService $cacheService
    ) {}

    public function index(Request $request): View
    {
        $query = Material::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('serial_number', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $materials = $query->with('category')->paginate(20);
        $categories = MaterialCategory::orderBy('name')->get();

        return view('materials.index', compact('materials', 'categories'));
    }

    public function create(): View
    {
        $categories = MaterialCategory::orderBy('name')->get();

        return view('materials.create', compact('categories'));
    }

    public function store(StoreMaterialRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('materials', 'public');
        }

        Material::create($validated);
        $this->cacheService->clearMaterialCaches();

        return redirect()->route('materials.index')
            ->with('success', __('Material created successfully.'));
    }

    public function show(Material $material): View
    {
        $material->load('category');

        return view('materials.show', compact('material'));
    }

    public function edit(Material $material): View
    {
        $categories = MaterialCategory::orderBy('name')->get();

        return view('materials.edit', compact('material', 'categories'));
    }

    public function update(UpdateMaterialRequest $request, Material $material): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            if ($material->image) {
                Storage::disk('public')->delete($material->image);
            }
            $validated['image'] = $request->file('image')->store('materials', 'public');
        }

        $material->update($validated);
        $this->cacheService->clearMaterialCaches();

        return redirect()->route('materials.show', $material)
            ->with('success', __('Material updated successfully.'));
    }

    public function destroy(Material $material): RedirectResponse
    {
        if ($material->image) {
            Storage::disk('public')->delete($material->image);
        }

        $material->delete();
        $this->cacheService->clearMaterialCaches();

        return redirect()->route('materials.index')
            ->with('success', __('Material deleted successfully.'));
    }
}
