<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\City;
use App\Models\UserCityPermission;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('contact', 'like', "%{$search}%");
            });
        }

        // Filter by role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        
        if (in_array($sortBy, ['name', 'email', 'role', 'created_at'])) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        // Pagination
        $perPage = $request->get('per_page', 15);
        if ($perPage === 'all') {
            $allUsers = $query->get();
            // Convert to paginator for consistency
            $users = new \Illuminate\Pagination\LengthAwarePaginator(
                $allUsers,
                $allUsers->count(),
                $allUsers->count() > 0 ? $allUsers->count() : 1,
                1,
                ['path' => $request->url(), 'query' => $request->query()]
            );
        } else {
            $users = $query->paginate((int)$perPage)->withQueryString();
        }

        return view('users.index', compact('users'));
    }

    public function create()
    {
        $cities = City::where('is_active', true)->orderBy('name')->get();
        $menuPermissions = \App\Services\MenuPermissionService::getFlattenedPermissions();
        return view('users.create', compact('cities', 'menuPermissions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'role' => 'required|in:admin,staff,driver',
            'primary_city_id' => 'nullable|exists:cities,city_id',
            'menu_permissions' => 'nullable|array',
            'dynamic_permissions' => 'nullable|array',
            'city_permissions' => 'nullable|array',
            'city_permissions.*.city_id' => 'required|exists:cities,city_id',
            'city_permissions.*.can_view' => 'boolean',
            'city_permissions.*.can_create' => 'boolean',
            'city_permissions.*.can_edit' => 'boolean',
            'city_permissions.*.can_delete' => 'boolean',
            'city_permissions.*.module_permissions' => 'nullable|array',
        ]);

        // Process menu permissions
        $menuPermissions = [];
        if (isset($validated['menu_permissions'])) {
            foreach ($validated['menu_permissions'] as $module => $allowed) {
                if ($allowed === '1' || $allowed === true || $allowed === 'true') {
                    $menuPermissions[$module] = true;
                }
            }
        }

        // Process dynamic permissions
        $dynamicPermissions = [];
        if ($request->has('dynamic_permissions')) {
            foreach ($request->input('dynamic_permissions', []) as $permissionKey => $actions) {
                if (is_array($actions) && !empty($actions)) {
                    $dynamicPermissions[$permissionKey] = array_filter($actions, fn($v) => $v === '1' || $v === true || $v === 'true');
                }
            }
        }

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'contact' => $request->input('contact'),
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'primary_city_id' => $validated['primary_city_id'] ?? null,
            'menu_permissions' => $menuPermissions,
            'dynamic_permissions' => $dynamicPermissions,
        ]);

        // Create city permissions if provided (skip for admin)
        if (!$user->isAdmin() && isset($validated['city_permissions'])) {
            foreach ($validated['city_permissions'] as $permissionData) {
                UserCityPermission::create([
                    'user_id' => $user->id,
                    'city_id' => $permissionData['city_id'],
                    'can_view' => $permissionData['can_view'] ?? true,
                    'can_create' => $permissionData['can_create'] ?? false,
                    'can_edit' => $permissionData['can_edit'] ?? false,
                    'can_delete' => $permissionData['can_delete'] ?? false,
                    'permissions' => $permissionData['module_permissions'] ?? null,
                ]);
            }
        }

        // Log activity
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'created',
            'model_type' => 'User',
            'model_id' => $user->id,
            'description' => "Created user: {$user->name}",
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function show(User $user)
    {
        $cities = City::where('is_active', true)->orderBy('name')->get();
        $userPermissions = $user->cityPermissions()->with('city')->get()->keyBy('city_id');
        return view('users.show', compact('user', 'cities', 'userPermissions'));
    }

    public function edit(User $user)
    {
        $cities = City::where('is_active', true)->orderBy('name')->get();
        $userPermissions = $user->cityPermissions()->with('city')->get()->keyBy('city_id');
        $menuPermissions = \App\Services\MenuPermissionService::getFlattenedPermissions();
        return view('users.edit', compact('user', 'cities', 'userPermissions', 'menuPermissions'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|min:8|confirmed',
            'role' => 'required|in:admin,staff,driver',
            'primary_city_id' => 'nullable|exists:cities,city_id',
            'menu_permissions' => 'nullable|array',
            'dynamic_permissions' => 'nullable|array',
            'city_permissions' => 'nullable|array',
            'city_permissions.*.city_id' => 'required|exists:cities,city_id',
            'city_permissions.*.can_view' => 'boolean',
            'city_permissions.*.can_create' => 'boolean',
            'city_permissions.*.can_edit' => 'boolean',
            'city_permissions.*.can_delete' => 'boolean',
            'city_permissions.*.module_permissions' => 'nullable|array',
        ]);

        // Process menu permissions
        $menuPermissions = [];
        if (isset($validated['menu_permissions'])) {
            foreach ($validated['menu_permissions'] as $module => $allowed) {
                if ($allowed === '1' || $allowed === true || $allowed === 'true') {
                    $menuPermissions[$module] = true;
                }
            }
        }

        // Process dynamic permissions
        $dynamicPermissions = [];
        if ($request->has('dynamic_permissions')) {
            foreach ($request->input('dynamic_permissions', []) as $permissionKey => $actions) {
                if (is_array($actions) && !empty($actions)) {
                    $dynamicPermissions[$permissionKey] = array_filter($actions, fn($v) => $v === '1' || $v === true || $v === 'true');
                }
            }
        }

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->contact = $request->input('contact');
        $user->role = $validated['role'];
        $user->primary_city_id = $validated['primary_city_id'] ?? null;
        $user->menu_permissions = $menuPermissions;
        $user->dynamic_permissions = $dynamicPermissions;
        
        if ($request->filled('password')) {
            $user->password = Hash::make($validated['password']);
        }
        
        $user->save();

        // Update city permissions (skip for admin)
        if (!$user->isAdmin() && isset($validated['city_permissions'])) {
            // Delete existing permissions
            $user->cityPermissions()->delete();
            
            // Create new permissions
            foreach ($validated['city_permissions'] as $permissionData) {
                UserCityPermission::create([
                    'user_id' => $user->id,
                    'city_id' => $permissionData['city_id'],
                    'can_view' => $permissionData['can_view'] ?? true,
                    'can_create' => $permissionData['can_create'] ?? false,
                    'can_edit' => $permissionData['can_edit'] ?? false,
                    'can_delete' => $permissionData['can_delete'] ?? false,
                    'permissions' => $permissionData['module_permissions'] ?? null,
                ]);
            }
        } elseif ($user->isAdmin()) {
            // Admin: remove all permissions (they have access to all)
            $user->cityPermissions()->delete();
        }

        // Log activity
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'updated',
            'model_type' => 'User',
            'model_id' => $user->id,
            'description' => "Updated user: {$user->name}",
        ]);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $name = $user->name;
        $user->delete();

        // Log activity
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'deleted',
            'model_type' => 'User',
            'model_id' => $user->id,
            'description' => "Deleted user: {$name}",
        ]);

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}


