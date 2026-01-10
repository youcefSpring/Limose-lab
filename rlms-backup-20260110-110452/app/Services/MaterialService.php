<?php

namespace App\Services;

use App\Models\Material;
use App\Models\MaterialCategory;
use Illuminate\Support\Facades\Storage;

class MaterialService
{
    /**
     * Create a new material.
     *
     * @param array $data
     * @return Material
     */
    public function createMaterial(array $data): Material
    {
        // Handle image upload if provided
        if (isset($data['image'])) {
            $data['image'] = $this->uploadImage($data['image']);
        }

        return Material::create($data);
    }

    /**
     * Update a material.
     *
     * @param Material $material
     * @param array $data
     * @return Material
     */
    public function updateMaterial(Material $material, array $data): Material
    {
        // Handle image upload if provided
        if (isset($data['image'])) {
            // Delete old image
            if ($material->image) {
                $this->deleteImage($material->image);
            }
            $data['image'] = $this->uploadImage($data['image']);
        }

        $material->update($data);
        return $material->fresh();
    }

    /**
     * Delete a material.
     *
     * @param Material $material
     * @return bool
     * @throws \Exception
     */
    public function deleteMaterial(Material $material): bool
    {
        // Check if material has active reservations
        $activeReservations = $material->reservations()
            ->whereIn('status', ['pending', 'approved'])
            ->count();

        if ($activeReservations > 0) {
            throw new \Exception('Cannot delete material with active reservations');
        }

        // Delete image if exists
        if ($material->image) {
            $this->deleteImage($material->image);
        }

        return $material->delete();
    }

    /**
     * Change material status.
     *
     * @param Material $material
     * @param string $status
     * @param ReservationService|null $reservationService
     * @return Material
     */
    public function changeStatus(Material $material, string $status, ?ReservationService $reservationService = null): Material
    {
        $oldStatus = $material->status;
        $material->update(['status' => $status]);

        // If changing to maintenance or retired, cancel future reservations
        if (in_array($status, ['maintenance', 'retired']) && $oldStatus === 'available') {
            if (!$reservationService) {
                $reservationService = app(ReservationService::class);
            }
            $reservationService->cancelFutureReservations($material);
        }

        return $material->fresh();
    }

    /**
     * Update material quantity.
     *
     * @param Material $material
     * @param int $quantity
     * @return Material
     */
    public function updateQuantity(Material $material, int $quantity): Material
    {
        $material->update(['quantity' => $quantity]);
        return $material->fresh();
    }

    /**
     * Get materials that need maintenance.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getMaterialsNeedingMaintenance()
    {
        return Material::whereNotNull('maintenance_schedule')
            ->where(function ($query) {
                $query->whereNull('last_maintenance_date')
                    ->orWhereRaw('
                        CASE maintenance_schedule
                            WHEN "weekly" THEN DATEDIFF(CURDATE(), last_maintenance_date) >= 7
                            WHEN "monthly" THEN DATEDIFF(CURDATE(), last_maintenance_date) >= 30
                            WHEN "quarterly" THEN DATEDIFF(CURDATE(), last_maintenance_date) >= 90
                            WHEN "yearly" THEN DATEDIFF(CURDATE(), last_maintenance_date) >= 365
                        END
                    ');
            })
            ->get();
    }

    /**
     * Search materials by keyword.
     *
     * @param string $keyword
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function searchMaterials(string $keyword)
    {
        return Material::where('name', 'like', "%{$keyword}%")
            ->orWhere('description', 'like', "%{$keyword}%")
            ->orWhere('location', 'like', "%{$keyword}%")
            ->orWhere('serial_number', 'like', "%{$keyword}%")
            ->with('category')
            ->get();
    }

    /**
     * Get materials by category.
     *
     * @param int $categoryId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getMaterialsByCategory(int $categoryId)
    {
        return Material::where('category_id', $categoryId)
            ->orderBy('name')
            ->get();
    }

    /**
     * Get materials by status.
     *
     * @param string $status
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getMaterialsByStatus(string $status)
    {
        return Material::where('status', $status)
            ->with('category')
            ->orderBy('name')
            ->get();
    }

    /**
     * Upload material image.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @return string Path to stored image
     */
    private function uploadImage($file): string
    {
        $path = $file->store('materials', 'public');
        return $path;
    }

    /**
     * Delete material image.
     *
     * @param string $path
     * @return bool
     */
    private function deleteImage(string $path): bool
    {
        return Storage::disk('public')->delete($path);
    }

    /**
     * Create a material category.
     *
     * @param array $data
     * @return MaterialCategory
     */
    public function createCategory(array $data): MaterialCategory
    {
        return MaterialCategory::create($data);
    }

    /**
     * Update a material category.
     *
     * @param MaterialCategory $category
     * @param array $data
     * @return MaterialCategory
     */
    public function updateCategory(MaterialCategory $category, array $data): MaterialCategory
    {
        $category->update($data);
        return $category->fresh();
    }

    /**
     * Delete a material category.
     *
     * @param MaterialCategory $category
     * @return bool
     * @throws \Exception
     */
    public function deleteCategory(MaterialCategory $category): bool
    {
        // Check if category has materials
        if ($category->materials()->count() > 0) {
            throw new \Exception('Cannot delete category with associated materials');
        }

        return $category->delete();
    }
}
