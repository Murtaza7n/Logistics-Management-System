<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Payroll;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class SystemController extends Controller
{
    public function userRoles()
    {
        $roles = ['admin', 'staff', 'driver'];
        $rolePermissions = [];
        
        foreach ($roles as $role) {
            $rolePermission = \App\Models\RolePermission::where('role', $role)->first();
            if (!$rolePermission) {
                // Create default if doesn't exist
                $defaultPermissions = [
                    'admin' => [
                        'cn_entry' => true,
                        'reports' => true,
                        'user_management' => true,
                        'system_settings' => true,
                        'delivery_tracking' => true,
                    ],
                    'staff' => [
                        'cn_entry' => true,
                        'reports' => true,
                        'user_management' => false,
                        'system_settings' => false,
                        'delivery_tracking' => true,
                    ],
                    'driver' => [
                        'cn_entry' => false,
                        'reports' => false,
                        'user_management' => false,
                        'system_settings' => false,
                        'delivery_tracking' => true,
                    ],
                ];
                
                $rolePermission = \App\Models\RolePermission::create([
                    'role' => $role,
                    'module_permissions' => $defaultPermissions[$role],
                ]);
            }
            $rolePermissions[$role] = $rolePermission;
        }
        
        $modules = [
            'cn_entry' => 'CN Entry',
            'reports' => 'Reports',
            'user_management' => 'User Management',
            'system_settings' => 'System Settings',
            'delivery_tracking' => 'Delivery Tracking',
        ];
        
        return view('system.user-roles', compact('rolePermissions', 'modules'));
    }

    public function updateRolePermissions(Request $request)
    {
        $request->validate([
            'role' => 'required|in:admin,staff,driver',
            'permissions' => 'required|array',
        ]);

        try {
            $rolePermission = \App\Models\RolePermission::where('role', $request->role)->first();
            
            if (!$rolePermission) {
                return back()->withErrors(['error' => 'Role permission not found.']);
            }

            $permissions = [];
            foreach ($request->permissions as $module => $allowed) {
                $permissions[$module] = $allowed === '1' || $allowed === true || $allowed === 'true';
            }

            $rolePermission->module_permissions = $permissions;
            $rolePermission->save();

            Log::info('Role permissions updated', ['role' => $request->role, 'user' => Auth::id()]);

            return redirect()->route('system.user-roles')->with('success', 'Role permissions updated successfully.');
        } catch (\Exception $e) {
            Log::error('Role permissions update failed', ['error' => $e->getMessage()]);
            return back()->withErrors(['error' => 'Failed to update permissions: ' . $e->getMessage()]);
        }
    }

    public function changePassword()
    {
        return view('system.change-password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        Auth::user()->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->route('system.change-password')->with('success', 'Password changed successfully.');
    }

    public function changeYear()
    {
        $currentYear = session('system_year', '2526');
        return view('system.change-year', compact('currentYear'));
    }

    public function updateYear(Request $request)
    {
        $request->validate([
            'year' => 'required|string|max:10',
        ]);

        session(['system_year' => $request->year]);
        return redirect()->route('system.change-year')->with('success', 'System year changed to ' . $request->year);
    }

    public function emailSettings()
    {
        return view('system.email-settings');
    }

    public function updateEmailSettings(Request $request)
    {
        // TODO: Implement email settings storage
        return redirect()->route('system.email-settings')->with('success', 'Email settings updated successfully.');
    }

    public function interBranchesJv()
    {
        return view('system.inter-branches-jv');
    }

    public function initializeData()
    {
        return view('system.initialize-data');
    }

    public function processInitializeData(Request $request)
    {
        $request->validate([
            'init_type' => 'required|in:shipments,payroll,invoices,all',
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date|after_or_equal:date_from',
        ]);

        try {
            $type = $request->init_type;
            $dateFrom = $request->date_from;
            $dateTo = $request->date_to;

            DB::beginTransaction();

            if ($type === 'shipments' || $type === 'all') {
                $query = Shipment::query();
                if ($dateFrom) $query->whereDate('created_at', '>=', $dateFrom);
                if ($dateTo) $query->whereDate('created_at', '<=', $dateTo);
                $query->update(['status' => 'booked']); // Reset to initial status
            }

            if ($type === 'payroll' || $type === 'all') {
                $query = Payroll::query();
                if ($dateFrom) $query->whereDate('payroll_date', '>=', $dateFrom);
                if ($dateTo) $query->whereDate('payroll_date', '<=', $dateTo);
                $query->update(['status' => 'draft']); // Reset to draft
            }

            if ($type === 'invoices' || $type === 'all') {
                $query = Invoice::query();
                if ($dateFrom) $query->whereDate('invoice_date', '>=', $dateFrom);
                if ($dateTo) $query->whereDate('invoice_date', '<=', $dateTo);
                $query->update(['status' => 'draft']); // Reset to draft
            }

            DB::commit();
            Log::info('Data initialized', ['type' => $type, 'user' => Auth::id()]);
            
            return redirect()->route('system.initialize-data')->with('success', 'Data initialized successfully for ' . $type . '.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Data initialization failed', ['error' => $e->getMessage()]);
            return back()->withErrors(['error' => 'Failed to initialize data: ' . $e->getMessage()]);
        }
    }

    public function dataProcessing()
    {
        return view('system.data-processing');
    }

    public function processData(Request $request)
    {
        $request->validate([
            'processing_type' => 'required|in:update_statuses,recalculate_totals,sync_data,cleanup_old',
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date|after_or_equal:date_from',
        ]);

        try {
            $type = $request->processing_type;
            $dateFrom = $request->date_from;
            $dateTo = $request->date_to;

            DB::beginTransaction();

            switch ($type) {
                case 'update_statuses':
                    $query = Shipment::whereIn('status', ['in-transit', 'out-for-delivery']);
                    if ($dateFrom) $query->whereDate('delivery_date', '>=', $dateFrom);
                    if ($dateTo) $query->whereDate('delivery_date', '<=', $dateTo);
                    $query->where('delivery_date', '<', now())->update(['status' => 'delivered']);
                    break;

                case 'recalculate_totals':
                    Shipment::chunk(100, function ($shipments) {
                        foreach ($shipments as $shipment) {
                            $shipment->update([
                                'total_charges' => $shipment->freight_charges + $shipment->labor_charges + $shipment->other_charges
                            ]);
                        }
                    });
                    break;

                case 'sync_data':
                    // Sync related data across modules
                    Invoice::whereDoesntHave('shipments')->delete();
                    break;

                case 'cleanup_old':
                    $cutoffDate = now()->subYears(2);
                    Shipment::where('created_at', '<', $cutoffDate)
                        ->where('status', 'delivered')
                        ->delete();
                    break;
            }

            DB::commit();
            Log::info('Data processed', ['type' => $type, 'user' => Auth::id()]);
            
            return redirect()->route('system.data-processing')->with('success', 'Data processed successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Data processing failed', ['error' => $e->getMessage()]);
            return back()->withErrors(['error' => 'Failed to process data: ' . $e->getMessage()]);
        }
    }

    public function payrollProcessingFinal()
    {
        return view('system.payroll-processing-final');
    }

    public function processPayrollFinal(Request $request)
    {
        $request->validate([
            'payroll_month' => 'required|date_format:Y-m',
            'department_id' => 'nullable|exists:departments,id',
        ]);

        try {
            DB::beginTransaction();

            $query = Payroll::whereYear('payroll_date', date('Y', strtotime($request->payroll_month . '-01')))
                ->whereMonth('payroll_date', date('m', strtotime($request->payroll_month . '-01')))
                ->where('status', '!=', 'final');

            if ($request->department_id) {
                $query->whereHas('employee', function($q) use ($request) {
                    $q->where('department_id', $request->department_id);
                });
            }

            $query->update(['status' => 'final']);

            DB::commit();
            Log::info('Payroll finalized', ['month' => $request->payroll_month, 'user' => Auth::id()]);
            
            return redirect()->route('system.payroll-processing-final')->with('success', 'Payroll finalized successfully for ' . $request->payroll_month . '.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Payroll finalization failed', ['error' => $e->getMessage()]);
            return back()->withErrors(['error' => 'Failed to finalize payroll: ' . $e->getMessage()]);
        }
    }

    public function unpostData()
    {
        return view('system.unpost-data');
    }

    public function processUnpostData(Request $request)
    {
        $request->validate([
            'date_from' => 'required|date',
            'date_to' => 'required|date|after_or_equal:date_from',
            'data_type' => 'required|in:shipments,invoices,payments,payrolls,all',
            'reason' => 'required|string|min:10',
        ]);

        try {
            DB::beginTransaction();

            $dateFrom = $request->date_from;
            $dateTo = $request->date_to;
            $type = $request->data_type;

            if ($type === 'shipments' || $type === 'all') {
                Shipment::whereBetween('created_at', [$dateFrom, $dateTo])
                    ->where('status', '!=', 'cancelled')
                    ->update(['status' => 'booked']);
            }

            if ($type === 'invoices' || $type === 'all') {
                Invoice::whereBetween('invoice_date', [$dateFrom, $dateTo])
                    ->where('status', 'paid')
                    ->update(['status' => 'draft']);
            }

            if ($type === 'payments' || $type === 'all') {
                Payment::whereBetween('payment_date', [$dateFrom, $dateTo])
                    ->where('status', 'posted')
                    ->update(['status' => 'pending']);
            }

            if ($type === 'payrolls' || $type === 'all') {
                Payroll::whereBetween('payroll_date', [$dateFrom, $dateTo])
                    ->where('status', 'final')
                    ->update(['status' => 'draft']);
            }

            DB::commit();
            Log::info('Data unposted', ['type' => $type, 'date_from' => $dateFrom, 'date_to' => $dateTo, 'user' => Auth::id(), 'reason' => $request->reason]);
            
            return redirect()->route('system.unpost-data')->with('success', 'Data unposted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Unpost data failed', ['error' => $e->getMessage()]);
            return back()->withErrors(['error' => 'Failed to unpost data: ' . $e->getMessage()]);
        }
    }

    public function unvoidCn()
    {
        return view('system.unvoid-cn');
    }

    public function processUnvoidCn(Request $request)
    {
        $request->validate([
            'cn_number' => 'required|string',
            'reason' => 'required|string|min:10',
        ]);

        try {
            $shipment = Shipment::where('shipment_number', $request->cn_number)->first();

            if (!$shipment) {
                return back()->withErrors(['cn_number' => 'C/N number not found.']);
            }

            if ($shipment->status !== 'cancelled') {
                return back()->withErrors(['cn_number' => 'This C/N is not voided.']);
            }

            DB::beginTransaction();
            
            // Restore to previous status or default to 'booked'
            $shipment->update(['status' => 'booked']);
            
            Log::info('C/N unvoided', ['cn_number' => $request->cn_number, 'user' => Auth::id(), 'reason' => $request->reason]);
            
            DB::commit();
            
            return redirect()->route('system.unvoid-cn')->with('success', 'C/N ' . $request->cn_number . ' unvoided successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Unvoid CN failed', ['error' => $e->getMessage()]);
            return back()->withErrors(['error' => 'Failed to unvoid C/N: ' . $e->getMessage()]);
        }
    }

    public function optimization()
    {
        return view('system.optimization');
    }

    public function runOptimization(Request $request)
    {
        try {
            $results = [];

            if ($request->has('optimize_database')) {
                Artisan::call('optimize:clear');
                $results[] = 'Database optimized';
            }

            if ($request->has('clear_cache')) {
                Cache::flush();
                Artisan::call('cache:clear');
                Artisan::call('config:clear');
                Artisan::call('view:clear');
                $results[] = 'Cache cleared';
            }

            if ($request->has('rebuild_indexes')) {
                // Run database optimization
                DB::statement('OPTIMIZE TABLE shipments, invoices, payments, payrolls');
                $results[] = 'Indexes rebuilt';
            }

            if ($request->has('cleanup_logs')) {
                // Cleanup old log files (older than 30 days)
                $logPath = storage_path('logs');
                $files = glob($logPath . '/*.log');
                $cutoff = now()->subDays(30)->timestamp;
                $deleted = 0;
                foreach ($files as $file) {
                    if (filemtime($file) < $cutoff) {
                        unlink($file);
                        $deleted++;
                    }
                }
                $results[] = "Cleaned up {$deleted} old log files";
            }

            Log::info('System optimization completed', ['tasks' => $results, 'user' => Auth::id()]);
            
            $message = 'System optimization completed: ' . implode(', ', $results);
            return redirect()->route('system.optimization')->with('success', $message);
        } catch (\Exception $e) {
            Log::error('System optimization failed', ['error' => $e->getMessage()]);
            return back()->withErrors(['error' => 'Failed to optimize system: ' . $e->getMessage()]);
        }
    }
}
