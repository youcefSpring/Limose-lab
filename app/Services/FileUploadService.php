<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileUploadService
{
    /**
     * Upload a PDF file with security checks
     *
     * @param UploadedFile $file
     * @param string $directory
     * @return array{path: string, original_name: string, size: int}
     * @throws \Exception
     */
    public function uploadPdf(UploadedFile $file, string $directory): array
    {
        // Validate PDF mime type
        if ($file->getMimeType() !== 'application/pdf') {
            throw new \Exception(__('Only PDF files are allowed.'));
        }

        // Sanitize original filename
        $originalName = $file->getClientOriginalName();
        $sanitizedName = Str::slug(pathinfo($originalName, PATHINFO_FILENAME));
        $filename = $sanitizedName . '_' . time() . '.pdf';

        // Store file
        $path = $file->storeAs($directory, $filename, 'public');

        return [
            'path' => $path,
            'original_name' => $originalName,
            'size' => $file->getSize(),
        ];
    }

    /**
     * Upload an image file
     *
     * @param UploadedFile $file
     * @param string $directory
     * @return array{path: string, original_name: string, size: int}
     * @throws \Exception
     */
    public function uploadImage(UploadedFile $file, string $directory): array
    {
        // Validate image mime type
        $allowedMimes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

        if (!in_array($file->getMimeType(), $allowedMimes)) {
            throw new \Exception(__('Only image files (JPEG, PNG, GIF, WebP) are allowed.'));
        }

        // Sanitize original filename
        $originalName = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $sanitizedName = Str::slug(pathinfo($originalName, PATHINFO_FILENAME));
        $filename = $sanitizedName . '_' . time() . '.' . $extension;

        // Store file
        $path = $file->storeAs($directory, $filename, 'public');

        return [
            'path' => $path,
            'original_name' => $originalName,
            'size' => $file->getSize(),
        ];
    }

    /**
     * Upload any file with extension validation
     *
     * @param UploadedFile $file
     * @param string $directory
     * @param array $allowedExtensions
     * @return string
     */
    public function uploadFile(UploadedFile $file, string $directory, array $allowedExtensions = []): string
    {
        if (!empty($allowedExtensions)) {
            $extension = $file->getClientOriginalExtension();
            if (!in_array(strtolower($extension), array_map('strtolower', $allowedExtensions))) {
                throw new \Exception(__('File type not allowed.'));
            }
        }

        return $file->store($directory, 'public');
    }

    /**
     * Delete a file from storage
     *
     * @param string|null $path
     * @return bool
     */
    public function deleteFile(?string $path): bool
    {
        if ($path && Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->delete($path);
        }

        return false;
    }

    /**
     * Replace an existing file with a new one
     *
     * @param UploadedFile $newFile
     * @param string|null $oldPath
     * @param string $directory
     * @param string $fileType 'pdf'|'image'|'any'
     * @return array|string
     */
    public function replaceFile(UploadedFile $newFile, ?string $oldPath, string $directory, string $fileType = 'any')
    {
        // Delete old file
        $this->deleteFile($oldPath);

        // Upload new file based on type
        return match ($fileType) {
            'pdf' => $this->uploadPdf($newFile, $directory),
            'image' => $this->uploadImage($newFile, $directory),
            default => $this->uploadFile($newFile, $directory),
        };
    }

    /**
     * Get file size in human-readable format
     *
     * @param int $bytes
     * @return string
     */
    public function formatFileSize(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= (1 << (10 * $pow));

        return round($bytes, 2) . ' ' . $units[$pow];
    }
}
