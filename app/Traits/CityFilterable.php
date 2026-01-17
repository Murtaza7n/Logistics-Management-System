<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait CityFilterable
{
    /**
     * Get the current selected city ID from session
     */
    protected function getSelectedCityId(): ?int
    {
        return session('selected_city_id');
    }

    /**
     * Get accessible city IDs for current user
     */
    protected function getAccessibleCityIds(): array
    {
        $user = Auth::user();
        
        if (!$user) {
            return [];
        }

        if ($user->isAdmin()) {
            // Admin can access all active cities
            return \App\Models\City::where('is_active', true)->pluck('city_id')->toArray();
        }

        // Non-admin: get cities from permissions
        return $user->cityPermissions()->pluck('city_id')->toArray();
    }

    /**
     * Apply city filter to a query builder
     */
    protected function applyCityFilter($query, string $cityColumn = 'entry_city')
    {
        $user = Auth::user();
        
        if (!$user) {
            return $query->whereRaw('1 = 0'); // No access if not logged in
        }

        if ($user->isAdmin()) {
            // Admin can see all cities, but filter by selected city if set
            $selectedCityId = $this->getSelectedCityId();
            if ($selectedCityId) {
                return $query->where($cityColumn, $selectedCityId);
            }
            return $query; // Show all if no city selected
        }

        // Non-admin: filter by accessible cities and selected city
        $accessibleCityIds = $this->getAccessibleCityIds();
        $selectedCityId = $this->getSelectedCityId();

        if (empty($accessibleCityIds)) {
            return $query->whereRaw('1 = 0'); // No access
        }

        // If a city is selected and user has access, filter by it
        if ($selectedCityId && in_array($selectedCityId, $accessibleCityIds)) {
            return $query->where($cityColumn, $selectedCityId);
        }

        // Otherwise, show all accessible cities
        return $query->whereIn($cityColumn, $accessibleCityIds);
    }

    /**
     * Check if user can access a specific city
     */
    protected function canAccessCity(?int $cityId): bool
    {
        $user = Auth::user();
        
        if (!$user) {
            return false;
        }

        if ($user->isAdmin()) {
            return true;
        }

        if (!$cityId) {
            return false;
        }

        return $user->hasCityPermission($cityId, 'view');
    }
}

