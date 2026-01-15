@extends('layouts.app')

@section('title', 'Vendor-wise Report')
@section('page-title', 'Vendor-wise Report')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="bi bi-building"></i> Vendor-wise Report</h5>
    </div>
    <div class="card-body">
        <form method="GET" class="mb-3">
            <div class="row g-2">
                <div class="col-md-4">
                    <select class="form-select" name="vendor_id">
                        <option value="">All Vendors</option>
                        @foreach($allVendors as $vendor)
                        <option value="{{ $vendor->vendor_id }}" {{ request('vendor_id') == $vendor->vendor_id ? 'selected' : '' }}>{{ $vendor->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="{{ route('reports.vendor-wise') }}" class="btn btn-secondary">Reset</a>
                </div>
            </div>
        </form>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Vendor</th>
                        <th>Total Shipments</th>
                        <th>Total Billing</th>
                        <th>Total Paid</th>
                        <th>Balance</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($vendors as $vendor)
                    <tr>
                        <td>{{ $vendor->name }}</td>
                        <td>{{ $vendor->total_shipments }}</td>
                        <td>${{ number_format($vendor->total_billing, 2) }}</td>
                        <td>${{ number_format($vendor->total_paid, 2) }}</td>
                        <td>${{ number_format($vendor->total_billing - $vendor->total_paid, 2) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">No vendors found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection


