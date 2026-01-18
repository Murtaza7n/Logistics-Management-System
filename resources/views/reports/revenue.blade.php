@extends('layouts.app')

@section('title', 'Revenue Reports')
@section('page-title', 'Revenue Reports')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0"> Revenue Reports</h5>
    </div>
    <div class="card-body">
        <form method="GET" class="mb-3">
            <div class="row g-2">
                <div class="col-md-3">
                    <input type="date" class="form-control" name="from_date" value="{{ request('from_date') }}" placeholder="From Date">
                </div>
                <div class="col-md-3">
                    <input type="date" class="form-control" name="to_date" value="{{ request('to_date') }}" placeholder="To Date">
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="status">
                        <option value="">All Status</option>
                        <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="{{ route('reports.revenue') }}" class="btn btn-secondary">Reset</a>
                </div>
            </div>
        </form>
        
        <div class="row mb-3">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h6>Total Invoices</h6>
                        <h3>{{ $summary['total_invoices'] }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h6>Total Amount</h6>
                        <h3>Rs.{{ number_format($summary['total_amount'], 2) }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <h6>Total Paid</h6>
                        <h3>Rs.{{ number_format($summary['total_paid'], 2) }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <h6>Pending</h6>
                        <h3>Rs.{{ number_format($summary['total_pending'], 2) }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('reports.revenue', array_merge(request()->all(), ['export' => 'pdf'])) }}" class="btn btn-danger">
                 Export PDF
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Invoice #</th>
                        <th>Type</th>
                        <th>Customer/Vendor</th>
                        <th>Date</th>
                        <th>Subtotal</th>
                        <th>Tax</th>
                        <th>Total</th>
                        <th>Paid</th>
                        <th>Balance</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($invoices as $invoice)
                    <tr>
                        <td>{{ $invoice->invoice_number }}</td>
                        <td><span class="badge bg-{{ $invoice->invoice_type === 'customer' ? 'primary' : 'info' }}">{{ ucfirst($invoice->invoice_type) }}</span></td>
                        <td>{{ $invoice->customer->name ?? $invoice->vendor->name }}</td>
                        <td>{{ $invoice->invoice_date->format('M d, Y') }}</td>
                        <td>Rs.{{ number_format($invoice->subtotal, 2) }}</td>
                        <td>Rs.{{ number_format($invoice->tax_amount, 2) }}</td>
                        <td><strong>Rs.{{ number_format($invoice->total, 2) }}</strong></td>
                        <td>Rs.{{ number_format($invoice->total_paid, 2) }}</td>
                        <td>Rs.{{ number_format($invoice->balance, 2) }}</td>
                        <td><span class="badge bg-{{ $invoice->status === 'paid' ? 'success' : ($invoice->status === 'overdue' ? 'danger' : 'warning') }}">{{ ucfirst($invoice->status) }}</span></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center">No invoices found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection


