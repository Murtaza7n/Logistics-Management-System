<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use App\Models\Invoice;
use App\Models\Payroll;
use App\Models\Customer;
use App\Models\Vendor;
use App\Models\Vehicle;
use App\Models\Driver;
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

    public function vehicleUsage(Request $request)
    {
        $query = Vehicle::with(['shipments', 'driver']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $vehicles = $query->get()->map(function ($vehicle) {
            $vehicle->total_shipments = $vehicle->shipments()->count();
            $vehicle->total_revenue = $vehicle->shipments()->sum(function ($s) {
                return $s->freight_charges + $s->labor_charges + $s->other_charges;
            });
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
}


