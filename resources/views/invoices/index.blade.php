@extends('layouts.app')

@section('title', 'Invoices')
@section('page-title', 'Invoices Management')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"> Invoices</h5>
        <a href="{{ route('invoices.create') }}" class="btn btn-primary btn-sm">
             Create Invoice
        </a>
    </div>
    <div class="card-body">
        <form method="GET" class="mb-3">
            <div class="row g-2">
                <div class="col-md-3">
                    <select class="form-select" name="status">
                        <option value="">All Status</option>
                        <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="sent" {{ request('status') === 'sent' ? 'selected' : '' }}>Sent</option>
                        <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Paid</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="invoice_type">
                        <option value="">All Types</option>
                        <option value="customer" {{ request('invoice_type') === 'customer' ? 'selected' : '' }}>Customer</option>
                        <option value="vendor" {{ request('invoice_type') === 'vendor' ? 'selected' : '' }}>Vendor</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="{{ route('invoices.index') }}" class="btn btn-secondary">Reset</a>
                </div>
            </div>
        </form>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Invoice #</th>
                        <th>Type</th>
                        <th>Customer/Vendor</th>
                        <th>Date</th>
                        <th>Total</th>
                        <th>Paid</th>
                        <th>Balance</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($invoices as $invoice)
                    <tr>
                        <td><a href="{{ route('invoices.show', $invoice) }}">{{ $invoice->invoice_number }}</a></td>
                        <td><span class="badge bg-{{ $invoice->invoice_type === 'customer' ? 'primary' : 'info' }}">{{ ucfirst($invoice->invoice_type) }}</span></td>
                        <td>{{ $invoice->customer->name ?? $invoice->vendor->name }}</td>
                        <td>{{ $invoice->invoice_date->format('M d, Y') }}</td>
                        <td>Rs.{{ number_format($invoice->total, 2) }}</td>
                        <td>Rs.{{ number_format($invoice->total_paid, 2) }}</td>
                        <td>Rs.{{ number_format($invoice->balance, 2) }}</td>
                        <td><span class="badge bg-{{ $invoice->status === 'paid' ? 'success' : ($invoice->status === 'overdue' ? 'danger' : 'warning') }}">{{ ucfirst($invoice->status) }}</span></td>
                        <td>
                            <a href="{{ route('invoices.show', $invoice) }}" class="btn btn-sm btn-outline-info">
                                
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center">No invoices found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $invoices->links() }}
        </div>
    </div>
</div>
@endsection


