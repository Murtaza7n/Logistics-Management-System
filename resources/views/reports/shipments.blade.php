@extends('layouts.app')

@section('title', 'Shipment Reports')
@section('page-title', 'Shipment Reports')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="bi bi-box-seam"></i> Shipment Reports</h5>
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
                        <option value="booked" {{ request('status') === 'booked' ? 'selected' : '' }}>Booked</option>
                        <option value="delivered" {{ request('status') === 'delivered' ? 'selected' : '' }}>Delivered</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="{{ route('reports.shipments') }}" class="btn btn-secondary">Reset</a>
                </div>
            </div>
        </form>
        
        <div class="row mb-3">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h6>Total Shipments</h6>
                        <h3>{{ $summary['total'] }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h6>Total Freight</h6>
                        <h3>${{ number_format($summary['total_freight'], 2) }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <h6>Total Labor</h6>
                        <h3>${{ number_format($summary['total_labor'], 2) }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <h6>Grand Total</h6>
                        <h3>${{ number_format($summary['grand_total'], 2) }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('reports.shipments', array_merge(request()->all(), ['export' => 'pdf'])) }}" class="btn btn-danger">
                <i class="bi bi-file-pdf"></i> Export PDF
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Shipment #</th>
                        <th>Customer</th>
                        <th>From → To</th>
                        <th>Status</th>
                        <th>Freight</th>
                        <th>Labor</th>
                        <th>Other</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($shipments as $shipment)
                    <tr>
                        <td>{{ $shipment->shipment_number }}</td>
                        <td>{{ $shipment->customer->name }}</td>
                        <td>{{ $shipment->pickup_city }} → {{ $shipment->delivery_city }}</td>
                        <td><span class="badge bg-{{ $shipment->status === 'delivered' ? 'success' : 'warning' }}">{{ ucfirst(str_replace('-', ' ', $shipment->status)) }}</span></td>
                        <td>${{ number_format($shipment->freight_charges, 2) }}</td>
                        <td>${{ number_format($shipment->labor_charges, 2) }}</td>
                        <td>${{ number_format($shipment->other_charges, 2) }}</td>
                        <td><strong>${{ number_format($shipment->total_charges, 2) }}</strong></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">No shipments found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection


