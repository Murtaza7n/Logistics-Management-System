@extends('layouts.app')

@section('title', 'Create Vehicle')
@section('page-title', 'Create Vehicle')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0"> Create New Vehicle</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('vehicles.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="type" class="form-label">Type <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="type" name="type" value="{{ old('type') }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="registration_no" class="form-label">Registration Number <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="registration_no" name="registration_no" value="{{ old('registration_no') }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="make" class="form-label">Make</label>
                    <input type="text" class="form-control" id="make" name="make" value="{{ old('make') }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="model" class="form-label">Model</label>
                    <input type="text" class="form-control" id="model" name="model" value="{{ old('model') }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="year" class="form-label">Year</label>
                    <input type="number" class="form-control" id="year" name="year" value="{{ old('year') }}" min="1900" max="{{ date('Y') }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="capacity" class="form-label">Capacity (kg)</label>
                    <input type="number" step="0.01" class="form-control" id="capacity" name="capacity" value="{{ old('capacity') }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                    <select class="form-select" id="status" name="status" required>
                        <option value="available" {{ old('status') === 'available' ? 'selected' : '' }}>Available</option>
                        <option value="in-use" {{ old('status') === 'in-use' ? 'selected' : '' }}>In Use</option>
                        <option value="maintenance" {{ old('status') === 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                        <option value="retired" {{ old('status') === 'retired' ? 'selected' : '' }}>Retired</option>
                    </select>
                </div>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">
                     Create Vehicle
                </button>
                <a href="{{ route('vehicles.index') }}" class="btn btn-secondary">
                     Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection


