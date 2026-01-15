<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Customer;
use App\Models\Vendor;
use App\Models\Shipment;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Invoice::with(['customer', 'vendor'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('invoice_type')) {
            $query->where('invoice_type', $request->invoice_type);
        }

        if ($request->filled('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }

        $invoices = $query->paginate(15);
        $customers = Customer::where('status', 'active')->get();

        return view('invoices.index', compact('invoices', 'customers'));
    }

    public function create()
    {
        $customers = Customer::where('status', 'active')->get();
        $vendors = Vendor::where('status', 'active')->get();
        $shipments = Shipment::where('status', '!=', 'cancelled')->get();

        return view('invoices.create', compact('customers', 'vendors', 'shipments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'invoice_type' => 'required|in:customer,vendor',
            'customer_id' => 'required_if:invoice_type,customer|nullable|exists:customers,customer_id',
            'vendor_id' => 'required_if:invoice_type,vendor|nullable|exists:vendors,vendor_id',
            'invoice_date' => 'required|date',
            'due_date' => 'nullable|date',
            'shipment_ids' => 'required|array|min:1',
            'shipment_ids.*' => 'exists:shipments,shipment_id',
            'tax_rate' => 'nullable|numeric|min:0|max:100',
            'discount' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        // Get shipments and calculate subtotal
        $shipments = Shipment::whereIn('shipment_id', $validated['shipment_ids'])->get();
        $subtotal = $shipments->sum(function ($shipment) {
            return $shipment->freight_charges + $shipment->labor_charges + $shipment->other_charges;
        });

        $tax_rate = $validated['tax_rate'] ?? 0;
        $discount = $validated['discount'] ?? 0;
        $tax_amount = ($subtotal - $discount) * ($tax_rate / 100);
        $total = $subtotal - $discount + $tax_amount;

        // Generate invoice number
        $invoice_number = $this->generateInvoiceNumber();

        $invoice = Invoice::create([
            'invoice_number' => $invoice_number,
            'invoice_type' => $validated['invoice_type'],
            'customer_id' => $validated['customer_id'] ?? null,
            'vendor_id' => $validated['vendor_id'] ?? null,
            'invoice_date' => $validated['invoice_date'],
            'due_date' => $validated['due_date'] ?? null,
            'subtotal' => $subtotal,
            'tax_rate' => $tax_rate,
            'tax_amount' => $tax_amount,
            'discount' => $discount,
            'total' => $total,
            'status' => 'draft',
            'notes' => $validated['notes'] ?? null,
        ]);

        // Attach shipments
        foreach ($shipments as $shipment) {
            $amount = $shipment->freight_charges + $shipment->labor_charges + $shipment->other_charges;
            $invoice->shipments()->attach($shipment->shipment_id, ['amount' => $amount]);
        }

        // Log activity
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'created',
            'model_type' => 'Invoice',
            'model_id' => $invoice->invoice_id,
            'description' => "Created invoice: {$invoice->invoice_number}",
        ]);

        return redirect()->route('invoices.show', $invoice)->with('success', 'Invoice created successfully.');
    }

    public function show(Invoice $invoice)
    {
        $invoice->load(['customer', 'vendor', 'shipments', 'payments']);
        return view('invoices.show', compact('invoice'));
    }

    public function edit(Invoice $invoice)
    {
        if ($invoice->status !== 'draft') {
            return redirect()->route('invoices.show', $invoice)
                ->with('error', 'Only draft invoices can be edited.');
        }

        $customers = Customer::where('status', 'active')->get();
        $vendors = Vendor::where('status', 'active')->get();
        $shipments = Shipment::where('status', '!=', 'cancelled')->get();
        $invoice->load('shipments');

        return view('invoices.edit', compact('invoice', 'customers', 'vendors', 'shipments'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        if ($invoice->status !== 'draft') {
            return back()->with('error', 'Only draft invoices can be edited.');
        }

        $validated = $request->validate([
            'invoice_type' => 'required|in:customer,vendor',
            'customer_id' => 'required_if:invoice_type,customer|nullable|exists:customers,customer_id',
            'vendor_id' => 'required_if:invoice_type,vendor|nullable|exists:vendors,vendor_id',
            'invoice_date' => 'required|date',
            'due_date' => 'nullable|date',
            'shipment_ids' => 'required|array|min:1',
            'shipment_ids.*' => 'exists:shipments,shipment_id',
            'tax_rate' => 'nullable|numeric|min:0|max:100',
            'discount' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        // Get shipments and calculate subtotal
        $shipments = Shipment::whereIn('shipment_id', $validated['shipment_ids'])->get();
        $subtotal = $shipments->sum(function ($shipment) {
            return $shipment->freight_charges + $shipment->labor_charges + $shipment->other_charges;
        });

        $tax_rate = $validated['tax_rate'] ?? 0;
        $discount = $validated['discount'] ?? 0;
        $tax_amount = ($subtotal - $discount) * ($tax_rate / 100);
        $total = $subtotal - $discount + $tax_amount;

        $invoice->update([
            'invoice_type' => $validated['invoice_type'],
            'customer_id' => $validated['customer_id'] ?? null,
            'vendor_id' => $validated['vendor_id'] ?? null,
            'invoice_date' => $validated['invoice_date'],
            'due_date' => $validated['due_date'] ?? null,
            'subtotal' => $subtotal,
            'tax_rate' => $tax_rate,
            'tax_amount' => $tax_amount,
            'discount' => $discount,
            'total' => $total,
            'notes' => $validated['notes'] ?? null,
        ]);

        // Sync shipments
        $invoice->shipments()->detach();
        foreach ($shipments as $shipment) {
            $amount = $shipment->freight_charges + $shipment->labor_charges + $shipment->other_charges;
            $invoice->shipments()->attach($shipment->shipment_id, ['amount' => $amount]);
        }

        // Log activity
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'updated',
            'model_type' => 'Invoice',
            'model_id' => $invoice->invoice_id,
            'description' => "Updated invoice: {$invoice->invoice_number}",
        ]);

        return redirect()->route('invoices.show', $invoice)->with('success', 'Invoice updated successfully.');
    }

    public function destroy(Invoice $invoice)
    {
        if ($invoice->status !== 'draft') {
            return back()->with('error', 'Only draft invoices can be deleted.');
        }

        $number = $invoice->invoice_number;
        $invoice->delete();

        // Log activity
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'deleted',
            'model_type' => 'Invoice',
            'model_id' => $invoice->invoice_id,
            'description' => "Deleted invoice: {$number}",
        ]);

        return redirect()->route('invoices.index')->with('success', 'Invoice deleted successfully.');
    }

    public function updateStatus(Invoice $invoice, Request $request)
    {
        $validated = $request->validate([
            'status' => 'required|in:draft,sent,paid,overdue,cancelled',
        ]);

        $invoice->update(['status' => $validated['status']]);

        return back()->with('success', 'Invoice status updated.');
    }

    private function generateInvoiceNumber(): string
    {
        $year = date('Y');
        $lastInvoice = Invoice::whereYear('invoice_date', $year)
            ->orderBy('invoice_id', 'desc')
            ->first();

        if ($lastInvoice) {
            $lastNumber = (int) substr($lastInvoice->invoice_number, -5);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return 'INV-' . $year . '-' . str_pad($newNumber, 5, '0', STR_PAD_LEFT);
    }
}

