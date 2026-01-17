<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\MenuPermissionService;

class CheckDynamicPermission
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $action = 'view'): Response
    {
        $user = auth()->user();
        
        if (!$user) {
            return redirect()->route('login');
        }

        // Admin has all permissions
        if ($user->isAdmin()) {
            return $next($request);
        }

        $routeName = $request->route()->getName();
        
        // Check if user has permission for this route
        if (!MenuPermissionService::userHasPermission($user, $routeName, $action)) {
            abort(403, 'You do not have permission to access this resource.');
        }

        return $next($request);
    }
}
