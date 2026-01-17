<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\RolePermission;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'contact',
        'password',
        'role',
        'primary_city_id',
        'menu_permissions',
        'dynamic_permissions',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'menu_permissions' => 'array',
            'dynamic_permissions' => 'array',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isStaff(): bool
    {
        return $this->role === 'staff';
    }

    public function isDriver(): bool
    {
        return $this->role === 'driver';
    }

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }

    /**
     * Get the primary city for this user
     */
    public function primaryCity()
    {
        return $this->belongsTo(City::class, 'primary_city_id', 'city_id');
    }

    /**
     * Get all city permissions for this user
     */
    public function cityPermissions()
    {
        return $this->hasMany(UserCityPermission::class);
    }

    /**
     * Get all cities this user has access to
     */
    public function accessibleCities()
    {
        if ($this->isAdmin()) {
            return City::where('is_active', true)->get();
        }
        
        return City::whereIn('city_id', $this->cityPermissions()->pluck('city_id'))
            ->where('is_active', true)
            ->get();
    }

    /**
     * Check if user has permission for a city
     */
    public function hasCityPermission(int $cityId, string $action = 'view'): bool
    {
        if ($this->isAdmin()) {
            return true;
        }

        $permission = $this->cityPermissions()->where('city_id', $cityId)->first();
        
        if (!$permission) {
            return false;
        }

        return match($action) {
            'view' => $permission->can_view,
            'create' => $permission->can_create,
            'edit' => $permission->can_edit,
            'delete' => $permission->can_delete,
            default => false,
        };
    }

    /**
     * Check if user has module permission for a city
     */
    public function hasModulePermission(int $cityId, string $module, string $action): bool
    {
        if ($this->isAdmin()) {
            return true;
        }

        $permission = $this->cityPermissions()->where('city_id', $cityId)->first();
        
        if (!$permission) {
            return false;
        }

        return $permission->hasModulePermission($module, $action);
    }

    /**
     * Get permission record for a specific city
     */
    public function getCityPermission(int $cityId): ?UserCityPermission
    {
        return $this->cityPermissions()->where('city_id', $cityId)->first();
    }

    /**
     * Check if user has access to a specific menu/module
     */
    public function hasMenuPermission(string $menu): bool
    {
        // Admin has access to all menus
        if ($this->isAdmin()) {
            return true;
        }

        // Check user-specific menu permissions
        if ($this->menu_permissions && isset($this->menu_permissions[$menu])) {
            return $this->menu_permissions[$menu] === true;
        }

        // Fallback to role-based permissions
        $rolePermission = RolePermission::where('role', $this->role)->first();
        if ($rolePermission) {
            // Map menu names to module names
            $menuToModule = [
                'logistics' => 'cn_entry',
                'logistics_reports' => 'reports',
                'finance' => 'cn_entry',
                'finance_reports' => 'reports',
                'payroll' => 'cn_entry',
                'payroll_reports' => 'reports',
                'system' => 'system_settings',
            ];
            
            $module = $menuToModule[$menu] ?? $menu;
            return $rolePermission->hasModulePermission($module);
        }

        return false;
    }

    /**
     * Get all allowed menus for this user
     */
    public function getAllowedMenus(): array
    {
        if ($this->isAdmin()) {
            return ['logistics', 'logistics_reports', 'finance', 'finance_reports', 'payroll', 'payroll_reports', 'system'];
        }

        if ($this->menu_permissions) {
            return array_keys(array_filter($this->menu_permissions, fn($value) => $value === true));
        }

        return [];
    }

    /**
     * Check if user has dynamic permission for a route
     */
    public function hasDynamicPermission(string $routeName, string $action = 'view'): bool
    {
        return \App\Services\MenuPermissionService::userHasPermission($this, $routeName, $action);
    }
}


