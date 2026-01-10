<?php

namespace App\Helpers;

class FileHelper
{
    /**
     * Format file size to human-readable format.
     *
     * @param int $bytes
     * @param int $precision
     * @return string
     */
    public static function formatFileSize(int $bytes, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, $precision) . ' ' . $units[$i];
    }

    /**
     * Get file extension from filename.
     *
     * @param string $filename
     * @return string
     */
    public static function getExtension(string $filename): string
    {
        return pathinfo($filename, PATHINFO_EXTENSION);
    }

    /**
     * Check if file is an image.
     *
     * @param string $mimeType
     * @return bool
     */
    public static function isImage(string $mimeType): bool
    {
        return str_starts_with($mimeType, 'image/');
    }

    /**
     * Check if file is a PDF.
     *
     * @param string $mimeType
     * @return bool
     */
    public static function isPdf(string $mimeType): bool
    {
        return $mimeType === 'application/pdf';
    }

    /**
     * Check if file is a document (Word, Excel, PowerPoint).
     *
     * @param string $mimeType
     * @return bool
     */
    public static function isDocument(string $mimeType): bool
    {
        $documentMimes = [
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'application/vnd.ms-powerpoint',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation',
        ];

        return in_array($mimeType, $documentMimes);
    }

    /**
     * Get file icon class based on mime type.
     *
     * @param string $mimeType
     * @return string
     */
    public static function getFileIcon(string $mimeType): string
    {
        if (self::isImage($mimeType)) {
            return 'fa-file-image';
        } elseif (self::isPdf($mimeType)) {
            return 'fa-file-pdf';
        } elseif (self::isDocument($mimeType)) {
            return 'fa-file-word';
        } elseif (str_contains($mimeType, 'spreadsheet') || str_contains($mimeType, 'excel')) {
            return 'fa-file-excel';
        } elseif (str_contains($mimeType, 'zip') || str_contains($mimeType, 'compressed')) {
            return 'fa-file-archive';
        } elseif (str_contains($mimeType, 'video')) {
            return 'fa-file-video';
        } elseif (str_contains($mimeType, 'audio')) {
            return 'fa-file-audio';
        } else {
            return 'fa-file';
        }
    }

    /**
     * Validate file size.
     *
     * @param int $fileSize
     * @param int $maxSizeMB
     * @return bool
     */
    public static function validateFileSize(int $fileSize, int $maxSizeMB): bool
    {
        return $fileSize <= ($maxSizeMB * 1024 * 1024);
    }

    /**
     * Sanitize filename.
     *
     * @param string $filename
     * @return string
     */
    public static function sanitizeFilename(string $filename): string
    {
        // Remove special characters
        $filename = preg_replace('/[^a-zA-Z0-9._-]/', '_', $filename);

        // Remove multiple underscores
        $filename = preg_replace('/_+/', '_', $filename);

        return $filename;
    }

    /**
     * Generate unique filename.
     *
     * @param string $originalFilename
     * @return string
     */
    public static function generateUniqueFilename(string $originalFilename): string
    {
        $extension = self::getExtension($originalFilename);
        $nameWithoutExt = pathinfo($originalFilename, PATHINFO_FILENAME);
        $sanitizedName = self::sanitizeFilename($nameWithoutExt);

        return $sanitizedName . '_' . time() . '_' . uniqid() . '.' . $extension;
    }
}
