@extends('layouts.app')

@section('title', 'Vehicles')
@section('page-title', 'Vehicles Management')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"> Vehicles</h5>
        <a href="{{ route('vehicles.create') }}" class="btn btn-primary btn-sm">
             Add Vehicle
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Vehicle ID</th>
                        <th>Type</th>
                        <th>Registration #</th>
                        <th>Make/Model</th>
                        <th>Capacity</th>
                        <th>Assigned Driver</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($vehicles as $vehicle)
                    <tr>
                        <td>{{ $vehicle->vehicle_id }}</td>
                        <td>{{ $vehicle->type }}</td>
                        <td>{{ $vehicle->registration_no }}</td>
                        <td>{{ $vehicle->make }} {{ $vehicle->model }}</td>
                        <td>{{ $vehicle->capacity ?? 'N/A' }} kg</td>
                        <td>{{ $vehicle->driver->name ?? 'N/A' }}</td>
                        <td><span class="badge bg-{{ $vehicle->status === 'available' ? 'success' : ($vehicle->status === 'in-use' ? 'warning' : 'secondary') }}">{{ ucfirst(str_replace('-', ' ', $vehicle->status)) }}</span></td>
                        <td>
                            <a href="{{ route('vehicles.show', $vehicle) }}" class="btn btn-sm btn-outline-info">
                                
                            </a>
                            <a href="{{ route('vehicles.edit', $vehicle) }}" class="btn btn-sm btn-outline-primary">
                                
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">No vehicles found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $vehicles->links() }}
        </div>
    </div>
</div>
@endsection


