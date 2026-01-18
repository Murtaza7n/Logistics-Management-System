<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use App\Models\Invoice;
use App\Models\Payroll;
use App\Models\Customer;
use App\Models\Vendor;
use App\Models\Vehicle;
use App\Models\Driver;
use App\Models\Department;
use App\Models\Designation;
use App\Models\MonthlyDeductionAllowance;
use App\Models\AuthorizedLeave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    public function shipments(Request $request)
    {
        $query = Shipment::with(['customer', 'vendor', 'vehicle', 'driver']);

        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }

        $shipments = $query->get();

        $summary = [
            'total' => $shipments->count(),
            'total_freight' => $shipments->sum('freight_charges'),
            'total_labor' => $shipments->sum('labor_charges'),
            'total_other' => $shipments->sum('other_charges'),
            'grand_total' => $shipments->sum(function ($s) {
                return $s->freight_charges + $s->labor_charges + $s->other_charges;
            }),
        ];

        if ($request->filled('export') && $request->export === 'pdf') {
            $pdf = Pdf::loadView('reports.shipments_pdf', compact('shipments', 'summary'));
            return $pdf->download('shipments_report_' . date('Y-m-d') . '.pdf');
        }

        if ($request->filled('export') && $request->export === 'excel') {
            // Excel export would go here
            return redirect()->back()->with('info', 'Excel export feature coming soon.');
        }

        $customers = Customer::where('status', 'active')->get();

        return view('reports.shipments', compact('shipments', 'summary', 'customers'));
    }

    public function revenue(Request $request)
    {
        $query = Invoice::with(['customer', 'vendor']);

        if ($request->filled('from_date')) {
            $query->whereDate('invoice_date', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('invoice_date', '<=', $request->to_date);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $invoices = $query->get();

        $summary = [
            'total_invoices' => $invoices->count(),
            'total_amount' => $invoices->sum('total'),
            'total_tax' => $invoices->sum('tax_amount'),
            'total_paid' => $invoices->sum(function ($inv) {
                return $inv->payments()->sum('amount_paid');
            }),
            'total_pending' => $invoices->sum('total') - $invoices->sum(function ($inv) {
                return $inv->payments()->sum('amount_paid');
            }),
        ];

        if ($request->filled('export') && $request->export === 'pdf') {
            $pdf = Pdf::loadView('reports.revenue_pdf', compact('invoices', 'summary'));
            return $pdf->download('revenue_report_' . date('Y-m-d') . '.pdf');
        }

        return view('reports.revenue', compact('invoices', 'summary'));
    }

    public function payroll(Request $request)
    {
        $query = Payroll::with('employee');

        if ($request->filled('month')) {
            $query->where('month', $request->month);
        }

        if ($request->filled('emp_id')) {
            $query->where('emp_id', $request->emp_id);
        }

        $payrolls = $query->get();

        $summary = [
            'total_employees' => $payrolls->unique('emp_id')->count(),
            'total_basic_salary' => $payrolls->sum('basic_salary'),
            'total_overtime' => $payrolls->sum('overtime'),
            'total_bonus' => $payrolls->sum('bonus'),
            'total_deductions' => $payrolls->sum('deductions'),
            'total_net_salary' => $payrolls->sum('net_salary'),
        ];

        if ($request->filled('export') && $request->export === 'pdf') {
            $pdf = Pdf::loadView('reports.payroll_pdf', compact('payrolls', 'summary'));
            return $pdf->download('payroll_report_' . date('Y-m-d') . '.pdf');
        }

        $employees = \App\Models\Employee::where('status', 'active')->get();

        return view('reports.payroll', compact('payrolls', 'summary', 'employees'));
    }

    // ============ PAYROLL REPORTS ============
    
    public function listOfEmployees(Request $request)
    {
        $query = \App\Models\Employee::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }

        if ($request->filled('designation_id')) {
            $query->where('designation_id', $request->designation_id);
        }

        $employees = $query->orderBy('name')->get();
        $departments = \App\Models\Department::where('is_active', true)->orderBy('name')->get();
        $designations = \App\Models\Designation::where('is_active', true)->orderBy('name')->get();

        return view('reports.list_of_employees', compact('employees', 'departments', 'designations'));
    }

    public function listOfMonthlyDeductionAllowances(Request $request)
    {
        $query = \App\Models\MonthlyDeductionAllowance::with('employee');

        if ($request->filled('month')) {
            $query->where('month', $request->month);
        }

        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }

        if ($request->filled('employee_id')) {
            $query->where('employee_id', $request->employee_id);
        }

        $deductionsAllowances = $query->orderBy('year', 'desc')->orderBy('month', 'desc')->get();
        $employees = \App\Models\Employee::where('status', 'active')->orderBy('name')->get();

        return view('reports.list_of_monthly_deduction_allowances', compact('deductionsAllowances', 'employees'));
    }

    public function employeesAuthorizedLeavesDetail(Request $request)
    {
        $query = \App\Models\AuthorizedLeave::with('employee');

        if ($request->filled('employee_id')) {
            $query->where('employee_id', $request->employee_id);
        }

        if ($request->filled('leave_type')) {
            $query->where('leave_type', $request->leave_type);
        }

        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }

        $leaves = $query->orderBy('year', 'desc')->orderBy('leave_type')->get();
        $employees = \App\Models\Employee::where('status', 'active')->orderBy('name')->get();

        return view('reports.employees_authorized_leaves_detail', compact('leaves', 'employees'));
    }

    public function employeesLeavesStatus(Request $request)
    {
        $query = \App\Models\AuthorizedLeave::with('employee');

        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }

        $leaves = $query->orderBy('employee_id')->orderBy('leave_type')->get();
        
        // Group by employee
        $employeeLeaves = $leaves->groupBy('employee_id')->map(function($group) {
            $employee = $group->first()->employee;
            return [
                'employee' => $employee,
                'leaves' => $group,
                'total_remaining' => $group->sum('remaining_leaves'),
            ];
        });

        return view('reports.employees_leaves_status', compact('employeeLeaves'));
    }

    public function departmentWiseMonthlyPayrollRegister(Request $request)
    {
        $query = Payroll::with(['employee']);

        if ($request->filled('month')) {
            $query->where('month', $request->month);
        }

        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }

        if ($request->filled('department_id')) {
            $query->whereHas('employee', function($q) use ($request) {
                $q->where('department_id', $request->department_id);
            });
        }

        $payrolls = $query->get();
        
        // Group by department
        $departmentWise = $payrolls->groupBy(function($payroll) {
            return $payroll->employee->department_id ?? 'no-department';
        })->map(function($group, $deptId) {
            $dept = $deptId !== 'no-department' ? \App\Models\Department::find($deptId) : null;
            return [
                'department' => $dept,
                'payrolls' => $group,
                'total_employees' => $group->unique('emp_id')->count(),
                'total_net_salary' => $group->sum('net_salary'),
            ];
        });

        $departments = \App\Models\Department::where('is_active', true)->orderBy('name')->get();

        return view('reports.department_wise_monthly_payroll_register', compact('departmentWise', 'departments'));
    }

    public function vehicleUsage(Request $request)
    {
        $query = Vehicle::with(['shipments', 'driver']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $vehicles = $query->get()->map(function ($vehicle) {
            $vehicle->total_shipments = $vehicle->shipments()->count();
            $totalRevenue = $vehicle->shipments()->get()->sum(function ($s) {
                return ($s->freight_charges ?? 0) + ($s->labor_charges ?? 0) + ($s->other_charges ?? 0);
            });
            $vehicle->total_revenue = $totalRevenue;
            return $vehicle;
        });

        return view('reports.vehicle_usage', compact('vehicles'));
    }

    public function driverPerformance(Request $request)
    {
        $query = Driver::with(['shipments', 'vehicle']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $drivers = $query->get()->map(function ($driver) {
            $driver->total_shipments = $driver->shipments()->count();
            $driver->delivered_shipments = $driver->shipments()->where('status', 'delivered')->count();
            $driver->on_time_deliveries = $driver->shipments()
                ->where('status', 'delivered')
                ->whereColumn('actual_delivery_date', '<=', 'delivery_date')
                ->count();
            return $driver;
        });

        return view('reports.driver_performance', compact('drivers'));
    }

    public function customerWise(Request $request)
    {
        $query = Customer::with(['shipments', 'invoices']);

        if ($request->filled('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }

        $customers = $query->get()->map(function ($customer) {
            $customer->total_shipments = $customer->shipments()->count();
            $customer->total_revenue = $customer->invoices()->where('status', 'paid')->sum('total');
            $customer->pending_amount = $customer->invoices()
                ->whereIn('status', ['sent', 'overdue'])
                ->get()
                ->sum(function ($inv) {
                    return $inv->total - $inv->payments()->sum('amount_paid');
                });
            return $customer;
        });

        $allCustomers = Customer::where('status', 'active')->get();

        return view('reports.customer_wise', compact('customers', 'allCustomers'));
    }

    public function vendorWise(Request $request)
    {
        $query = Vendor::with(['shipments', 'invoices']);

        if ($request->filled('vendor_id')) {
            $query->where('vendor_id', $request->vendor_id);
        }

        $vendors = $query->get()->map(function ($vendor) {
            $vendor->total_shipments = $vendor->shipments()->count();
            $vendor->total_billing = $vendor->invoices()->sum('total');
            $vendor->total_paid = $vendor->invoices()
                ->get()
                ->sum(function ($inv) {
                    return $inv->payments()->sum('amount_paid');
                });
            return $vendor;
        });

        $allVendors = Vendor::where('status', 'active')->get();

        return view('reports.vendor_wise', compact('vendors', 'allVendors'));
    }

    // ============ LOGISTICS REPORTS ============
    
    public function cnDetail(Request $request)
    {
        $query = Shipment::with(['customer', 'vendor', 'vehicle', 'driver', 'entryCity']);

        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('city_id')) {
            $query->where('entry_city', $request->city_id);
        }

        $shipments = $query->latest()->get();

        return view('reports.cn_detail', compact('shipments'));
    }

    public function cnStatus(Request $request)
    {
        $query = Shipment::with(['customer', 'vendor', 'vehicle', 'driver']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $shipments = $query->get();
        $statusCounts = $shipments->groupBy('status')->map->count();

        return view('reports.cn_status', compact('shipments', 'statusCounts'));
    }

    public function cnProfitLoss(Request $request)
    {
        $query = Shipment::with(['customer', 'vendor']);

        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $shipments = $query->get();
        
        $summary = [
            'total_revenue' => $shipments->sum(function($s) {
                return $s->freight_charges + $s->labor_charges + $s->other_charges;
            }),
            'total_cost' => 0, // Can be calculated based on vehicle/driver costs
            'total_profit' => 0,
            'total_cns' => $shipments->count(),
        ];

        return view('reports.cn_profit_loss', compact('shipments', 'summary'));
    }

    public function cityWiseProfitLoss(Request $request)
    {
        $shipments = Shipment::with(['entryCity', 'customer', 'vendor'])
            ->when($request->filled('from_date'), function($q) use ($request) {
                $q->whereDate('created_at', '>=', $request->from_date);
            })
            ->when($request->filled('to_date'), function($q) use ($request) {
                $q->whereDate('created_at', '<=', $request->to_date);
            })
            ->get();

        $cityWise = $shipments->groupBy('entry_city')->map(function($group) {
            return [
                'city' => $group->first()->entryCity->name ?? 'N/A',
                'count' => $group->count(),
                'revenue' => $group->sum(function($s) {
                    return $s->freight_charges + $s->labor_charges + $s->other_charges;
                }),
            ];
        });

        return view('reports.city_wise_profit_loss', compact('cityWise'));
    }

    public function shipperWiseProfitLoss(Request $request)
    {
        $shipments = Shipment::with(['customer'])
            ->when($request->filled('from_date'), function($q) use ($request) {
                $q->whereDate('created_at', '>=', $request->from_date);
            })
            ->when($request->filled('to_date'), function($q) use ($request) {
                $q->whereDate('created_at', '<=', $request->to_date);
            })
            ->get();

        $shipperWise = $shipments->groupBy('customer_id')->map(function($group) {
            return [
                'shipper' => $group->first()->customer->name ?? $group->first()->shipper_name ?? 'N/A',
                'count' => $group->count(),
                'revenue' => $group->sum(function($s) {
                    return $s->freight_charges + $s->labor_charges + $s->other_charges;
                }),
            ];
        });

        return view('reports.shipper_wise_profit_loss', compact('shipperWise'));
    }

    public function deliveryCnDetail(Request $request)
    {
        $query = Shipment::with(['customer', 'vendor', 'vehicle', 'driver'])
            ->whereIn('status', ['delivered', 'out-for-delivery']);

        if ($request->filled('from_date')) {
            $query->whereDate('delivery_date', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('delivery_date', '<=', $request->to_date);
        }

        $shipments = $query->latest('delivery_date')->get();

        return view('reports.delivery_cn_detail', compact('shipments'));
    }

    public function stockInTransit(Request $request)
    {
        $shipments = Shipment::with(['customer', 'vendor', 'vehicle', 'driver'])
            ->whereIn('status', ['in-transit', 'out-for-delivery'])
            ->when($request->filled('from_date'), function($q) use ($request) {
                $q->whereDate('created_at', '>=', $request->from_date);
            })
            ->when($request->filled('to_date'), function($q) use ($request) {
                $q->whereDate('created_at', '<=', $request->to_date);
            })
            ->get();

        return view('reports.stock_in_transit', compact('shipments'));
    }

    public function cnInStock(Request $request)
    {
        $shipments = Shipment::with(['customer', 'vendor', 'entryCity'])
            ->whereIn('status', ['booked', 'picked-up'])
            ->when($request->filled('city_id'), function($q) use ($request) {
                $q->where('entry_city', $request->city_id);
            })
            ->get();

        return view('reports.cn_in_stock', compact('shipments'));
    }

    // ============ FINANCE REPORTS ============

    public function listOfInvoices(Request $request)
    {
        $query = Invoice::with(['customer', 'vendor']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('from_date')) {
            $query->whereDate('invoice_date', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('invoice_date', '<=', $request->to_date);
        }

        $invoices = $query->latest()->get();

        return view('reports.list_of_invoices', compact('invoices'));
    }

    public function listOfPendingInvoices(Request $request)
    {
        $invoices = Invoice::with(['customer', 'vendor'])
            ->whereIn('status', ['sent', 'overdue'])
            ->get()
            ->filter(function($invoice) {
                $paid = $invoice->payments()->sum('amount_paid');
                return $invoice->total > $paid;
            });

        return view('reports.list_of_pending_invoices', compact('invoices'));
    }

    public function listOfMissingCnNos(Request $request)
    {
        // Find gaps in CN number sequence
        $shipments = Shipment::orderBy('shipment_number')->get();
        $missing = [];
        
        // This is a simplified version - can be enhanced
        return view('reports.list_of_missing_cn_nos', compact('missing'));
    }

    public function groupPartyOutstanding(Request $request)
    {
        $customers = Customer::with(['invoices.payments'])
            ->where('status', 'active')
            ->get()
            ->map(function($customer) {
                $total = $customer->invoices()->sum('total');
                $paid = $customer->invoices()->get()->sum(function($inv) {
                    return $inv->payments()->sum('amount_paid');
                });
                $customer->outstanding = $total - $paid;
                return $customer;
            })
            ->filter(function($customer) {
                return $customer->outstanding > 0;
            });

        return view('reports.group_party_outstanding', compact('customers'));
    }

    public function listOfCityCodes(Request $request)
    {
        $cities = \App\Models\City::where('is_active', true)->orderBy('name')->get();
        return view('reports.list_of_city_codes', compact('cities'));
    }

    public function listOfVehicleTypes(Request $request)
    {
        $vehicleTypes = Vehicle::select('type', DB::raw('count(*) as count'))
            ->groupBy('type')
            ->get();
        return view('reports.list_of_vehicle_types', compact('vehicleTypes'));
    }

    // ============ ADDITIONAL LOGISTICS REPORTS ============
    
    public function hubWiseProfitLoss(Request $request)
    {
        $shipments = Shipment::with(['entryCity'])
            ->when($request->filled('from_date'), function($q) use ($request) {
                $q->whereDate('created_at', '>=', $request->from_date);
            })
            ->when($request->filled('to_date'), function($q) use ($request) {
                $q->whereDate('created_at', '<=', $request->to_date);
            })
            ->get();

        $hubWise = $shipments->groupBy('hub')->map(function($group) {
            return [
                'hub' => $group->first()->hub ?? 'N/A',
                'count' => $group->count(),
                'revenue' => $group->sum(function($s) {
                    return ($s->freight_charges ?? 0) + ($s->labor_charges ?? 0) + ($s->other_charges ?? 0);
                }),
            ];
        });

        return view('reports.hub_wise_profit_loss', compact('hubWise'));
    }

    public function spoWiseProfitLoss(Request $request)
    {
        $shipments = Shipment::with(['cargoOfficer'])
            ->when($request->filled('from_date'), function($q) use ($request) {
                $q->whereDate('created_at', '>=', $request->from_date);
            })
            ->when($request->filled('to_date'), function($q) use ($request) {
                $q->whereDate('created_at', '<=', $request->to_date);
            })
            ->get();

        $spoWise = $shipments->groupBy('cargo_officer_id')->map(function($group) {
            return [
                'spo' => $group->first()->cargoOfficer->officer_name ?? 'N/A',
                'count' => $group->count(),
                'revenue' => $group->sum(function($s) {
                    return ($s->freight_charges ?? 0) + ($s->labor_charges ?? 0) + ($s->other_charges ?? 0);
                }),
            ];
        });

        return view('reports.spo_wise_profit_loss', compact('spoWise'));
    }

    public function hubWiseCnDetail(Request $request)
    {
        $query = Shipment::with(['customer', 'vendor', 'vehicle', 'driver'])
            ->when($request->filled('hub'), function($q) use ($request) {
                $q->where('hub', $request->hub);
            })
            ->when($request->filled('from_date'), function($q) use ($request) {
                $q->whereDate('created_at', '>=', $request->from_date);
            })
            ->when($request->filled('to_date'), function($q) use ($request) {
                $q->whereDate('created_at', '<=', $request->to_date);
            });

        $shipments = $query->latest()->get();
        return view('reports.hub_wise_cn_detail', compact('shipments'));
    }

    public function transporterWiseDocumentsDetail(Request $request)
    {
        $query = Shipment::with(['vehicle', 'driver'])
            ->whereNotNull('vehicle_id')
            ->when($request->filled('vehicle_id'), function($q) use ($request) {
                $q->where('vehicle_id', $request->vehicle_id);
            })
            ->when($request->filled('from_date'), function($q) use ($request) {
                $q->whereDate('created_at', '>=', $request->from_date);
            })
            ->when($request->filled('to_date'), function($q) use ($request) {
                $q->whereDate('created_at', '<=', $request->to_date);
            });

        $shipments = $query->latest()->get();
        $vehicles = Vehicle::where('status', 'active')->get();
        
        return view('reports.transporter_wise_documents_detail', compact('shipments', 'vehicles'));
    }

    public function zoneWiseProfitLoss(Request $request)
    {
        $shipments = Shipment::with(['zone'])
            ->when($request->filled('from_date'), function($q) use ($request) {
                $q->whereDate('created_at', '>=', $request->from_date);
            })
            ->when($request->filled('to_date'), function($q) use ($request) {
                $q->whereDate('created_at', '<=', $request->to_date);
            })
            ->get();

        $zoneWise = $shipments->groupBy('zone_code')->map(function($group) {
            return [
                'zone' => $group->first()->zone->zone_name ?? 'N/A',
                'count' => $group->count(),
                'revenue' => $group->sum(function($s) {
                    return ($s->freight_charges ?? 0) + ($s->labor_charges ?? 0) + ($s->other_charges ?? 0);
                }),
            ];
        });

        return view('reports.zone_wise_profit_loss', compact('zoneWise'));
    }

    public function listOfMissingSnNumbers(Request $request)
    {
        // Find missing serial numbers in CN sequence
        $shipments = Shipment::orderBy('shipment_number')->get();
        $missing = [];
        
        // Simplified implementation
        return view('reports.list_of_missing_sn_numbers', compact('missing'));
    }

    public function cityCodeHubWiseList(Request $request)
    {
        $cities = \App\Models\City::with('hubs')
            ->where('is_active', true)
            ->orderBy('name')
            ->get();
        
        return view('reports.city_code_hub_wise_list', compact('cities'));
    }

    public function listOfRates(Request $request)
    {
        $rates = \App\Models\PartyAreaRate::with('cities')
            ->where('is_active', true)
            ->orderBy('party_name')
            ->get();
        
        return view('reports.list_of_rates', compact('rates'));
    }

    public function partyWiseFuelRateList(Request $request)
    {
        $fuelRates = \App\Models\PartyFuelRate::where('is_active', true)
            ->orderBy('party_name')
            ->get();
        
        return view('reports.party_wise_fuel_rate_list', compact('fuelRates'));
    }

    public function listOfInvoicesSalesTax(Request $request)
    {
        $query = Invoice::with(['customer', 'vendor'])
            ->where('tax_amount', '>', 0)
            ->when($request->filled('from_date'), function($q) use ($request) {
                $q->whereDate('invoice_date', '>=', $request->from_date);
            })
            ->when($request->filled('to_date'), function($q) use ($request) {
                $q->whereDate('invoice_date', '<=', $request->to_date);
            });

        $invoices = $query->latest()->get();
        return view('reports.list_of_invoices_sales_tax', compact('invoices'));
    }

    public function cnDetailAccountCod(Request $request)
    {
        $query = Shipment::with(['customer', 'vendor'])
            ->where('payment_mode', 'COD')
            ->when($request->filled('from_date'), function($q) use ($request) {
                $q->whereDate('created_at', '>=', $request->from_date);
            })
            ->when($request->filled('to_date'), function($q) use ($request) {
                $q->whereDate('created_at', '<=', $request->to_date);
            });

        $shipments = $query->latest()->get();
        return view('reports.cn_detail_account_cod', compact('shipments'));
    }

    public function deliverySheetCodDetail(Request $request)
    {
        $query = \App\Models\DeliverySheet::with(['shipments'])
            ->whereHas('shipments', function($q) {
                $q->where('payment_mode', 'COD');
            })
            ->when($request->filled('from_date'), function($q) use ($request) {
                $q->whereDate('delivery_date', '>=', $request->from_date);
            })
            ->when($request->filled('to_date'), function($q) use ($request) {
                $q->whereDate('delivery_date', '<=', $request->to_date);
            });

        $deliverySheets = $query->latest()->get();
        return view('reports.delivery_sheet_cod_detail', compact('deliverySheets'));
    }

    public function cnDetailAccountCodStatus(Request $request)
    {
        $query = Shipment::with(['customer', 'vendor'])
            ->where('payment_mode', 'COD')
            ->when($request->filled('status'), function($q) use ($request) {
                $q->where('status', $request->status);
            });

        $shipments = $query->latest()->get();
        $statusCounts = $shipments->groupBy('status')->map->count();
        
        return view('reports.cn_detail_account_cod_status', compact('shipments', 'statusCounts'));
    }

    public function nonServiceChargesOnCn(Request $request)
    {
        $query = Shipment::with(['customer', 'vendor'])
            ->where('other_charges', '>', 0)
            ->when($request->filled('from_date'), function($q) use ($request) {
                $q->whereDate('created_at', '>=', $request->from_date);
            })
            ->when($request->filled('to_date'), function($q) use ($request) {
                $q->whereDate('created_at', '<=', $request->to_date);
            });

        $shipments = $query->latest()->get();
        return view('reports.non_service_charges_on_cn', compact('shipments'));
    }

    public function listOfMonthlyPayroll(Request $request)
    {
        $query = Payroll::with('employee')
            ->when($request->filled('month'), function($q) use ($request) {
                $q->where('month', $request->month);
            })
            ->when($request->filled('year'), function($q) use ($request) {
                $q->where('year', $request->year);
            });

        $payrolls = $query->orderBy('year', 'desc')->orderBy('month', 'desc')->get();
        return view('reports.list_of_monthly_payroll', compact('payrolls'));
    }
}


