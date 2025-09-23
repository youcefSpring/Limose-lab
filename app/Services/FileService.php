<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class FileService
{
    public function getFiles(array $filters = []): Collection
    {
        $files = collect();

        // Get files from various storage locations
        $storageDisks = ['public', 'uploads'];

        foreach ($storageDisks as $disk) {
            if (Storage::disk($disk)->exists('')) {
                $diskFiles = $this->getFilesFromDisk($disk, $filters);
                $files = $files->merge($diskFiles);
            }
        }

        return $files;
    }

    public function getFileStatistics(): array
    {
        $totalSize = 0;
        $totalFiles = 0;
        $fileTypes = [];

        $disks = ['public', 'uploads'];

        foreach ($disks as $disk) {
            if (Storage::disk($disk)->exists('')) {
                $diskStats = $this->getDiskStatistics($disk);
                $totalSize += $diskStats['size'];
                $totalFiles += $diskStats['count'];

                foreach ($diskStats['types'] as $type => $count) {
                    $fileTypes[$type] = ($fileTypes[$type] ?? 0) + $count;
                }
            }
        }

        return [
            'total_size' => $totalSize,
            'total_files' => $totalFiles,
            'file_types' => $fileTypes,
            'disk_usage' => $this->getDiskUsage(),
        ];
    }

    public function getDetailedStatistics(): array
    {
        $stats = $this->getFileStatistics();

        return [
            'overview' => $stats,
            'by_type' => $this->getStatisticsByType(),
            'by_date' => $this->getStatisticsByDate(),
            'large_files' => $this->getLargeFiles(),
        ];
    }

    public function getCleanupCandidates(): array
    {
        return [
            'old_files' => $this->getOldFiles(),
            'large_files' => $this->getLargeFiles(100), // Files larger than 100MB
            'duplicate_files' => $this->getDuplicateFiles(),
            'orphaned_files' => $this->getOrphanedFiles(),
        ];
    }

    private function getFilesFromDisk(string $disk, array $filters): Collection
    {
        $files = collect();

        try {
            $allFiles = Storage::disk($disk)->allFiles();

            foreach ($allFiles as $file) {
                $fileInfo = $this->getFileInfo($disk, $file);

                if ($this->matchesFilters($fileInfo, $filters)) {
                    $files->push($fileInfo);
                }
            }
        } catch (\Exception $e) {
            // Handle disk access errors
        }

        return $files;
    }

    private function getFileInfo(string $disk, string $path): array
    {
        $fullPath = Storage::disk($disk)->path($path);
        $size = Storage::disk($disk)->size($path);
        $lastModified = Storage::disk($disk)->lastModified($path);

        return [
            'disk' => $disk,
            'path' => $path,
            'name' => basename($path),
            'size' => $size,
            'size_human' => $this->formatBytes($size),
            'type' => strtolower(pathinfo($path, PATHINFO_EXTENSION)),
            'last_modified' => $lastModified,
            'last_modified_human' => date('Y-m-d H:i:s', $lastModified),
        ];
    }

    private function matchesFilters(array $fileInfo, array $filters): bool
    {
        if (!empty($filters['type']) && $fileInfo['type'] !== $filters['type']) {
            return false;
        }

        if (!empty($filters['size_min']) && $fileInfo['size'] < $filters['size_min']) {
            return false;
        }

        if (!empty($filters['size_max']) && $fileInfo['size'] > $filters['size_max']) {
            return false;
        }

        return true;
    }

    private function getDiskStatistics(string $disk): array
    {
        $totalSize = 0;
        $totalFiles = 0;
        $fileTypes = [];

        try {
            $files = Storage::disk($disk)->allFiles();

            foreach ($files as $file) {
                $size = Storage::disk($disk)->size($file);
                $type = strtolower(pathinfo($file, PATHINFO_EXTENSION));

                $totalSize += $size;
                $totalFiles++;
                $fileTypes[$type] = ($fileTypes[$type] ?? 0) + 1;
            }
        } catch (\Exception $e) {
            // Handle disk access errors
        }

        return [
            'size' => $totalSize,
            'count' => $totalFiles,
            'types' => $fileTypes,
        ];
    }

    private function getDiskUsage(): array
    {
        $path = storage_path();

        if (function_exists('disk_total_space') && function_exists('disk_free_space')) {
            $totalSpace = disk_total_space($path);
            $freeSpace = disk_free_space($path);
            $usedSpace = $totalSpace - $freeSpace;

            return [
                'total' => $totalSpace,
                'used' => $usedSpace,
                'free' => $freeSpace,
                'usage_percentage' => $totalSpace > 0 ? round(($usedSpace / $totalSpace) * 100, 2) : 0,
            ];
        }

        return [
            'total' => 0,
            'used' => 0,
            'free' => 0,
            'usage_percentage' => 0,
        ];
    }

    private function getStatisticsByType(): array
    {
        // Placeholder implementation
        return [
            'images' => ['count' => 0, 'size' => 0],
            'documents' => ['count' => 0, 'size' => 0],
            'videos' => ['count' => 0, 'size' => 0],
            'other' => ['count' => 0, 'size' => 0],
        ];
    }

    private function getStatisticsByDate(): array
    {
        // Placeholder implementation
        return [];
    }

    private function getLargeFiles(int $sizeThresholdMB = 50): array
    {
        // Placeholder implementation
        return [];
    }

    private function getOldFiles(int $daysOld = 365): array
    {
        // Placeholder implementation
        return [];
    }

    private function getDuplicateFiles(): array
    {
        // Placeholder implementation
        return [];
    }

    private function getOrphanedFiles(): array
    {
        // Placeholder implementation
        return [];
    }

    private function formatBytes(int $bytes, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, $precision) . ' ' . $units[$i];
    }
}