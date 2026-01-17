<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckCityPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $action = 'view'): Response
    {
        $user = Auth::user();

        // Admin has access to all cities
        if ($user && $user->isAdmin()) {
            return $next($request);
        }

        // Get city ID from request (could be in route, query, or body)
        $cityId = $request->route('city_id') 
            ?? $request->input('city_id') 
            ?? $request->input('entry_city')
            ?? session('selected_city_id');

        // If no city specified, allow (will be filtered by controller)
        if (!$cityId) {
            return $next($request);
        }

        // Check if user has permission for this city
        if ($user && !$user->hasCityPermission($cityId, $action)) {
            abort(403, 'You do not have permission to access this city.');
        }

        return $next($request);
    }
}
