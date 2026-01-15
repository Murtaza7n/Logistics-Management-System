<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use App\Models\Customer;
use App\Models\Vendor;
use App\Models\Employee;
use App\Models\Vehicle;
use App\Models\Invoice;
use App\Models\Payroll;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistics
        $stats = [
            'total_shipments' => Shipment::count(),
            'active_shipments' => Shipment::whereIn('status', ['booked', 'picked-up', 'in-transit', 'out-for-delivery'])->count(),
            'delivered_shipments' => Shipment::where('status', 'delivered')->count(),
            'total_customers' => Customer::where('status', 'active')->count(),
            'total_vendors' => Vendor::where('status', 'active')->count(),
            'total_employees' => Employee::where('status', 'active')->count(),
            'total_vehicles' => Vehicle::where('status', 'available')->count(),
            'total_revenue' => Invoice::where('status', 'paid')->sum('total'),
            'pending_invoices' => Invoice::whereIn('status', ['draft', 'sent'])->count(),
        ];

        // Recent shipments
        $recent_shipments = Shipment::with(['customer', 'vehicle', 'driver'])
            ->latest()
            ->limit(10)
            ->get();

        // Shipments by status
        $shipments_by_status = Shipment::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();

        // Monthly revenue (last 6 months)
        $monthly_revenue = Invoice::select(
                DB::raw('DATE_FORMAT(invoice_date, "%Y-%m") as month'),
                DB::raw('SUM(total) as revenue')
            )
            ->where('status', 'paid')
            ->where('invoice_date', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Top customers by revenue
        $top_customers = Customer::select('customers.*', DB::raw('SUM(invoices.total) as total_revenue'))
            ->join('invoices', 'customers.customer_id', '=', 'invoices.customer_id')
            ->where('invoices.status', 'paid')
            ->groupBy('customers.customer_id')
            ->orderBy('total_revenue', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard', compact('stats', 'recent_shipments', 'shipments_by_status', 'monthly_revenue', 'top_customers'));
    }
}


