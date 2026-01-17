@extends('layouts.app')

@section('title', 'Vehicle Usage Report')
@section('page-title', 'Vehicle Usage Report')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0"> Vehicle Usage Report</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Vehicle</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Total Shipments</th>
                        <th>Total Revenue</th>
                        <th>Assigned Driver</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($vehicles as $vehicle)
                    <tr>
                        <td>{{ $vehicle->registration_no }}</td>
                        <td>{{ $vehicle->type }}</td>
                        <td><span class="badge bg-{{ $vehicle->status === 'available' ? 'success' : 'warning' }}">{{ ucfirst(str_replace('-', ' ', $vehicle->status)) }}</span></td>
                        <td>{{ $vehicle->total_shipments }}</td>
                        <td>Rs.{{ number_format($vehicle->total_revenue, 2) }}</td>
                        <td>{{ $vehicle->driver->name ?? 'N/A' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">No vehicles found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection


