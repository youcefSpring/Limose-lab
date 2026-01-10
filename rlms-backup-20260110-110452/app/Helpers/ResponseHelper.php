<?php

namespace App\Helpers;

class ResponseHelper
{
    /**
     * Success response format.
     *
     * @param mixed $data
     * @param string $message
     * @param int $statusCode
     * @return array
     */
    public static function success($data = null, string $message = 'Success', int $statusCode = 200): array
    {
        return [
            'success' => true,
            'message' => $message,
            'data' => $data,
            'status_code' => $statusCode,
        ];
    }

    /**
     * Error response format.
     *
     * @param string|array $errors
     * @param string $message
     * @param int $statusCode
     * @return array
     */
    public static function error($errors, string $message = 'Error', int $statusCode = 400): array
    {
        if (is_string($errors)) {
            $errors = [$errors];
        }

        return [
            'success' => false,
            'message' => $message,
            'errors' => $errors,
            'status_code' => $statusCode,
        ];
    }

    /**
     * Validation error response.
     *
     * @param array $errors
     * @return array
     */
    public static function validationError(array $errors): array
    {
        return self::error($errors, 'Validation failed', 422);
    }

    /**
     * Not found response.
     *
     * @param string $resource
     * @return array
     */
    public static function notFound(string $resource = 'Resource'): array
    {
        return self::error("{$resource} not found", 'Not found', 404);
    }

    /**
     * Unauthorized response.
     *
     * @param string $message
     * @return array
     */
    public static function unauthorized(string $message = 'Unauthorized'): array
    {
        return self::error($message, 'Unauthorized', 401);
    }

    /**
     * Forbidden response.
     *
     * @param string $message
     * @return array
     */
    public static function forbidden(string $message = 'Forbidden'): array
    {
        return self::error($message, 'Forbidden', 403);
    }

    /**
     * Created response.
     *
     * @param mixed $data
     * @param string $message
     * @return array
     */
    public static function created($data = null, string $message = 'Resource created successfully'): array
    {
        return self::success($data, $message, 201);
    }

    /**
     * No content response.
     *
     * @return array
     */
    public static function noContent(): array
    {
        return [
            'success' => true,
            'message' => 'No content',
            'data' => null,
            'status_code' => 204,
        ];
    }
}
