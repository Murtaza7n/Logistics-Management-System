@extends('layouts.app')

@section('title', 'Edit Shipment')
@section('page-title', 'Edit Shipment')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="bi bi-pencil"></i> Edit Shipment</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('shipments.update', $shipment) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="shipment_number" class="form-label">Shipment Number <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="shipment_number" name="shipment_number" value="{{ old('shipment_number', $shipment->shipment_number) }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="customer_id" class="form-label">Customer <span class="text-danger">*</span></label>
                    <select class="form-select" id="customer_id" name="customer_id" required>
                        <option value="">Select Customer</option>
                        @foreach($customers as $customer)
                        <option value="{{ $customer->customer_id }}" {{ old('customer_id', $shipment->customer_id) == $customer->customer_id ? 'selected' : '' }}>{{ $customer->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                    <select class="form-select" id="status" name="status" required>
                        <option value="booked" {{ old('status', $shipment->status) === 'booked' ? 'selected' : '' }}>Booked</option>
                        <option value="picked-up" {{ old('status', $shipment->status) === 'picked-up' ? 'selected' : '' }}>Picked Up</option>
                        <option value="in-transit" {{ old('status', $shipment->status) === 'in-transit' ? 'selected' : '' }}>In Transit</option>
                        <option value="out-for-delivery" {{ old('status', $shipment->status) === 'out-for-delivery' ? 'selected' : '' }}>Out for Delivery</option>
                        <option value="delivered" {{ old('status', $shipment->status) === 'delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="cancelled" {{ old('status', $shipment->status) === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="vehicle_id" class="form-label">Vehicle</label>
                    <select class="form-select" id="vehicle_id" name="vehicle_id">
                        <option value="">Select Vehicle</option>
                        @foreach($vehicles as $vehicle)
                        <option value="{{ $vehicle->vehicle_id }}" {{ old('vehicle_id', $shipment->vehicle_id) == $vehicle->vehicle_id ? 'selected' : '' }}>{{ $vehicle->registration_no }} ({{ $vehicle->type }})</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle"></i> Update Shipment
                </button>
                <a href="{{ route('shipments.index') }}" class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection


