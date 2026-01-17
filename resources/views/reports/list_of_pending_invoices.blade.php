@extends('layouts.app')

@section('title', 'List of Pending Invoices')
@section('page-title', 'List of Pending Invoices')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">
        
        List of Pending Invoices
    </h1>
    <p class="page-subtitle">Invoices with outstanding payments</p>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"> Pending Invoices ({{ $invoices->count() }} records)</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Invoice #</th>
                        <th>Customer/Vendor</th>
                        <th>Invoice Date</th>
                        <th>Due Date</th>
                        <th>Total Amount</th>
                        <th>Paid Amount</th>
                        <th>Outstanding</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($invoices as $invoice)
                    @php
                        $paid = $invoice->payments()->sum('amount_paid');
                        $outstanding = $invoice->total - $paid;
                    @endphp
                    <tr>
                        <td><strong>{{ $invoice->invoice_number }}</strong></td>
                        <td>{{ $invoice->customer->name ?? $invoice->vendor->name ?? 'N/A' }}</td>
                        <td>{{ $invoice->invoice_date ? $invoice->invoice_date->format('Y-m-d') : 'N/A' }}</td>
                        <td>{{ $invoice->due_date ? $invoice->due_date->format('Y-m-d') : 'N/A' }}</td>
                        <td>Rs.{{ number_format($invoice->total, 2) }}</td>
                        <td>Rs.{{ number_format($paid, 2) }}</td>
                        <td><strong>Rs.{{ number_format($outstanding, 2) }}</strong></td>
                        <td>
                            <span class="badge badge-{{ $invoice->status === 'overdue' ? 'dark' : 'secondary' }}">
                                {{ ucfirst($invoice->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('invoices.show', $invoice) }}" class="btn btn-sm btn-outline-primary">
                                
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center">No pending invoices found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

