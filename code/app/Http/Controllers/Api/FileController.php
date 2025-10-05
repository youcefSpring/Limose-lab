<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\FileUploadService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function __construct(
        private FileUploadService $fileUploadService
    ) {}

    /**
     * Upload file
     * POST /api/v1/files/upload
     */
    public function upload(Request $request): JsonResponse
    {
        $request->validate([
            'file' => 'required|file|max:51200', // 50MB max
            'type' => 'required|string|in:document,image,pdf',
            'category' => 'required|string|in:project,publication,profile,equipment,event,collaboration',
        ]);

        try {
            $file = $request->file('file');
            $type = $request->input('type');
            $category = $request->input('category');

            // Upload based on category and type
            $filePath = match ($category) {
                'project' => $this->fileUploadService->uploadProjectDocument($file),
                'publication' => $this->fileUploadService->uploadPublicationPDF($file),
                'profile' => $type === 'image' ?
                    $this->fileUploadService->uploadResearcherPhoto($file) :
                    $this->fileUploadService->uploadResearcherCV($file),
                'equipment' => $type === 'image' ?
                    $this->fileUploadService->uploadEquipmentPhoto($file) :
                    $this->fileUploadService->uploadEquipmentManual($file),
                'event' => $this->fileUploadService->uploadEventAttachment($file),
                'collaboration' => $this->fileUploadService->uploadCollaborationDocument($file),
                default => throw new \Exception('Invalid category')
            };

            $fileInfo = $this->fileUploadService->getFileMetadata($filePath);

            return response()->json([
                'status' => 'success',
                'data' => [
                    'file' => [
                        'id' => hash('md5', $filePath),
                        'filename' => basename($filePath),
                        'original_name' => $file->getClientOriginalName(),
                        'mime_type' => $file->getMimeType(),
                        'size' => $file->getSize(),
                        'path' => $filePath,
                        'url' => $this->fileUploadService->getFileUrl($filePath),
                        'metadata' => $fileInfo,
                        'created_at' => now(),
                    ]
                ],
                'message' => 'File uploaded successfully'
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'File upload failed: ' . $e->getMessage(),
                'code' => 'FILE_UPLOAD_FAILED'
            ], 422);
        }
    }

    /**
     * Download file
     * GET /api/v1/files/{path}/download
     */
    public function download(Request $request, string $encodedPath): Response
    {
        try {
            $filePath = base64_decode($encodedPath);

            if (!$this->fileUploadService->fileExists($filePath)) {
                abort(404, 'File not found');
            }

            // Check permissions - implement your authorization logic here
            $this->authorizeFileAccess($filePath);

            return $this->fileUploadService->createDownloadResponse($filePath);

        } catch (\Exception $e) {
            abort(404, 'File not found or access denied');
        }
    }

    /**
     * Get file information
     * GET /api/v1/files/{path}/info
     */
    public function info(string $encodedPath): JsonResponse
    {
        try {
            $filePath = base64_decode($encodedPath);

            if (!$this->fileUploadService->fileExists($filePath)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'File not found',
                    'code' => 'FILE_NOT_FOUND'
                ], 404);
            }

            // Check permissions
            $this->authorizeFileAccess($filePath);

            $fileInfo = $this->fileUploadService->getFileMetadata($filePath);

            return response()->json([
                'status' => 'success',
                'data' => [
                    'file' => $fileInfo
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Access denied',
                'code' => 'ACCESS_DENIED'
            ], 403);
        }
    }

    /**
     * Delete file
     * DELETE /api/v1/files/{path}
     */
    public function destroy(string $encodedPath): JsonResponse
    {
        try {
            $filePath = base64_decode($encodedPath);

            if (!$this->fileUploadService->fileExists($filePath)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'File not found',
                    'code' => 'FILE_NOT_FOUND'
                ], 404);
            }

            // Check permissions - only file owner or admin can delete
            $this->authorizeFileDeletion($filePath);

            $deleted = $this->fileUploadService->deleteFile($filePath);

            if ($deleted) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'File deleted successfully'
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to delete file',
                    'code' => 'FILE_DELETE_FAILED'
                ], 500);
            }

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Access denied',
                'code' => 'ACCESS_DENIED'
            ], 403);
        }
    }

    /**
     * Clean up old files (Admin only)
     * POST /api/v1/files/cleanup
     */
    public function cleanup(Request $request): JsonResponse
    {
        if (!auth()->user()->isAdmin()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Access denied',
                'code' => 'INSUFFICIENT_PERMISSIONS'
            ], 403);
        }

        $request->validate([
            'days_old' => 'nullable|integer|min:1|max:365',
        ]);

        $daysOld = $request->input('days_old', 30);
        $deletedCount = $this->fileUploadService->cleanupOldFiles($daysOld);

        return response()->json([
            'status' => 'success',
            'data' => [
                'deleted_files_count' => $deletedCount,
                'days_old' => $daysOld
            ],
            'message' => "Cleanup completed. {$deletedCount} files deleted."
        ]);
    }

    /**
     * Get storage statistics (Admin only)
     * GET /api/v1/files/statistics
     */
    public function statistics(): JsonResponse
    {
        if (!auth()->user()->isAdmin()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Access denied',
                'code' => 'INSUFFICIENT_PERMISSIONS'
            ], 403);
        }

        try {
            $directories = [
                'researchers' => 'Researcher files',
                'projects' => 'Project documents',
                'publications' => 'Publication PDFs',
                'equipment' => 'Equipment files',
                'events' => 'Event attachments',
                'collaborations' => 'Collaboration documents',
            ];

            $statistics = [];
            $totalSize = 0;
            $totalFiles = 0;

            foreach ($directories as $dir => $label) {
                $files = Storage::disk('private')->allFiles($dir);
                $size = 0;

                foreach ($files as $file) {
                    $size += Storage::disk('private')->size($file);
                }

                $statistics[$dir] = [
                    'label' => $label,
                    'files_count' => count($files),
                    'size_bytes' => $size,
                    'size_formatted' => $this->formatBytes($size),
                ];

                $totalSize += $size;
                $totalFiles += count($files);
            }

            return response()->json([
                'status' => 'success',
                'data' => [
                    'directories' => $statistics,
                    'total' => [
                        'files_count' => $totalFiles,
                        'size_bytes' => $totalSize,
                        'size_formatted' => $this->formatBytes($totalSize),
                    ]
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to get storage statistics',
                'code' => 'STATISTICS_FAILED'
            ], 500);
        }
    }

    /**
     * Authorize file access based on file path and user permissions
     */
    private function authorizeFileAccess(string $filePath): void
    {
        $user = auth()->user();

        // Admin and lab managers can access all files
        if ($user->isAdmin() || $user->isLabManager()) {
            return;
        }

        // Researchers can access their own files and public files
        if ($user->isResearcher()) {
            // Check if file belongs to the researcher
            if ($this->isUserFile($filePath, $user)) {
                return;
            }

            // Check if file is from a project they're involved in
            if ($this->isProjectFile($filePath, $user->researcher)) {
                return;
            }

            // Check if file is a published publication
            if ($this->isPublicPublicationFile($filePath)) {
                return;
            }
        }

        // Visitors can only access public files
        if ($user->isVisitor()) {
            if ($this->isPublicFile($filePath)) {
                return;
            }
        }

        throw new \Exception('Access denied');
    }

    /**
     * Authorize file deletion
     */
    private function authorizeFileDeletion(string $filePath): void
    {
        $user = auth()->user();

        // Admin can delete any file
        if ($user->isAdmin()) {
            return;
        }

        // Lab managers can delete equipment and event files
        if ($user->isLabManager()) {
            if (str_contains($filePath, 'equipment/') || str_contains($filePath, 'events/')) {
                return;
            }
        }

        // Users can only delete their own files
        if ($this->isUserFile($filePath, $user)) {
            return;
        }

        throw new \Exception('Access denied');
    }

    /**
     * Check if file belongs to user
     */
    private function isUserFile(string $filePath, $user): bool
    {
        // This would implement logic to check file ownership
        // For now, simplified check
        return str_contains($filePath, "user_{$user->id}_") ||
               ($user->researcher && str_contains($filePath, "researcher_{$user->researcher->id}_"));
    }

    /**
     * Check if file belongs to user's project
     */
    private function isProjectFile(string $filePath, $researcher): bool
    {
        // Check if researcher is involved in projects that own this file
        $projectIds = $researcher->leadProjects()->pluck('id')
            ->merge($researcher->projects()->pluck('id'));

        foreach ($projectIds as $projectId) {
            if (str_contains($filePath, "project_{$projectId}_")) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if file is a public publication
     */
    private function isPublicPublicationFile(string $filePath): bool
    {
        // Check if publication file is published
        if (str_contains($filePath, 'publications/')) {
            // This would check publication status in database
            return true; // Simplified for now
        }

        return false;
    }

    /**
     * Check if file is public
     */
    private function isPublicFile(string $filePath): bool
    {
        // Define public file patterns
        $publicPatterns = [
            'publications/',
            'events/',
            'public/',
        ];

        foreach ($publicPatterns as $pattern) {
            if (str_contains($filePath, $pattern)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Format bytes to human readable format
     */
    private function formatBytes(int $bytes, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, $precision) . ' ' . $units[$i];
    }
}