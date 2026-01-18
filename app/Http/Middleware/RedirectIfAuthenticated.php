<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();
                
                // Role-based default landing page redirection
                if ($user && $user->isAdmin()) {
                    // Admin: Redirect to dashboard
                return redirect('/dashboard');
                } else {
                    // Employees (staff/driver): Redirect to CN Entry page
                    return redirect('/shipments');
                }
            }
        }

        return $next($request);
    }
}

