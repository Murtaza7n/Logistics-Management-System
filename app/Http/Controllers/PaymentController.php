<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Invoice;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with('invoice')->latest();

        if ($request->filled('invoice_id')) {
            $query->where('invoice_id', $request->invoice_id);
        }

        $payments = $query->paginate(15);

        return view('payments.index', compact('payments'));
    }

    public function create(Request $request)
    {
        $invoice = null;
        if ($request->filled('invoice_id')) {
            $invoice = Invoice::findOrFail($request->invoice_id);
        }

        $invoices = Invoice::whereIn('status', ['sent', 'overdue'])
            ->with(['customer', 'vendor'])
            ->get();

        return view('payments.create', compact('invoices', 'invoice'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'invoice_id' => 'required|exists:invoices,invoice_id',
            'amount_paid' => 'required|numeric|min:0.01',
            'payment_date' => 'required|date',
            'method' => 'required|in:cash,bank_transfer,cheque,credit_card,other',
            'reference_number' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $invoice = Invoice::findOrFail($validated['invoice_id']);

        // Check if payment exceeds balance
        $totalPaid = $invoice->payments()->sum('amount_paid');
        $balance = $invoice->total - $totalPaid;

        if ($validated['amount_paid'] > $balance) {
            return back()->withErrors(['amount_paid' => 'Payment amount cannot exceed invoice balance.'])->withInput();
        }

        $payment = Payment::create($validated);

        // Update invoice status if fully paid
        $newTotalPaid = $totalPaid + $validated['amount_paid'];
        if ($newTotalPaid >= $invoice->total) {
            $invoice->update(['status' => 'paid']);
        } elseif ($invoice->status === 'overdue') {
            $invoice->update(['status' => 'sent']);
        }

        // Log activity
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'created',
            'model_type' => 'Payment',
            'model_id' => $payment->payment_id,
            'description' => "Created payment for invoice: {$invoice->invoice_number}",
        ]);

        return redirect()->route('payments.index')->with('success', 'Payment recorded successfully.');
    }

    public function show(Payment $payment)
    {
        $payment->load('invoice');
        return view('payments.show', compact('payment'));
    }

    public function destroy(Payment $payment)
    {
        $invoice = $payment->invoice;
        $payment->delete();

        // Recalculate invoice status
        $totalPaid = $invoice->payments()->sum('amount_paid');
        if ($totalPaid >= $invoice->total) {
            $invoice->update(['status' => 'paid']);
        } else {
            $invoice->update(['status' => 'sent']);
        }

        // Log activity
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'deleted',
            'model_type' => 'Payment',
            'model_id' => $payment->payment_id,
            'description' => "Deleted payment ID: {$payment->payment_id}",
        ]);

        return redirect()->route('payments.index')->with('success', 'Payment deleted successfully.');
    }
}


