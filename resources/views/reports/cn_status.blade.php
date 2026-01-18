@extends('layouts.app')

@section('title', 'C/N Status Report')
@section('page-title', 'C/N Status Report')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">
        
        C/N Status Report
    </h1>
    <p class="page-subtitle">Status overview of all consignment notes</p>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"> Filters</h5>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('reports.cn-status') }}" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    <option value="booked" {{ request('status') == 'booked' ? 'selected' : '' }}>Booked</option>
                    <option value="picked-up" {{ request('status') == 'picked-up' ? 'selected' : '' }}>Picked Up</option>
                    <option value="in-transit" {{ request('status') == 'in-transit' ? 'selected' : '' }}>In Transit</option>
                    <option value="out-for-delivery" {{ request('status') == 'out-for-delivery' ? 'selected' : '' }}>Out for Delivery</option>
                    <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
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

<!-- Status Summary -->
<div class="row mb-4">
    @foreach($statusCounts as $status => $count)
    <div class="col-md-2 mb-3">
        <div class="stat-card" style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);">
            <h3>{{ $count }}</h3>
            <p>{{ ucfirst(str_replace('-', ' ', $status)) }}</p>
        </div>
    </div>
    @endforeach
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"> C/N Status Details</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>C/N No.</th>
                        <th>Shipper</th>
                        <th>Consignee</th>
                        <th>Status</th>
                        <th>Vehicle</th>
                        <th>Driver</th>
                        <th>Created Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($shipments as $shipment)
                    <tr>
                        <td><strong>{{ $shipment->shipment_number }}</strong></td>
                        <td>{{ $shipment->shipper_name ?? 'N/A' }}</td>
                        <td>{{ $shipment->consignee_name ?? 'N/A' }}</td>
                        <td>
                            <span class="badge bg-{{ $shipment->status === 'delivered' ? 'success' : ($shipment->status === 'cancelled' ? 'danger' : 'warning') }}">
                                {{ ucfirst(str_replace('-', ' ', $shipment->status)) }}
                            </span>
                        </td>
                        <td>{{ $shipment->vehicle->registration_no ?? 'N/A' }}</td>
                        <td>{{ $shipment->driver->name ?? 'N/A' }}</td>
                        <td>{{ $shipment->created_at->format('Y-m-d') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">No records found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

