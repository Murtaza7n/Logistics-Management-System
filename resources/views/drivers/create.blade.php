@extends('layouts.app')

@section('title', 'Create Driver')
@section('page-title', 'Create Driver')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0"> Create New Driver</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('drivers.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="license_no" class="form-label">License Number <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="license_no" name="license_no" value="{{ old('license_no') }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="contact" class="form-label">Contact</label>
                    <input type="text" class="form-control" id="contact" name="contact" value="{{ old('contact') }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="assigned_vehicle" class="form-label">Assigned Vehicle</label>
                    <select class="form-select" id="assigned_vehicle" name="assigned_vehicle">
                        <option value="">Select Vehicle</option>
                        @foreach($vehicles as $vehicle)
                        <option value="{{ $vehicle->vehicle_id }}" {{ old('assigned_vehicle') == $vehicle->vehicle_id ? 'selected' : '' }}>{{ $vehicle->registration_no }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                    <select class="form-select" id="status" name="status" required>
                        <option value="available" {{ old('status') === 'available' ? 'selected' : '' }}>Available</option>
                        <option value="on-trip" {{ old('status') === 'on-trip' ? 'selected' : '' }}>On Trip</option>
                        <option value="off-duty" {{ old('status') === 'off-duty' ? 'selected' : '' }}>Off Duty</option>
                    </select>
                </div>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">
                     Create Driver
                </button>
                <a href="{{ route('drivers.index') }}" class="btn btn-secondary">
                     Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection


