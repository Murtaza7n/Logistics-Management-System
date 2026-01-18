@extends('layouts.app')

@section('title', 'List of Invoices')
@section('page-title', 'List of Invoices')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">
        
        List of Invoices
    </h1>
    <p class="page-subtitle">Complete list of all invoices</p>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"> Filters</h5>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('reports.list-of-invoices') }}" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="sent" {{ request('status') == 'sent' ? 'selected' : '' }}>Sent</option>
                    <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="overdue" {{ request('status') == 'overdue' ? 'selected' : '' }}>Overdue</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">From Date</label>
                <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">To Date</label>
                <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">&nbsp;</label>
                <div>
                    <button type="submit" class="btn btn-primary w-100">
                         Filter
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"> Invoices ({{ $invoices->count() }} records)</h5>
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
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($invoices as $invoice)
                    <tr>
                        <td><strong>{{ $invoice->invoice_number }}</strong></td>
                        <td>{{ $invoice->customer->name ?? $invoice->vendor->name ?? 'N/A' }}</td>
                        <td>{{ $invoice->invoice_date ? $invoice->invoice_date->format('Y-m-d') : 'N/A' }}</td>
                        <td>{{ $invoice->due_date ? $invoice->due_date->format('Y-m-d') : 'N/A' }}</td>
                        <td>Rs.{{ number_format($invoice->total, 2) }}</td>
                        <td>
                            <span class="badge bg-{{ $invoice->status === 'paid' ? 'success' : ($invoice->status === 'overdue' ? 'danger' : 'warning') }}">
                                {{ ucfirst($invoice->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('invoices.show', $invoice) }}" class="btn btn-sm btn-outline-info">
                                
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">No invoices found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

