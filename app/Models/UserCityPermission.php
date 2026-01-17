<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCityPermission extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'city_id',
        'permissions',
        'can_view',
        'can_create',
        'can_edit',
        'can_delete',
    ];

    protected $casts = [
        'permissions' => 'array',
        'can_view' => 'boolean',
        'can_create' => 'boolean',
        'can_edit' => 'boolean',
        'can_delete' => 'boolean',
    ];

    /**
     * Get the user that owns this permission
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the city for this permission
     */
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'city_id');
    }

    /**
     * Check if user has a specific permission for a module
     */
    public function hasModulePermission(string $module, string $action): bool
    {
        if (!$this->permissions || !isset($this->permissions[$module])) {
            return false;
        }

        return in_array($action, $this->permissions[$module]);
    }

    /**
     * Get all modules this user has access to for this city
     */
    public function getAccessibleModules(): array
    {
        return $this->permissions ? array_keys($this->permissions) : [];
    }
}
