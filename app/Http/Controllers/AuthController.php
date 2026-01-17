<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
            'password' => 'required',
        ]);

        // Try to find user by email (which can be username or email)
        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user, $request->filled('remember'));
            $request->session()->regenerate();
            
            // Set default city for user
            if ($user->isAdmin()) {
                // Admin: Set first active city or null (can access all)
                $defaultCity = \App\Models\City::where('is_active', true)->first();
                if ($defaultCity) {
                    session(['selected_city_id' => $defaultCity->city_id]);
                }
            } else {
                // Non-admin: Set primary city or first accessible city
                if ($user->primary_city_id) {
                    session(['selected_city_id' => $user->primary_city_id]);
                } else {
                    $firstAccessibleCity = $user->accessibleCities()->first();
                    if ($firstAccessibleCity) {
                        session(['selected_city_id' => $firstAccessibleCity->city_id]);
                    }
                }
            }
            
            // Log activity
            Log::info('User logged in', ['user_id' => Auth::id()]);
            
            // Role-based default landing page redirection
            if ($user->isAdmin()) {
                // Admin: Redirect to dashboard (default behavior)
                return redirect()->intended('/dashboard');
            } else {
                // Employees (staff/driver): Redirect to CN Entry page
                return redirect()->intended('/shipments');
            }
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/login');
    }
}


