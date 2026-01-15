@extends('layouts.app')

@section('title', 'Customer-wise Report')
@section('page-title', 'Customer-wise Report')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="bi bi-people"></i> Customer-wise Report</h5>
    </div>
    <div class="card-body">
        <form method="GET" class="mb-3">
            <div class="row g-2">
                <div class="col-md-4">
                    <select class="form-select" name="customer_id">
                        <option value="">All Customers</option>
                        @foreach($allCustomers as $customer)
                        <option value="{{ $customer->customer_id }}" {{ request('customer_id') == $customer->customer_id ? 'selected' : '' }}>{{ $customer->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="{{ route('reports.customer-wise') }}" class="btn btn-secondary">Reset</a>
                </div>
            </div>
        </form>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Customer</th>
                        <th>Total Shipments</th>
                        <th>Total Revenue</th>
                        <th>Pending Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $customer)
                    <tr>
                        <td>{{ $customer->name }}</td>
                        <td>{{ $customer->total_shipments }}</td>
                        <td>${{ number_format($customer->total_revenue, 2) }}</td>
                        <td>${{ number_format($customer->pending_amount, 2) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center">No customers found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection


