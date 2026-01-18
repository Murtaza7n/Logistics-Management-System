@extends('layouts.app')

@section('title', 'Drivers')
@section('page-title', 'Drivers Management')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"> Drivers</h5>
        <a href="{{ route('drivers.create') }}" class="btn btn-primary btn-sm">
             Add Driver
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Driver ID</th>
                        <th>Name</th>
                        <th>License #</th>
                        <th>Contact</th>
                        <th>Assigned Vehicle</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($drivers as $driver)
                    <tr>
                        <td>{{ $driver->driver_id }}</td>
                        <td>{{ $driver->name }}</td>
                        <td>{{ $driver->license_no }}</td>
                        <td>{{ $driver->contact ?? 'N/A' }}</td>
                        <td>{{ $driver->vehicle->registration_no ?? 'N/A' }}</td>
                        <td><span class="badge bg-{{ $driver->status === 'available' ? 'success' : ($driver->status === 'on-trip' ? 'warning' : 'secondary') }}">{{ ucfirst(str_replace('-', ' ', $driver->status)) }}</span></td>
                        <td>
                            <a href="{{ route('drivers.show', $driver) }}" class="btn btn-sm btn-outline-info">
                                
                            </a>
                            <a href="{{ route('drivers.edit', $driver) }}" class="btn btn-sm btn-outline-primary">
                                
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">No drivers found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $drivers->links() }}
        </div>
    </div>
</div>
@endsection


