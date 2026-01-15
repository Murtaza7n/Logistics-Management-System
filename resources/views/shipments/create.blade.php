@extends('layouts.app')

@section('title', 'Create Shipment')
@section('page-title', 'Create Shipment')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="bi bi-box-seam"></i> Create New Shipment</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('shipments.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="shipment_number" class="form-label">Shipment Number <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="shipment_number" name="shipment_number" value="{{ old('shipment_number') }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="customer_id" class="form-label">Customer <span class="text-danger">*</span></label>
                    <select class="form-select" id="customer_id" name="customer_id" required>
                        <option value="">Select Customer</option>
                        @foreach($customers as $customer)
                        <option value="{{ $customer->customer_id }}" {{ old('customer_id') == $customer->customer_id ? 'selected' : '' }}>{{ $customer->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="vendor_id" class="form-label">Vendor</label>
                    <select class="form-select" id="vendor_id" name="vendor_id">
                        <option value="">Select Vendor</option>
                        @foreach($vendors as $vendor)
                        <option value="{{ $vendor->vendor_id }}" {{ old('vendor_id') == $vendor->vendor_id ? 'selected' : '' }}>{{ $vendor->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="cargo_type" class="form-label">Cargo Type <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="cargo_type" name="cargo_type" value="{{ old('cargo_type') }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="sender" class="form-label">Sender <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="sender" name="sender" value="{{ old('sender') }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="receiver" class="form-label">Receiver <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="receiver" name="receiver" value="{{ old('receiver') }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="pickup_city" class="form-label">Pickup City <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="pickup_city" name="pickup_city" value="{{ old('pickup_city') }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="delivery_city" class="form-label">Delivery City <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="delivery_city" name="delivery_city" value="{{ old('delivery_city') }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="weight" class="form-label">Weight (kg)</label>
                    <input type="number" step="0.01" class="form-control" id="weight" name="weight" value="{{ old('weight') }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="dimension" class="form-label">Dimension</label>
                    <input type="text" class="form-control" id="dimension" name="dimension" value="{{ old('dimension') }}" placeholder="L x W x H">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="freight_charges" class="form-label">Freight Charges</label>
                    <input type="number" step="0.01" class="form-control" id="freight_charges" name="freight_charges" value="{{ old('freight_charges', 0) }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="labor_charges" class="form-label">Labor Charges</label>
                    <input type="number" step="0.01" class="form-control" id="labor_charges" name="labor_charges" value="{{ old('labor_charges', 0) }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="other_charges" class="form-label">Other Charges</label>
                    <input type="number" step="0.01" class="form-control" id="other_charges" name="other_charges" value="{{ old('other_charges', 0) }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="vehicle_id" class="form-label">Vehicle</label>
                    <select class="form-select" id="vehicle_id" name="vehicle_id">
                        <option value="">Select Vehicle</option>
                        @foreach($vehicles as $vehicle)
                        <option value="{{ $vehicle->vehicle_id }}" {{ old('vehicle_id') == $vehicle->vehicle_id ? 'selected' : '' }}>{{ $vehicle->registration_no }} ({{ $vehicle->type }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="driver_id" class="form-label">Driver</label>
                    <select class="form-select" id="driver_id" name="driver_id">
                        <option value="">Select Driver</option>
                        @foreach($drivers as $driver)
                        <option value="{{ $driver->driver_id }}" {{ old('driver_id') == $driver->driver_id ? 'selected' : '' }}>{{ $driver->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                    <select class="form-select" id="status" name="status" required>
                        <option value="booked" {{ old('status') === 'booked' ? 'selected' : '' }}>Booked</option>
                        <option value="picked-up" {{ old('status') === 'picked-up' ? 'selected' : '' }}>Picked Up</option>
                        <option value="in-transit" {{ old('status') === 'in-transit' ? 'selected' : '' }}>In Transit</option>
                        <option value="out-for-delivery" {{ old('status') === 'out-for-delivery' ? 'selected' : '' }}>Out for Delivery</option>
                        <option value="delivered" {{ old('status') === 'delivered' ? 'selected' : '' }}>Delivered</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="pickup_date" class="form-label">Pickup Date</label>
                    <input type="date" class="form-control" id="pickup_date" name="pickup_date" value="{{ old('pickup_date') }}">
                </div>
                <div class="col-md-12 mb-3">
                    <label for="notes" class="form-label">Notes</label>
                    <textarea class="form-control" id="notes" name="notes" rows="2">{{ old('notes') }}</textarea>
                </div>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle"></i> Create Shipment
                </button>
                <a href="{{ route('shipments.index') }}" class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection


