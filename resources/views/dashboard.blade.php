@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-md-3">
        <div class="stat-card">
            <h3>{{ $stats['total_shipments'] }}</h3>
            <p><i class="bi bi-box-seam"></i> Total Shipments</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <h3>{{ $stats['active_shipments'] }}</h3>
            <p><i class="bi bi-arrow-repeat"></i> Active Shipments</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <h3>{{ $stats['total_customers'] }}</h3>
            <p><i class="bi bi-people"></i> Active Customers</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <h3>${{ number_format($stats['total_revenue'], 2) }}</h3>
            <p><i class="bi bi-cash-stack"></i> Total Revenue</p>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-clock-history"></i> Recent Shipments</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Shipment #</th>
                                <th>Customer</th>
                                <th>From → To</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recent_shipments as $shipment)
                            <tr>
                                <td><a href="{{ route('shipments.show', $shipment) }}">{{ $shipment->shipment_number }}</a></td>
                                <td>{{ $shipment->customer->name }}</td>
                                <td>{{ $shipment->pickup_city }} → {{ $shipment->delivery_city }}</td>
                                <td>
                                    <span class="badge bg-{{ $shipment->status === 'delivered' ? 'success' : ($shipment->status === 'cancelled' ? 'danger' : 'warning') }}">
                                        {{ ucfirst(str_replace('-', ' ', $shipment->status)) }}
                                    </span>
                                </td>
                                <td>{{ $shipment->created_at->format('M d, Y') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">No shipments found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-pie-chart"></i> Shipments by Status</h5>
            </div>
            <div class="card-body">
                @foreach($shipments_by_status as $status)
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span>{{ ucfirst(str_replace('-', ' ', $status->status)) }}</span>
                    <span class="badge bg-secondary">{{ $status->count }}</span>
                </div>
                @endforeach
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-trophy"></i> Top Customers</h5>
            </div>
            <div class="card-body">
                @foreach($top_customers as $customer)
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span>{{ $customer->name }}</span>
                    <span class="text-success">${{ number_format($customer->total_revenue, 2) }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection


