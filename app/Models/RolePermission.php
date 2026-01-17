<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    use HasFactory;

    protected $fillable = [
        'role',
        'module_permissions',
    ];

    protected $casts = [
        'module_permissions' => 'array',
    ];

    /**
     * Get permission for a specific module
     */
    public function hasModulePermission(string $module): bool
    {
        return isset($this->module_permissions[$module]) && $this->module_permissions[$module] === true;
    }

    /**
     * Update module permission
     */
    public function updateModulePermission(string $module, bool $allowed): void
    {
        $permissions = $this->module_permissions ?? [];
        $permissions[$module] = $allowed;
        $this->module_permissions = $permissions;
        $this->save();
    }

    /**
     * Get all allowed modules for this role
     */
    public function getAllowedModules(): array
    {
        return array_keys(array_filter($this->module_permissions ?? [], fn($value) => $value === true));
    }
}
