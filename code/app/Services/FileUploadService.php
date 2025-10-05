<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Intervention\Image\ImageManagerStatic as Image;

class FileUploadService
{
    /**
     * Upload researcher photo.
     */
    public function uploadResearcherPhoto(UploadedFile $file): string
    {
        $this->validateImageFile($file, 2048); // 2MB max

        $filename = $this->generateUniqueFilename($file, 'researcher_photo');
        $path = "researchers/photos/{$filename}";

        // Resize and optimize image
        $image = Image::make($file->getRealPath());
        $image->resize(400, 400, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        // Save optimized image
        Storage::disk('private')->put($path, $image->stream()->__toString());

        return $path;
    }

    /**
     * Upload researcher CV.
     */
    public function uploadResearcherCV(UploadedFile $file): string
    {
        $this->validatePDFFile($file, 5120); // 5MB max

        $filename = $this->generateUniqueFilename($file, 'researcher_cv');
        $path = "researchers/cvs/{$filename}";

        Storage::disk('private')->putFileAs('researchers/cvs', $file, $filename);

        return $path;
    }

    /**
     * Upload publication PDF.
     */
    public function uploadPublicationPDF(UploadedFile $file): string
    {
        $this->validatePDFFile($file, 10240); // 10MB max

        $filename = $this->generateUniqueFilename($file, 'publication');
        $path = "publications/{$filename}";

        Storage::disk('private')->putFileAs('publications', $file, $filename);

        return $path;
    }

    /**
     * Upload project document.
     */
    public function uploadProjectDocument(UploadedFile $file): string
    {
        $allowedMimes = ['pdf', 'doc', 'docx', 'ppt', 'pptx'];
        $this->validateDocumentFile($file, $allowedMimes, 20480); // 20MB max

        $filename = $this->generateUniqueFilename($file, 'project_document');
        $path = "projects/documents/{$filename}";

        Storage::disk('private')->putFileAs('projects/documents', $file, $filename);

        return $path;
    }

    /**
     * Upload event attachment.
     */
    public function uploadEventAttachment(UploadedFile $file): string
    {
        $allowedMimes = ['pdf', 'doc', 'docx', 'ppt', 'pptx', 'jpg', 'jpeg', 'png'];
        $this->validateDocumentFile($file, $allowedMimes, 15360); // 15MB max

        $filename = $this->generateUniqueFilename($file, 'event_attachment');
        $path = "events/attachments/{$filename}";

        Storage::disk('private')->putFileAs('events/attachments', $file, $filename);

        return $path;
    }

    /**
     * Upload equipment photo.
     */
    public function uploadEquipmentPhoto(UploadedFile $file): string
    {
        $this->validateImageFile($file, 3072); // 3MB max

        $filename = $this->generateUniqueFilename($file, 'equipment_photo');
        $path = "equipment/photos/{$filename}";

        // Resize and optimize image
        $image = Image::make($file->getRealPath());
        $image->resize(800, 600, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        Storage::disk('private')->put($path, $image->stream()->__toString());

        return $path;
    }

    /**
     * Upload equipment manual/documentation.
     */
    public function uploadEquipmentManual(UploadedFile $file): string
    {
        $this->validatePDFFile($file, 51200); // 50MB max for manuals

        $filename = $this->generateUniqueFilename($file, 'equipment_manual');
        $path = "equipment/manuals/{$filename}";

        Storage::disk('private')->putFileAs('equipment/manuals', $file, $filename);

        return $path;
    }

    /**
     * Upload collaboration agreement document.
     */
    public function uploadCollaborationDocument(UploadedFile $file): string
    {
        $allowedMimes = ['pdf', 'doc', 'docx'];
        $this->validateDocumentFile($file, $allowedMimes, 10240); // 10MB max

        $filename = $this->generateUniqueFilename($file, 'collaboration_doc');
        $path = "collaborations/documents/{$filename}";

        Storage::disk('private')->putFileAs('collaborations/documents', $file, $filename);

        return $path;
    }

    /**
     * Delete uploaded file.
     */
    public function deleteFile(string $filePath): bool
    {
        try {
            if (Storage::disk('private')->exists($filePath)) {
                return Storage::disk('private')->delete($filePath);
            }
            return true; // File doesn't exist, consider as deleted
        } catch (\Exception $e) {
            \Log::error("Failed to delete file: {$filePath}", ['error' => $e->getMessage()]);
            return false;
        }
    }

    /**
     * Get file URL for download.
     */
    public function getFileUrl(string $filePath): string
    {
        return route('files.download', ['path' => base64_encode($filePath)]);
    }

    /**
     * Get file size in human readable format.
     */
    public function getFileSize(string $filePath): string
    {
        try {
            $bytes = Storage::disk('private')->size($filePath);
            return $this->formatBytes($bytes);
        } catch (\Exception $e) {
            return 'Unknown';
        }
    }

    /**
     * Check if file exists.
     */
    public function fileExists(string $filePath): bool
    {
        return Storage::disk('private')->exists($filePath);
    }

    /**
     * Scan file for viruses (placeholder for antivirus integration).
     */
    public function scanFileForViruses(UploadedFile $file): bool
    {
        // This would integrate with an antivirus service like ClamAV
        // For now, we'll just log the scan attempt
        \Log::info("Virus scan performed on file: {$file->getClientOriginalName()}");

        // TODO: Implement actual antivirus scanning
        // Example integration with ClamAV:
        // $scanner = new \Xenolope\Quahog\Client(new \Socket\Raw\Factory());
        // $result = $scanner->scanFile($file->getRealPath());
        // return $result['status'] === 'OK';

        return true; // Placeholder - assume clean
    }

    /**
     * Validate image file.
     */
    private function validateImageFile(UploadedFile $file, int $maxSizeKb): void
    {
        $rules = [
            'mimes:jpeg,jpg,png,gif',
            'max:' . $maxSizeKb,
        ];

        $validator = \Validator::make(['file' => $file], ['file' => $rules]);

        if ($validator->fails()) {
            throw ValidationException::withMessages($validator->errors()->toArray());
        }

        // Additional security checks
        if (!$this->isValidImageFile($file)) {
            throw ValidationException::withMessages([
                'file' => ['الملف ليس صورة صالحة'],
            ]);
        }

        // Scan for viruses
        if (!$this->scanFileForViruses($file)) {
            throw ValidationException::withMessages([
                'file' => ['تم اكتشاف فيروس في الملف'],
            ]);
        }
    }

    /**
     * Validate PDF file.
     */
    private function validatePDFFile(UploadedFile $file, int $maxSizeKb): void
    {
        $rules = [
            'mimes:pdf',
            'max:' . $maxSizeKb,
        ];

        $validator = \Validator::make(['file' => $file], ['file' => $rules]);

        if ($validator->fails()) {
            throw ValidationException::withMessages($validator->errors()->toArray());
        }

        // Scan for viruses
        if (!$this->scanFileForViruses($file)) {
            throw ValidationException::withMessages([
                'file' => ['تم اكتشاف فيروس في الملف'],
            ]);
        }
    }

    /**
     * Validate document file.
     */
    private function validateDocumentFile(UploadedFile $file, array $allowedMimes, int $maxSizeKb): void
    {
        $rules = [
            'mimes:' . implode(',', $allowedMimes),
            'max:' . $maxSizeKb,
        ];

        $validator = \Validator::make(['file' => $file], ['file' => $rules]);

        if ($validator->fails()) {
            throw ValidationException::withMessages($validator->errors()->toArray());
        }

        // Scan for viruses
        if (!$this->scanFileForViruses($file)) {
            throw ValidationException::withMessages([
                'file' => ['تم اكتشاف فيروس في الملف'],
            ]);
        }
    }

    /**
     * Generate unique filename.
     */
    private function generateUniqueFilename(UploadedFile $file, string $prefix = 'file'): string
    {
        $extension = $file->getClientOriginalExtension();
        $timestamp = now()->format('Y-m-d_H-i-s');
        $random = Str::random(8);

        return "{$prefix}_{$timestamp}_{$random}.{$extension}";
    }

    /**
     * Check if file is a valid image.
     */
    private function isValidImageFile(UploadedFile $file): bool
    {
        try {
            $imageInfo = getimagesize($file->getRealPath());
            return $imageInfo !== false;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Format bytes to human readable format.
     */
    private function formatBytes(int $bytes, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, $precision) . ' ' . $units[$i];
    }

    /**
     * Create secure download response.
     */
    public function createDownloadResponse(string $filePath, ?string $customName = null): \Illuminate\Http\Response
    {
        if (!$this->fileExists($filePath)) {
            abort(404, 'File not found');
        }

        $content = Storage::disk('private')->get($filePath);
        $mimeType = Storage::disk('private')->mimeType($filePath);
        $size = Storage::disk('private')->size($filePath);

        $fileName = $customName ?: basename($filePath);

        return response($content)
            ->header('Content-Type', $mimeType)
            ->header('Content-Length', $size)
            ->header('Content-Disposition', 'attachment; filename="' . $fileName . '"')
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    /**
     * Get file metadata.
     */
    public function getFileMetadata(string $filePath): array
    {
        if (!$this->fileExists($filePath)) {
            return [];
        }

        try {
            return [
                'path' => $filePath,
                'size' => $this->getFileSize($filePath),
                'size_bytes' => Storage::disk('private')->size($filePath),
                'mime_type' => Storage::disk('private')->mimeType($filePath),
                'last_modified' => Storage::disk('private')->lastModified($filePath),
                'url' => $this->getFileUrl($filePath),
            ];
        } catch (\Exception $e) {
            \Log::error("Failed to get file metadata for: {$filePath}", ['error' => $e->getMessage()]);
            return [];
        }
    }

    /**
     * Clean up old temporary files.
     */
    public function cleanupOldFiles(int $daysOld = 30): int
    {
        $deletedCount = 0;
        $cutoffDate = now()->subDays($daysOld);

        try {
            $directories = ['temp', 'cache'];

            foreach ($directories as $directory) {
                $files = Storage::disk('private')->allFiles($directory);

                foreach ($files as $file) {
                    $lastModified = Storage::disk('private')->lastModified($file);

                    if ($lastModified < $cutoffDate->timestamp) {
                        if (Storage::disk('private')->delete($file)) {
                            $deletedCount++;
                        }
                    }
                }
            }

            \Log::info("Cleaned up {$deletedCount} old files");
        } catch (\Exception $e) {
            \Log::error("Failed to cleanup old files", ['error' => $e->getMessage()]);
        }

        return $deletedCount;
    }
}