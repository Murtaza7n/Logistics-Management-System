@extends('layouts.app')

@section('title', 'Driver Performance Report')
@section('page-title', 'Driver Performance Report')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0"> Driver Performance Report</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Driver</th>
                        <th>License #</th>
                        <th>Status</th>
                        <th>Total Shipments</th>
                        <th>Delivered</th>
                        <th>On-Time Deliveries</th>
                        <th>Assigned Vehicle</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($drivers as $driver)
                    <tr>
                        <td>{{ $driver->name }}</td>
                        <td>{{ $driver->license_no }}</td>
                        <td><span class="badge bg-{{ $driver->status === 'available' ? 'success' : 'warning' }}">{{ ucfirst(str_replace('-', ' ', $driver->status)) }}</span></td>
                        <td>{{ $driver->total_shipments }}</td>
                        <td>{{ $driver->delivered_shipments }}</td>
                        <td>{{ $driver->on_time_deliveries }}</td>
                        <td>{{ $driver->vehicle->registration_no ?? 'N/A' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">No drivers found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection


