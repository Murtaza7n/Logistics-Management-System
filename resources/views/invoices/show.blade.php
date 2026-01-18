@extends('layouts.app')

@section('title', 'Invoice Details')
@section('page-title', 'Invoice Details')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"> Invoice: {{ $invoice->invoice_number }}</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="40%">Invoice Number:</th>
                        <td>{{ $invoice->invoice_number }}</td>
                    </tr>
                    <tr>
                        <th>Type:</th>
                        <td><span class="badge bg-{{ $invoice->invoice_type === 'customer' ? 'primary' : 'info' }}">{{ ucfirst($invoice->invoice_type) }}</span></td>
                    </tr>
                    <tr>
                        <th>{{ $invoice->invoice_type === 'customer' ? 'Customer' : 'Vendor' }}:</th>
                        <td>{{ $invoice->customer->name ?? $invoice->vendor->name }}</td>
                    </tr>
                    <tr>
                        <th>Invoice Date:</th>
                        <td>{{ $invoice->invoice_date->format('M d, Y') }}</td>
                    </tr>
                    <tr>
                        <th>Due Date:</th>
                        <td>{{ $invoice->due_date?->format('M d, Y') ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Subtotal:</th>
                        <td>Rs.{{ number_format($invoice->subtotal, 2) }}</td>
                    </tr>
                    <tr>
                        <th>Tax ({{ $invoice->tax_rate }}%):</th>
                        <td>Rs.{{ number_format($invoice->tax_amount, 2) }}</td>
                    </tr>
                    <tr>
                        <th>Discount:</th>
                        <td>Rs.{{ number_format($invoice->discount, 2) }}</td>
                    </tr>
                    <tr>
                        <th><strong>Total:</strong></th>
                        <td><strong>Rs.{{ number_format($invoice->total, 2) }}</strong></td>
                    </tr>
                    <tr>
                        <th>Total Paid:</th>
                        <td>Rs.{{ number_format($invoice->total_paid, 2) }}</td>
                    </tr>
                    <tr>
                        <th>Balance:</th>
                        <td><strong>Rs.{{ number_format($invoice->balance, 2) }}</strong></td>
                    </tr>
                    <tr>
                        <th>Status:</th>
                        <td><span class="badge bg-{{ $invoice->status === 'paid' ? 'success' : ($invoice->status === 'overdue' ? 'danger' : 'warning') }}">{{ ucfirst($invoice->status) }}</span></td>
                    </tr>
                </table>
                
                <h6 class="mt-4">Shipments:</h6>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Shipment #</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($invoice->shipments as $shipment)
                            <tr>
                                <td><a href="{{ route('shipments.show', $shipment) }}">{{ $shipment->shipment_number }}</a></td>
                                <td>Rs.{{ number_format($shipment->pivot->amount, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <h6 class="mt-4">Payments:</h6>
                @if($invoice->payments->count() > 0)
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Method</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($invoice->payments as $payment)
                            <tr>
                                <td>{{ $payment->payment_date->format('M d, Y') }}</td>
                                <td>Rs.{{ number_format($payment->amount_paid, 2) }}</td>
                                <td>{{ ucfirst(str_replace('_', ' ', $payment->method)) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p class="text-muted">No payments recorded yet.</p>
                @endif

                <div class="mt-3">
                    <a href="{{ route('payments.create', ['invoice_id' => $invoice->invoice_id]) }}" class="btn btn-success">
                         Record Payment
                    </a>
                    <a href="{{ route('invoices.index') }}" class="btn btn-secondary">
                         Back
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


