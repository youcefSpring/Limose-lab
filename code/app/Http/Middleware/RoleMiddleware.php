<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Authentication required',
                'code' => 'AUTHENTICATION_REQUIRED'
            ], 401);
        }

        // Check if user has the required role
        if (!$this->hasRole($user, $role)) {
            if ($request->expectsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Access denied',
                    'code' => 'INSUFFICIENT_PERMISSIONS'
                ], 403);
            }

            abort(403, 'Access denied');
        }

        return $next($request);
    }

    /**
     * Check if user has the specified role
     */
    private function hasRole($user, string $role): bool
    {
        return match ($role) {
            'admin' => $user->isAdmin(),
            'lab_manager' => $user->isLabManager(),
            'researcher' => $user->isResearcher(),
            'visitor' => $user->isVisitor(),
            'admin_or_lab_manager' => $user->isAdmin() || $user->isLabManager(),
            'researcher_or_above' => $user->isAdmin() || $user->isLabManager() || $user->isResearcher(),
            default => false,
        };
    }
}