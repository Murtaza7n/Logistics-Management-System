@extends('layouts.app')

@section('title', 'Create Booking')
@section('page-title', 'Create New Booking')

@section('content')
<div class="page-header">
    <h1 class="page-title">Create New Booking</h1>
    <p class="page-subtitle">Enter booking details</p>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Booking Details</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('bookings.store') }}" method="POST">
            @csrf
            
            <div class="row mb-3">
                <div class="col-md-3">
                    <label for="booking_number" class="form-label">Booking Number <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('booking_number') is-invalid @enderror" 
                           id="booking_number" name="booking_number" 
                           value="{{ old('booking_number') }}" required>
                    @error('booking_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label for="booking_date" class="form-label">Booking Date <span class="text-danger">*</span></label>
                    <input type="date" class="form-control @error('booking_date') is-invalid @enderror" 
                           id="booking_date" name="booking_date" 
                           value="{{ old('booking_date', date('Y-m-d')) }}" required>
                    @error('booking_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                        <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ old('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Shipper Section -->
            <div class="card mb-3" style="border-left: 4px solid var(--success-color);">
                <div class="card-header bg-success text-white">
                    <strong>SHIPPER INFORMATION</strong>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label for="shipper_code" class="form-label">Code</label>
                            <select class="form-select" id="shipper_code" name="shipper_code">
                                <option value="">Choose Account Code...</option>
                                @foreach($customers as $customer)
                                <option value="{{ $customer->account_code ?? $customer->customer_id }}" 
                                        data-name="{{ $customer->name }}"
                                        data-address="{{ $customer->address }}"
                                        data-contact="{{ $customer->contact }}"
                                        {{ old('shipper_code') == ($customer->account_code ?? $customer->customer_id) ? 'selected' : '' }}>
                                    {{ $customer->account_code ?? 'CUST-' . $customer->customer_id }} - {{ $customer->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="customer_id" class="form-label">Link Customer</label>
                            <select class="form-select" id="customer_id" name="customer_id">
                                <option value="">Select Customer (Optional)</option>
                                @foreach($customers as $customer)
                                <option value="{{ $customer->customer_id }}" {{ old('customer_id') == $customer->customer_id ? 'selected' : '' }}>{{ $customer->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="shipper_name" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('shipper_name') is-invalid @enderror" 
                                   id="shipper_name" name="shipper_name" 
                                   value="{{ old('shipper_name') }}" required>
                            @error('shipper_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="shipper_address_line1" class="form-label">Address Line 1</label>
                            <input type="text" class="form-control" id="shipper_address_line1" 
                                   name="shipper_address_line1" value="{{ old('shipper_address_line1') }}">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="shipper_address_line2" class="form-label">Address Line 2</label>
                            <input type="text" class="form-control" id="shipper_address_line2" 
                                   name="shipper_address_line2" value="{{ old('shipper_address_line2') }}">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="shipper_address_line3" class="form-label">Address Line 3</label>
                            <input type="text" class="form-control" id="shipper_address_line3" 
                                   name="shipper_address_line3" value="{{ old('shipper_address_line3') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="shipper_contact" class="form-label">Contact</label>
                            <input type="text" class="form-control" id="shipper_contact" 
                                   name="shipper_contact" value="{{ old('shipper_contact') }}">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Consignee Section -->
            <div class="card mb-3" style="border-left: 4px solid var(--info-color);">
                <div class="card-header bg-info text-white">
                    <strong>CONSIGNEE INFORMATION</strong>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label for="consignee_code" class="form-label">Code</label>
                            <select class="form-select" id="consignee_code" name="consignee_code">
                                <option value="">Choose Account Code...</option>
                                @foreach($vendors as $vendor)
                                <option value="{{ $vendor->account_code ?? $vendor->vendor_id }}" 
                                        data-name="{{ $vendor->name }}"
                                        data-address="{{ $vendor->address }}"
                                        data-contact="{{ $vendor->contact }}"
                                        {{ old('consignee_code') == ($vendor->account_code ?? $vendor->vendor_id) ? 'selected' : '' }}>
                                    {{ $vendor->account_code ?? 'VEND-' . $vendor->vendor_id }} - {{ $vendor->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="vendor_id" class="form-label">Link Vendor</label>
                            <select class="form-select" id="vendor_id" name="vendor_id">
                                <option value="">Select Vendor (Optional)</option>
                                @foreach($vendors as $vendor)
                                <option value="{{ $vendor->vendor_id }}" {{ old('vendor_id') == $vendor->vendor_id ? 'selected' : '' }}>{{ $vendor->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="consignee_name" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('consignee_name') is-invalid @enderror" 
                                   id="consignee_name" name="consignee_name" 
                                   value="{{ old('consignee_name') }}" required>
                            @error('consignee_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="consignee_address_line1" class="form-label">Address Line 1</label>
                            <input type="text" class="form-control" id="consignee_address_line1" 
                                   name="consignee_address_line1" value="{{ old('consignee_address_line1') }}">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="consignee_address_line2" class="form-label">Address Line 2</label>
                            <input type="text" class="form-control" id="consignee_address_line2" 
                                   name="consignee_address_line2" value="{{ old('consignee_address_line2') }}">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="consignee_address_line3" class="form-label">Address Line 3</label>
                            <input type="text" class="form-control" id="consignee_address_line3" 
                                   name="consignee_address_line3" value="{{ old('consignee_address_line3') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="consignee_contact" class="form-label">Contact</label>
                            <input type="text" class="form-control" id="consignee_contact" 
                                   name="consignee_contact" value="{{ old('consignee_contact') }}">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cargo Details -->
            <div class="card mb-3">
                <div class="card-header">
                    <strong>CARGO DETAILS</strong>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label for="pickup_city" class="form-label">Pickup City <span class="text-danger">*</span></label>
                            <select class="form-select @error('pickup_city') is-invalid @enderror" id="pickup_city" name="pickup_city" required>
                                <option value="">Select City</option>
                                @foreach($cities as $city)
                                <option value="{{ $city->name }}" {{ old('pickup_city') == $city->name ? 'selected' : '' }}>{{ $city->name }}</option>
                                @endforeach
                            </select>
                            @error('pickup_city')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="delivery_city" class="form-label">Delivery City <span class="text-danger">*</span></label>
                            <select class="form-select @error('delivery_city') is-invalid @enderror" id="delivery_city" name="delivery_city" required>
                                <option value="">Select City</option>
                                @foreach($cities as $city)
                                <option value="{{ $city->name }}" {{ old('delivery_city') == $city->name ? 'selected' : '' }}>{{ $city->name }}</option>
                                @endforeach
                            </select>
                            @error('delivery_city')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="cargo_type" class="form-label">Cargo Type</label>
                            <input type="text" class="form-control" id="cargo_type" name="cargo_type" value="{{ old('cargo_type') }}">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="weight" class="form-label">Weight (kg)</label>
                            <input type="number" step="0.01" class="form-control" id="weight" name="weight" value="{{ old('weight') }}">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" value="{{ old('quantity', 1) }}" min="1">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="estimated_freight" class="form-label">Estimated Freight</label>
                            <input type="number" step="0.01" class="form-control" id="estimated_freight" name="estimated_freight" value="{{ old('estimated_freight') }}">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notes -->
            <div class="mb-3">
                <label for="notes" class="form-label">Notes</label>
                <textarea class="form-control" id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Create Booking</button>
                <a href="{{ route('bookings.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script>
// Auto-fill shipper details
document.getElementById('shipper_code').addEventListener('change', function() {
    const option = this.options[this.selectedIndex];
    if (option.dataset.name) {
        document.getElementById('shipper_name').value = option.dataset.name || '';
        document.getElementById('shipper_address_line1').value = option.dataset.address || '';
        document.getElementById('shipper_contact').value = option.dataset.contact || '';
    }
});

// Auto-fill consignee details
document.getElementById('consignee_code').addEventListener('change', function() {
    const option = this.options[this.selectedIndex];
    if (option.dataset.name) {
        document.getElementById('consignee_name').value = option.dataset.name || '';
        document.getElementById('consignee_address_line1').value = option.dataset.address || '';
        document.getElementById('consignee_contact').value = option.dataset.contact || '';
    }
});
</script>
@endsection
