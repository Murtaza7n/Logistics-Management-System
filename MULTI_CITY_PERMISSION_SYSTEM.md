# Multi-City Permission System Implementation

## Overview
This document describes the implementation of a comprehensive multi-city permission system for the Logistics Management System, allowing permission-based access control across different cities.

## Database Schema

### 1. User City Permissions Table
**Table:** `user_city_permissions`

**Fields:**
- `id` (Primary Key)
- `user_id` (Foreign Key → users.id)
- `city_id` (Foreign Key → cities.city_id)
- `permissions` (JSON) - Module-specific permissions
- `can_view` (Boolean) - Can view data for this city
- `can_create` (Boolean) - Can create records for this city
- `can_edit` (Boolean) - Can edit records for this city
- `can_delete` (Boolean) - Can delete records for this city
- `created_at`, `updated_at` (Timestamps)

**Unique Constraint:** `(user_id, city_id)` - One permission record per user-city combination

### 2. Users Table Update
**Added Field:**
- `primary_city_id` (Foreign Key → cities.city_id, nullable) - User's primary/default city

## Models

### UserCityPermission Model
Located at: `app/Models/UserCityPermission.php`

**Key Methods:**
- `hasModulePermission(string $module, string $action): bool` - Check module-specific permission
- `getAccessibleModules(): array` - Get all modules user can access

### User Model Updates
Located at: `app/Models/User.php`

**New Relationships:**
- `primaryCity()` - Belongs to City
- `cityPermissions()` - Has many UserCityPermission

**New Methods:**
- `accessibleCities()` - Get all cities user can access
- `hasCityPermission(int $cityId, string $action): bool` - Check city permission
- `hasModulePermission(int $cityId, string $module, string $action): bool` - Check module permission
- `getCityPermission(int $cityId): ?UserCityPermission` - Get permission for specific city

## Middleware

### CheckCityPermission Middleware
Located at: `app/Http/Middleware/CheckCityPermission.php`

**Purpose:** Validates user has permission to access a specific city before processing the request.

**Usage:**
```php
Route::middleware(['auth', 'city.permission:view'])->group(function () {
    // Routes requiring city view permission
});
```

**Actions:**
- `view` - Can view data
- `create` - Can create records
- `edit` - Can edit records
- `delete` - Can delete records

## Traits

### CityFilterable Trait
Located at: `app/Traits/CityFilterable.php`

**Purpose:** Provides helper methods for filtering queries by city permissions.

**Key Methods:**
- `getSelectedCityId(): ?int` - Get current selected city from session
- `getAccessibleCityIds(): array` - Get all accessible city IDs
- `applyCityFilter($query, string $cityColumn = 'entry_city')` - Apply city filter to query
- `canAccessCity(?int $cityId): bool` - Check if user can access city

**Usage:**
```php
use App\Traits\CityFilterable;

class ShipmentController extends Controller
{
    use CityFilterable;
    
    public function index()
    {
        $query = Shipment::query();
        $query = $this->applyCityFilter($query, 'entry_city');
        $shipments = $query->get();
        // ...
    }
}
```

## Controllers

### AuthController Updates
- On login, sets default city:
  - Admin: First active city (or null for all access)
  - Non-admin: Primary city or first accessible city

### CityController Updates
- `switchCity(Request $request)` - Switch selected city (with permission check)
- `getAccessibleCities()` - API endpoint to get accessible cities

### UserController Updates
- `create()` - Now includes cities list for permission assignment
- `store()` - Handles city permissions during user creation
- `edit()` - Includes existing permissions for editing
- `update()` - Updates city permissions

### DashboardController
**Status:** Needs update to filter by city

### ShipmentController
**Status:** Needs update to filter by city

### ReportController
**Status:** Needs update to filter by city

## UI Components

### City Selector
**Location:** `resources/views/layouts/app.blade.php`

**Features:**
- Displays in navbar header
- Shows current selected city
- Dropdown to switch cities
- Only shows cities user has access to
- Auto-submits on change

### User Creation/Edit Form
**Location:** `resources/views/users/create.blade.php` and `edit.blade.php`

**Features:**
- Primary city selection
- City permission assignment section
- Per-city permissions:
  - Can View
  - Can Create
  - Can Edit
  - Can Delete
- Module-specific permissions (JSON structure)

## Routes

### New Routes
```php
// City switching (all authenticated users)
Route::post('cities/switch', [CityController::class, 'switchCity'])->name('cities.switch');
Route::get('cities/accessible', [CityController::class, 'getAccessibleCities'])->name('cities.accessible');
```

## Session Management

**Session Key:** `selected_city_id`

**Usage:**
- Set on login
- Updated when user switches city
- Used by all controllers to filter data

## Permission Logic

### Admin Users
- **Access:** All cities (no restrictions)
- **Permissions:** Full access to all modules
- **City Selector:** Shows all active cities

### Non-Admin Users
- **Access:** Only cities with assigned permissions
- **Permissions:** Based on `user_city_permissions` table
- **City Selector:** Shows only accessible cities

### Permission Hierarchy
1. **Admin Check:** If admin, grant access
2. **City Permission Check:** Verify user has permission for city
3. **Action Check:** Verify user has specific action permission (view/create/edit/delete)
4. **Module Check:** Verify user has module-specific permission (if applicable)

## Implementation Status

### ✅ Completed
1. Database migrations
2. Models (User, UserCityPermission, City)
3. Middleware (CheckCityPermission)
4. Trait (CityFilterable)
5. AuthController updates
6. CityController updates
7. UserController updates
8. City selector UI
9. Routes

### ⏳ Pending
1. Update DashboardController to filter by city
2. Update ShipmentController to filter by city
3. Update ReportController to filter by city
4. Update all other controllers to filter by city
5. Create user permission assignment form UI
6. Add backend validation to all city-based operations
7. Update all views to respect city permissions
8. Testing

## Next Steps

1. **Update Controllers:**
   - Apply `CityFilterable` trait to all controllers
   - Use `applyCityFilter()` in all queries
   - Add permission checks in create/edit/delete methods

2. **Create User Permission Form:**
   - Design comprehensive permission assignment UI
   - Include module-specific permissions
   - Add validation

3. **Update Views:**
   - Ensure all data displays respect city filter
   - Hide/disable actions based on permissions
   - Show permission warnings where needed

4. **Testing:**
   - Test admin access (should see all)
   - Test non-admin with single city
   - Test non-admin with multiple cities
   - Test permission restrictions
   - Test city switching

## Security Considerations

1. **Backend Validation:** All permission checks must be server-side
2. **Query Filtering:** Always filter queries by accessible cities
3. **Route Protection:** Use middleware for sensitive operations
4. **Session Security:** Validate city selection on every request
5. **Admin Override:** Ensure admin can access all cities

## Module List

Modules that need city-based filtering:
1. Shipments/CN Entries
2. Customers
3. Vendors
4. Reports (all types)
5. Dashboard
6. Invoices
7. Payments
8. Vehicles (if city-based)
9. Drivers (if city-based)

## Notes

- Admin users bypass all city restrictions
- City permissions are stored per user-city combination
- Module permissions are stored as JSON for flexibility
- Selected city is stored in session for performance
- All queries should use the `CityFilterable` trait for consistency

