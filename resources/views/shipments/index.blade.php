@extends('layouts.app')

@section('title', 'Shipments')
@section('page-title', 'Shipments Management')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <h1 class="page-title">
                CN Entries Management
            </h1>
            <p class="page-subtitle">View and manage all consignment note entries</p>
        </div>
        <div class="d-flex flex-wrap gap-2 mt-2 mt-md-0">
            <a href="{{ route('shipments.detail-search') }}" class="btn btn-info">
                Detail Search
            </a>
            <a href="{{ route('shipments.create') }}" class="btn btn-primary">
                New CN Entry
            </a>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">All CN Entries</h5>
    </div>
    <div class="card-body">
        <form method="GET" class="mb-3">
            <div class="row g-2">
                <div class="col-md-3">
                    <input type="text" class="form-control" name="shipment_number" value="{{ request('shipment_number') }}" placeholder="CN / Shipment Number">
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="status">
                        <option value="">All Status</option>
                        <option value="booked" {{ request('status') === 'booked' ? 'selected' : '' }}>Booked</option>
                        <option value="picked-up" {{ request('status') === 'picked-up' ? 'selected' : '' }}>Picked Up</option>
                        <option value="in-transit" {{ request('status') === 'in-transit' ? 'selected' : '' }}>In Transit</option>
                        <option value="delivered" {{ request('status') === 'delivered' ? 'selected' : '' }}>Delivered</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="customer_id">
                        <option value="">All Customers</option>
                        @foreach($customers as $customer)
                        <option value="{{ $customer->customer_id }}" {{ request('customer_id') == $customer->customer_id ? 'selected' : '' }}>{{ $customer->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="{{ route('shipments.index') }}" class="btn btn-secondary">Reset</a>
                </div>
            </div>
        </form>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>CN / Shipment #</th>
                        <th>Customer</th>
                        <th>From → To</th>
                        <th>Cargo Type</th>
                        <th>Vehicle</th>
                        <th>Driver</th>
                        <th>Total Charges</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($shipments as $shipment)
                    <tr>
                        <td><a href="{{ route('shipments.show', $shipment) }}">{{ $shipment->shipment_number }}</a></td>
                        <td>{{ $shipment->customer->name }}</td>
                        <td>{{ $shipment->pickup_city }} → {{ $shipment->delivery_city }}</td>
                        <td>{{ $shipment->cargo_type }}</td>
                        <td>{{ $shipment->vehicle->registration_no ?? 'N/A' }}</td>
                        <td>{{ $shipment->driver->name ?? 'N/A' }}</td>
                        <td>Rs.{{ number_format($shipment->total_charges, 2) }}</td>
                        <td><span class="badge bg-{{ $shipment->status === 'delivered' ? 'success' : ($shipment->status === 'cancelled' ? 'danger' : 'warning') }}">{{ ucfirst(str_replace('-', ' ', $shipment->status)) }}</span></td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('shipments.show', $shipment) }}" class="btn btn-sm btn-outline-info" title="View">
                                    View
                                </a>
                                <a href="{{ route('shipments.edit', $shipment) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                    Edit
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center">No shipments found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $shipments->links() }}
        </div>
    </div>
</div>
@endsection


