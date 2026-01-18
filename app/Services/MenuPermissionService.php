<?php

namespace App\Services;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class MenuPermissionService
{
    /**
     * Get all menu items from navigation structure
     * This scans the navigation menu and extracts all routes
     */
    public static function getMenuStructure(): array
    {
        return [
            'logistics' => [
                'label' => 'S2E Logistics',
                'routes' => [
                    'logistics.initial-setup' => ['label' => 'Initial Setup', 'actions' => ['view', 'edit']],
                    'bookings.index' => ['label' => 'Booking - List', 'actions' => ['view']],
                    'bookings.create' => ['label' => 'Booking - Add', 'actions' => ['create']],
                    'bookings.edit' => ['label' => 'Booking - Edit', 'actions' => ['edit']],
                    'bookings.show' => ['label' => 'Booking - View', 'actions' => ['view']],
                    'bookings.destroy' => ['label' => 'Booking - Delete', 'actions' => ['delete']],
                    'shipments.index' => ['label' => 'C/N Entry - List', 'actions' => ['view']],
                    'shipments.create' => ['label' => 'C/N Entry - Add', 'actions' => ['create']],
                    'shipments.edit' => ['label' => 'C/N Entry - Edit', 'actions' => ['edit']],
                    'shipments.show' => ['label' => 'C/N Entry - View', 'actions' => ['view']],
                    'shipments.destroy' => ['label' => 'C/N Entry - Delete', 'actions' => ['delete']],
                    'vehicle-load-plans.index' => ['label' => 'Vehicle Load Plan - List', 'actions' => ['view']],
                    'vehicle-load-plans.create' => ['label' => 'Vehicle Load Plan - Add', 'actions' => ['create']],
                    'vehicle-load-plans.edit' => ['label' => 'Vehicle Load Plan - Edit', 'actions' => ['edit']],
                    'vehicle-load-plans.show' => ['label' => 'Vehicle Load Plan - View', 'actions' => ['view']],
                    'vehicle-load-plans.destroy' => ['label' => 'Vehicle Load Plan - Delete', 'actions' => ['delete']],
                    'vehicle-load-plans.received' => ['label' => 'Vehicle Load Plan Received', 'actions' => ['view']],
                    'delivery-sheets.index' => ['label' => 'Delivery Sheet - List', 'actions' => ['view']],
                    'delivery-sheets.create' => ['label' => 'Delivery Sheet - Add', 'actions' => ['create']],
                    'delivery-sheets.edit' => ['label' => 'Delivery Sheet - Edit', 'actions' => ['edit']],
                    'delivery-sheets.show' => ['label' => 'Delivery Sheet - View', 'actions' => ['view']],
                    'delivery-sheets.destroy' => ['label' => 'Delivery Sheet - Delete', 'actions' => ['delete']],
                    'invoices.index' => ['label' => 'Invoices - List', 'actions' => ['view']],
                    'invoices.create' => ['label' => 'Invoices - Add', 'actions' => ['create']],
                    'invoices.edit' => ['label' => 'Invoices - Edit', 'actions' => ['edit']],
                    'invoices.show' => ['label' => 'Invoices - View', 'actions' => ['view']],
                    'invoices.destroy' => ['label' => 'Invoices - Delete', 'actions' => ['delete']],
                    'pickup-sheets.index' => ['label' => 'Pickup Sheet - List', 'actions' => ['view']],
                    'pickup-sheets.create' => ['label' => 'Pickup Sheet - Add', 'actions' => ['create']],
                    'pickup-sheets.edit' => ['label' => 'Pickup Sheet - Edit', 'actions' => ['edit']],
                    'pickup-sheets.show' => ['label' => 'Pickup Sheet - View', 'actions' => ['view']],
                    'pickup-sheets.destroy' => ['label' => 'Pickup Sheet - Delete', 'actions' => ['delete']],
                    'logistics.other-cn-expense-sheet' => ['label' => 'Other C/N Expense Sheet', 'actions' => ['view', 'edit']],
                    'logistics.cn-delivery-reference-no' => ['label' => 'C/N Delivery Reference No', 'actions' => ['view', 'edit']],
                    'logistics.party-fuel-rates' => ['label' => 'Party Fuel Rates for C/N', 'actions' => ['view', 'edit']],
                ],
            ],
            'logistics_reports' => [
                'label' => 'Logistics Reports',
                'routes' => [
                    'reports.cn-detail' => ['label' => 'C/Ns Detail', 'actions' => ['view', 'export', 'print']],
                    'reports.list-of-invoices' => ['label' => 'List of Invoices', 'actions' => ['view', 'export', 'print']],
                    'reports.cn-status' => ['label' => 'C/N Status', 'actions' => ['view', 'export', 'print']],
                    'reports.cn-profit-loss' => ['label' => 'C/N Profit Loss', 'actions' => ['view', 'export', 'print']],
                    'reports.city-wise-profit-loss' => ['label' => 'City-wise Profit Loss', 'actions' => ['view', 'export', 'print']],
                    'reports.shipper-wise-profit-loss' => ['label' => 'Shipper-wise Profit Loss', 'actions' => ['view', 'export', 'print']],
                    'reports.delivery-cn-detail' => ['label' => 'Delivery CN Detail', 'actions' => ['view', 'export', 'print']],
                    'reports.stock-in-transit' => ['label' => 'Stock in Transit', 'actions' => ['view', 'export', 'print']],
                    'reports.cn-in-stock' => ['label' => 'C/N In-Stock', 'actions' => ['view', 'export', 'print']],
                    'reports.vehicle-usage' => ['label' => 'Vehicle Usage', 'actions' => ['view', 'export', 'print']],
                    'reports.driver-performance' => ['label' => 'Driver Performance', 'actions' => ['view', 'export', 'print']],
                ],
            ],
            'finance' => [
                'label' => 'Finance',
                'routes' => [
                    'invoices.index' => ['label' => 'Invoices - List', 'actions' => ['view']],
                    'invoices.create' => ['label' => 'Invoices - Add', 'actions' => ['create']],
                    'invoices.edit' => ['label' => 'Invoices - Edit', 'actions' => ['edit']],
                    'invoices.show' => ['label' => 'Invoices - View', 'actions' => ['view']],
                    'invoices.destroy' => ['label' => 'Invoices - Delete', 'actions' => ['delete']],
                    'payments.index' => ['label' => 'Payments - List', 'actions' => ['view']],
                    'payments.create' => ['label' => 'Payments - Add', 'actions' => ['create']],
                    'payments.edit' => ['label' => 'Payments - Edit', 'actions' => ['edit']],
                    'payments.show' => ['label' => 'Payments - View', 'actions' => ['view']],
                    'payments.destroy' => ['label' => 'Payments - Delete', 'actions' => ['delete']],
                ],
            ],
            'finance_reports' => [
                'label' => 'Finance Reports',
                'routes' => [
                    'reports.list-of-invoices' => ['label' => 'List of Invoices', 'actions' => ['view', 'export', 'print']],
                    'reports.list-of-pending-invoices' => ['label' => 'List of Pending Invoices', 'actions' => ['view', 'export', 'print']],
                    'reports.list-of-missing-cn-nos' => ['label' => 'List of Missing C/N Nos.', 'actions' => ['view', 'export', 'print']],
                    'reports.group-party-outstanding' => ['label' => 'Group/Party Outstanding with S/Tax', 'actions' => ['view', 'export', 'print']],
                    'reports.list-of-city-codes' => ['label' => 'List of City Codes', 'actions' => ['view', 'export', 'print']],
                    'reports.list-of-vehicle-types' => ['label' => 'List of Vehicle Types', 'actions' => ['view', 'export', 'print']],
                ],
            ],
            'purchases' => [
                'label' => 'Purchases',
                'routes' => [
                    'purchases.index' => ['label' => 'Purchases - List', 'actions' => ['view']],
                    'purchases.create' => ['label' => 'Purchases - Add', 'actions' => ['create']],
                    'purchases.edit' => ['label' => 'Purchases - Edit', 'actions' => ['edit']],
                    'purchases.show' => ['label' => 'Purchases - View', 'actions' => ['view']],
                    'purchases.destroy' => ['label' => 'Purchases - Delete', 'actions' => ['delete']],
                ],
            ],
            'payroll' => [
                'label' => 'Payroll',
                'routes' => [
                    'payroll.departments' => ['label' => 'Department Codes', 'actions' => ['view', 'create', 'edit', 'delete']],
                    'payroll.designations' => ['label' => 'Designation Codes', 'actions' => ['view', 'create', 'edit', 'delete']],
                    'payroll.employee-master' => ['label' => 'Employee Master File', 'actions' => ['view', 'create', 'edit', 'delete']],
                    'payroll.loans' => ['label' => 'Loan Master File', 'actions' => ['view', 'create', 'edit', 'delete']],
                    'payroll.deductions-allowances' => ['label' => 'Monthly Deduction/Allowances', 'actions' => ['view', 'create', 'edit', 'delete']],
                    'payroll.authorized-leaves' => ['label' => 'Authorized Leaves', 'actions' => ['view', 'create', 'edit', 'delete']],
                    'payroll.monthly-payroll-processing' => ['label' => 'Monthly Payroll Processing', 'actions' => ['view', 'process']],
                    'payrolls.index' => ['label' => 'Payroll Records', 'actions' => ['view', 'export', 'print']],
                ],
                'submenus' => [
                    'payroll_reports' => [
                        'label' => 'Payroll Reports',
                        'routes' => [
                            'reports.list-of-employees' => ['label' => 'List of Employees', 'actions' => ['view', 'export', 'print']],
                            'reports.list-of-monthly-deduction-allowances' => ['label' => 'List of Monthly Deduction/Allowances', 'actions' => ['view', 'export', 'print']],
                            'reports.employees-authorized-leaves-detail' => ['label' => 'Employee\'s Authorized Leaves Detail', 'actions' => ['view', 'export', 'print']],
                            'reports.employees-leaves-status' => ['label' => 'Employee\'s Leaves Status', 'actions' => ['view', 'export', 'print']],
                            'reports.department-wise-monthly-payroll-register' => ['label' => 'Department-wise Monthly Payroll Register', 'actions' => ['view', 'export', 'print']],
                        ],
                    ],
                ],
            ],
            'admin' => [
                'label' => 'Admin',
                'routes' => [
                    'users.index' => ['label' => 'Users - List', 'actions' => ['view']],
                    'users.create' => ['label' => 'Users - Add', 'actions' => ['create']],
                    'users.edit' => ['label' => 'Users - Edit', 'actions' => ['edit']],
                    'users.show' => ['label' => 'Users - View', 'actions' => ['view']],
                    'users.destroy' => ['label' => 'Users - Delete', 'actions' => ['delete']],
                    'employees.index' => ['label' => 'Employees - List', 'actions' => ['view']],
                    'employees.create' => ['label' => 'Employees - Add', 'actions' => ['create']],
                    'employees.edit' => ['label' => 'Employees - Edit', 'actions' => ['edit']],
                    'employees.show' => ['label' => 'Employees - View', 'actions' => ['view']],
                    'employees.destroy' => ['label' => 'Employees - Delete', 'actions' => ['delete']],
                ],
            ],
            'system' => [
                'label' => 'System',
                'routes' => [
                    'system.user-roles' => ['label' => 'User Roles', 'actions' => ['view', 'edit']],
                    'system.change-password' => ['label' => 'Change Password', 'actions' => ['view', 'edit']],
                    'system.change-year' => ['label' => 'Change Year', 'actions' => ['view', 'edit']],
                    'system.initialize-data' => ['label' => 'Initialize Data', 'actions' => ['view', 'process']],
                    'system.data-processing' => ['label' => 'Data Processing', 'actions' => ['view', 'process']],
                    'system.payroll-processing-final' => ['label' => 'Payroll Processing (FINAL)', 'actions' => ['view', 'process']],
                    'system.optimization' => ['label' => 'System Optimization', 'actions' => ['view', 'process']],
                    'system.unvoid-cn' => ['label' => 'Un-Void C/N', 'actions' => ['view', 'process']],
                    'system.email-settings' => ['label' => 'E-mail Setting', 'actions' => ['view', 'edit']],
                    'system.inter-branches-jv' => ['label' => 'Inter Branches J.V Code', 'actions' => ['view', 'edit']],
                    'system.unpost-data' => ['label' => 'Un-Post Data', 'actions' => ['view', 'process']],
                ],
            ],
        ];
    }

    /**
     * Get flattened permission list for UI
     */
    public static function getFlattenedPermissions(): array
    {
        $structure = self::getMenuStructure();
        $permissions = [];

        foreach ($structure as $menuKey => $menu) {
            // Main menu permission
            $permissions[$menuKey] = [
                'type' => 'menu',
                'label' => $menu['label'],
                'icon' => $menu['icon'] ?? null,
                'children' => [],
            ];

            // Routes in main menu
            if (isset($menu['routes'])) {
                foreach ($menu['routes'] as $routeName => $routeInfo) {
                    $permissionKey = $menuKey . '.' . $routeName;
                    $permissions[$permissionKey] = [
                        'type' => 'route',
                        'label' => $routeInfo['label'],
                        'parent' => $menuKey,
                        'actions' => $routeInfo['actions'] ?? ['view'],
                    ];
                    $permissions[$menuKey]['children'][] = $permissionKey;
                }
            }

            // Submenus
            if (isset($menu['submenus'])) {
                foreach ($menu['submenus'] as $submenuKey => $submenu) {
                    $submenuPermissionKey = $menuKey . '.' . $submenuKey;
                    $permissions[$submenuPermissionKey] = [
                        'type' => 'submenu',
                        'label' => $submenu['label'],
                        'parent' => $menuKey,
                        'children' => [],
                    ];
                    $permissions[$menuKey]['children'][] = $submenuPermissionKey;

                    if (isset($submenu['routes'])) {
                        foreach ($submenu['routes'] as $routeName => $routeInfo) {
                            $permissionKey = $submenuPermissionKey . '.' . $routeName;
                            $permissions[$permissionKey] = [
                                'type' => 'route',
                                'label' => $routeInfo['label'],
                                'parent' => $submenuPermissionKey,
                                'actions' => $routeInfo['actions'] ?? ['view'],
                            ];
                            $permissions[$submenuPermissionKey]['children'][] = $permissionKey;
                        }
                    }
                }
            }
        }

        return $permissions;
    }

    /**
     * Check if user has permission for a route
     */
    public static function userHasPermission($user, string $routeName, string $action = 'view'): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        $permissions = $user->dynamic_permissions ?? [];
        
        // Check exact route permission (format: menu.route or menu.submenu.route)
        $permissionKey = null;
        $structure = self::getMenuStructure();
        
        // Find the permission key for this route
        foreach ($structure as $menuKey => $menu) {
            // Check main menu routes
            if (isset($menu['routes'][$routeName])) {
                $permissionKey = $menuKey . '.' . $routeName;
                break;
            }
            
            // Check submenu routes
            if (isset($menu['submenus'])) {
                foreach ($menu['submenus'] as $submenuKey => $submenu) {
                    if (isset($submenu['routes'][$routeName])) {
                        $permissionKey = $menuKey . '.' . $submenuKey . '.' . $routeName;
                        break 2;
                    }
                }
            }
        }
        
        // Backward compatibility: Check old payroll_reports structure
        if (!$permissionKey && in_array($routeName, [
            'reports.list-of-employees',
            'reports.list-of-monthly-deduction-allowances',
            'reports.employees-authorized-leaves-detail',
            'reports.employees-leaves-status',
            'reports.department-wise-monthly-payroll-register'
        ])) {
            // Try old payroll_reports structure first
            $oldPermissionKey = 'payroll_reports.' . $routeName;
            if (isset($permissions[$oldPermissionKey])) {
                $permissionKey = $oldPermissionKey;
            } else {
                // Try new merged structure
                $permissionKey = 'payroll.payroll_reports.' . $routeName;
            }
        }
        
        // If permission key found, check if action is allowed
        if ($permissionKey && isset($permissions[$permissionKey])) {
            $allowedActions = is_array($permissions[$permissionKey]) 
                ? array_keys(array_filter($permissions[$permissionKey], fn($v) => $v === '1' || $v === true || $v === 'true'))
                : [];
            return in_array($action, $allowedActions);
        }
        
        // Backward compatibility: Check old payroll_reports structure for payroll report routes
        if (in_array($routeName, [
            'reports.list-of-employees',
            'reports.list-of-monthly-deduction-allowances',
            'reports.employees-authorized-leaves-detail',
            'reports.employees-leaves-status',
            'reports.department-wise-monthly-payroll-register'
        ])) {
            // Try old payroll_reports structure first
            $oldPermissionKey = 'payroll_reports.' . $routeName;
            if (isset($permissions[$oldPermissionKey])) {
                $allowedActions = is_array($permissions[$oldPermissionKey]) 
                    ? array_keys(array_filter($permissions[$oldPermissionKey], fn($v) => $v === '1' || $v === true || $v === 'true'))
                    : [];
                return in_array($action, $allowedActions);
            }
            // Try new merged structure
            $newPermissionKey = 'payroll.payroll_reports.' . $routeName;
            if (isset($permissions[$newPermissionKey])) {
                $allowedActions = is_array($permissions[$newPermissionKey]) 
                    ? array_keys(array_filter($permissions[$newPermissionKey], fn($v) => $v === '1' || $v === true || $v === 'true'))
                    : [];
                return in_array($action, $allowedActions);
            }
        }
        
        // Check if parent menu has permission
        $routeParts = explode('.', $routeName);
        if (count($routeParts) > 0) {
            // Try to match by route prefix
            foreach ($permissions as $key => $value) {
                if (str_ends_with($key, '.' . $routeName)) {
                    $allowedActions = is_array($value) 
                        ? array_keys(array_filter($value, fn($v) => $v === '1' || $v === true || $v === 'true'))
                        : [];
                    return in_array($action, $allowedActions);
                }
            }
        }

        return false;
    }
}

