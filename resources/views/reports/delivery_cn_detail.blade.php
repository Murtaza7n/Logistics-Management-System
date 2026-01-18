@extends('layouts.app')

@section('title', 'Delivery CN Detail Report')
@section('page-title', 'Delivery CN Detail Report')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">
        
        Delivery CN Detail Report
    </h1>
    <p class="page-subtitle">Detailed report of delivered and out-for-delivery consignment notes</p>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"> Filters</h5>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('reports.delivery-cn-detail') }}" class="row g-3">
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
        <h5 class="mb-0"> Delivery CN Details ({{ $shipments->count() }} records)</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>C/N No.</th>
                        <th>Shipper</th>
                        <th>Consignee</th>
                        <th>Vehicle</th>
                        <th>Driver</th>
                        <th>Expected Delivery</th>
                        <th>Actual Delivery</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($shipments as $shipment)
                    <tr>
                        <td><strong>{{ $shipment->shipment_number }}</strong></td>
                        <td>{{ $shipment->shipper_name ?? 'N/A' }}</td>
                        <td>{{ $shipment->consignee_name ?? 'N/A' }}</td>
                        <td>{{ $shipment->vehicle->registration_no ?? 'N/A' }}</td>
                        <td>{{ $shipment->driver->name ?? 'N/A' }}</td>
                        <td>{{ $shipment->delivery_date ? $shipment->delivery_date->format('Y-m-d') : 'N/A' }}</td>
                        <td>{{ $shipment->actual_delivery_date ? $shipment->actual_delivery_date->format('Y-m-d') : 'N/A' }}</td>
                        <td>
                            <span class="badge badge-{{ $shipment->status === 'delivered' ? 'primary' : 'secondary' }}">
                                {{ ucfirst(str_replace('-', ' ', $shipment->status)) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">No records found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

