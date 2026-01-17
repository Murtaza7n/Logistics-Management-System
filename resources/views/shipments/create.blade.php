@extends('layouts.app')

@section('title', 'CN Entry - Create Shipment')
@section('page-title', 'CN Entry - Create Consignment Note')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">
        <i class="bi bi-file-plus"></i>
        Create New Consignment Note
    </h1>
    <p class="page-subtitle">Enter consignment details to create a new CN entry</p>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="bi bi-box-seam"></i> C/N ENTRY - Consignment Note Details</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('shipments.store') }}" method="POST" id="cnEntryForm">
            @csrf
            
            <!-- Top Row: CN Book, City, CN Number, C Type -->
            <div class="row mb-4 g-3">
                <div class="col-12 col-md-6 col-lg-3 mb-3">
                    <label for="cn_book_id" class="form-label">CN Book <span class="text-danger">*</span></label>
                    <select class="form-select @error('cn_book_id') is-invalid @enderror" id="cn_book_id" name="cn_book_id" required>
                        <option value="">Select CN Book</option>
                        @foreach($cnBooks ?? [] as $book)
                        <option value="{{ $book->id }}" 
                                data-city-code="{{ $book->city_code }}"
                                data-system-year="{{ $book->system_year }}"
                                data-start="{{ $book->start_number }}"
                                data-end="{{ $book->end_number }}"
                                data-remaining="{{ $book->remaining_count }}"
                                {{ old('cn_book_id') == $book->id ? 'selected' : '' }}>
                            {{ $book->book_number }} ({{ $book->remaining_count }} remaining)
                        </option>
                        @endforeach
                    </select>
                    @error('cn_book_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">Select the CN Book to issue number from</small>
                </div>
                <div class="col-12 col-md-6 col-lg-3 mb-3">
                    <label for="entry_city" class="form-label">City <span class="text-danger">*</span></label>
                    <select class="form-select @error('entry_city') is-invalid @enderror" id="entry_city" name="entry_city" required>
                        <option value="">Select User City</option>
                        @foreach($cities ?? [] as $city)
                        <option value="{{ $city->city_id }}" {{ old('entry_city') == $city->city_id ? 'selected' : '' }}>{{ $city->name }}</option>
                        @endforeach
                    </select>
                    @error('entry_city')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-12 col-md-6 col-lg-3 mb-3">
                    <label for="shipment_number" class="form-label">
                        C/N No. <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                        <input type="text" 
                               class="form-control @error('shipment_number') is-invalid @enderror" 
                               id="shipment_number" 
                               name="shipment_number" 
                               value="{{ old('shipment_number') }}" 
                               placeholder="Enter CN Number or Auto-generate"
                               autofocus>
                        <button type="button" 
                                class="btn btn-outline-secondary" 
                                id="autoGenerateBtn"
                                title="Auto-generate CN Number">
                            Auto
                        </button>
                        <input type="hidden" name="auto_generate_cn" id="auto_generate_cn" value="0">
                    </div>
                    @error('shipment_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">Leave empty and click Auto to generate automatically</small>
                </div>
                <div class="col-12 col-md-6 col-lg-4 mb-3">
                    <label for="system_year" class="form-label">System Year</label>
                    <select class="form-select" id="system_year" name="system_year">
                        <option value="2526" {{ old('system_year', session('system_year', '2526')) == '2526' ? 'selected' : '' }}>2526</option>
                        <option value="2425" {{ old('system_year') == '2425' ? 'selected' : '' }}>2425</option>
                        <option value="2324" {{ old('system_year') == '2324' ? 'selected' : '' }}>2324</option>
                        <option value="2223" {{ old('system_year') == '2223' ? 'selected' : '' }}>2223</option>
                        <option value="2122" {{ old('system_year') == '2122' ? 'selected' : '' }}>2122</option>
                        <option value="2021" {{ old('system_year') == '2021' ? 'selected' : '' }}>2021</option>
                        <option value="1920" {{ old('system_year') == '1920' ? 'selected' : '' }}>1920</option>
                        <option value="1819" {{ old('system_year') == '1819' ? 'selected' : '' }}>1819</option>
                    </select>
                </div>
                <div class="col-12 col-md-6 col-lg-4 mb-3">
                    <label for="cn_type" class="form-label">C (Type)</label>
                    <input type="text" 
                           class="form-control" 
                           id="cn_type" 
                           name="cn_type" 
                           value="{{ old('cn_type') }}" 
                           placeholder="CN Type">
                </div>
            </div>

            <!-- Shipper Section -->
            <div class="card mb-4" style="border-left: 4px solid var(--success-color);">
                <div class="section-header">
                    <i class="bi bi-person"></i>
                    <span>SHIPPER INFORMATION</span>
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
                        <div class="col-md-9 mb-3">
                            <label for="shipper_name" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('shipper_name') is-invalid @enderror" 
                                   id="shipper_name" 
                                   name="shipper_name" 
                                   value="{{ old('shipper_name') }}" 
                                   required>
                            @error('shipper_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="shipper_address_line1" class="form-label">Address Line 1</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="shipper_address_line1" 
                                   name="shipper_address_line1" 
                                   value="{{ old('shipper_address_line1') }}">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="shipper_address_line2" class="form-label">Address Line 2</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="shipper_address_line2" 
                                   name="shipper_address_line2" 
                                   value="{{ old('shipper_address_line2') }}">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="shipper_address_line3" class="form-label">Address Line 3</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="shipper_address_line3" 
                                   name="shipper_address_line3" 
                                   value="{{ old('shipper_address_line3') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="shipper_contact" class="form-label">Contact</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="shipper_contact" 
                                   name="shipper_contact" 
                                   value="{{ old('shipper_contact') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="customer_id" class="form-label">Link Customer</label>
                            <select class="form-select" id="customer_id" name="customer_id">
                                <option value="">Select Customer (Optional)</option>
                                @foreach($customers as $customer)
                                <option value="{{ $customer->customer_id }}" {{ old('customer_id') == $customer->customer_id ? 'selected' : '' }}>{{ $customer->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Consignee Section -->
            <div class="card mb-4" style="border-left: 4px solid var(--info-color);">
                <div class="section-header info">
                    <i class="bi bi-person-check"></i>
                    <span>CONSIGNEE INFORMATION</span>
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
                        <div class="col-md-9 mb-3">
                            <label for="consignee_name" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('consignee_name') is-invalid @enderror" 
                                   id="consignee_name" 
                                   name="consignee_name" 
                                   value="{{ old('consignee_name') }}" 
                                   required>
                            @error('consignee_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="consignee_address_line1" class="form-label">Address Line 1</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="consignee_address_line1" 
                                   name="consignee_address_line1" 
                                   value="{{ old('consignee_address_line1') }}">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="consignee_address_line2" class="form-label">Address Line 2</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="consignee_address_line2" 
                                   name="consignee_address_line2" 
                                   value="{{ old('consignee_address_line2') }}">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="consignee_address_line3" class="form-label">Address Line 3</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="consignee_address_line3" 
                                   name="consignee_address_line3" 
                                   value="{{ old('consignee_address_line3') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="consignee_contact" class="form-label">Contact</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="consignee_contact" 
                                   name="consignee_contact" 
                                   value="{{ old('consignee_contact') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="vendor_id" class="form-label">Link Vendor</label>
                            <select class="form-select" id="vendor_id" name="vendor_id">
                                <option value="">Select Vendor (Optional)</option>
                                @foreach($vendors as $vendor)
                                <option value="{{ $vendor->vendor_id }}" {{ old('vendor_id') == $vendor->vendor_id ? 'selected' : '' }}>{{ $vendor->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cargo Details Section -->
            <div class="card mb-4" style="border-left: 4px solid var(--primary-color);">
                <div class="section-header" style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);">
                    <i class="bi bi-box"></i>
                    <span>CARGO DETAILS</span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="cargo_type" class="form-label">Cargo Type <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control" 
                                   id="cargo_type" 
                                   name="cargo_type" 
                                   value="{{ old('cargo_type') }}" 
                                   required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="pickup_city" class="form-label">Pickup City <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control" 
                                   id="pickup_city" 
                                   name="pickup_city" 
                                   value="{{ old('pickup_city') }}" 
                                   required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="delivery_city" class="form-label">Delivery City <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control" 
                                   id="delivery_city" 
                                   name="delivery_city" 
                                   value="{{ old('delivery_city') }}" 
                                   required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="weight" class="form-label">Weight (kg)</label>
                            <input type="number" 
                                   step="0.01" 
                                   class="form-control" 
                                   id="weight" 
                                   name="weight" 
                                   value="{{ old('weight') }}">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" 
                                   class="form-control" 
                                   id="quantity" 
                                   name="quantity" 
                                   value="{{ old('quantity', 1) }}" 
                                   min="1">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="packages" class="form-label">Packages</label>
                            <input type="number" 
                                   step="0.01" 
                                   class="form-control" 
                                   id="packages" 
                                   name="packages" 
                                   value="{{ old('packages') }}">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="packaging_type" class="form-label">Packaging Type</label>
                            <select class="form-select" id="packaging_type" name="packaging_type">
                                <option value="">Select Type</option>
                                <option value="Box" {{ old('packaging_type') == 'Box' ? 'selected' : '' }}>Box</option>
                                <option value="Carton" {{ old('packaging_type') == 'Carton' ? 'selected' : '' }}>Carton</option>
                                <option value="Bag" {{ old('packaging_type') == 'Bag' ? 'selected' : '' }}>Bag</option>
                                <option value="Pallet" {{ old('packaging_type') == 'Pallet' ? 'selected' : '' }}>Pallet</option>
                                <option value="Other" {{ old('packaging_type') == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="dimension" class="form-label">Dimension</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="dimension" 
                                   name="dimension" 
                                   value="{{ old('dimension') }}" 
                                   placeholder="L x W x H">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="declared_value" class="form-label">Declared Value</label>
                            <input type="number" 
                                   step="0.01" 
                                   class="form-control" 
                                   id="declared_value" 
                                   name="declared_value" 
                                   value="{{ old('declared_value') }}">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charges Section -->
            <div class="card mb-4" style="border-left: 4px solid var(--warning-color);">
                <div class="section-header warning">
                    <i class="bi bi-cash-stack"></i>
                    <span>CHARGES & PAYMENT</span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label for="freight_charges" class="form-label">Freight Charges</label>
                            <input type="number" 
                                   step="0.01" 
                                   class="form-control" 
                                   id="freight_charges" 
                                   name="freight_charges" 
                                   value="{{ old('freight_charges', 0) }}">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="labor_charges" class="form-label">Labor Charges</label>
                            <input type="number" 
                                   step="0.01" 
                                   class="form-control" 
                                   id="labor_charges" 
                                   name="labor_charges" 
                                   value="{{ old('labor_charges', 0) }}">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="other_charges" class="form-label">Other Charges</label>
                            <input type="number" 
                                   step="0.01" 
                                   class="form-control" 
                                   id="other_charges" 
                                   name="other_charges" 
                                   value="{{ old('other_charges', 0) }}">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="payment_mode" class="form-label">Payment Mode</label>
                            <select class="form-select" id="payment_mode" name="payment_mode">
                                <option value="">Select Payment Mode</option>
                                <option value="To Pay" {{ old('payment_mode') == 'To Pay' ? 'selected' : '' }}>To Pay</option>
                                <option value="Paid" {{ old('payment_mode') == 'Paid' ? 'selected' : '' }}>Paid</option>
                                <option value="Credit" {{ old('payment_mode') == 'Credit' ? 'selected' : '' }}>Credit</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="delivery_type" class="form-label">Delivery Type</label>
                            <select class="form-select" id="delivery_type" name="delivery_type">
                                <option value="">Select Delivery Type</option>
                                <option value="Door Delivery" {{ old('delivery_type') == 'Door Delivery' ? 'selected' : '' }}>Door Delivery</option>
                                <option value="Self Pickup" {{ old('delivery_type') == 'Self Pickup' ? 'selected' : '' }}>Self Pickup</option>
                                <option value="Station Pickup" {{ old('delivery_type') == 'Station Pickup' ? 'selected' : '' }}>Station Pickup</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Assignment & Status Section -->
            <div class="card mb-4" style="border-left: 4px solid var(--accent-color);">
                <div class="section-header" style="background: linear-gradient(135deg, var(--accent-color) 0%, #0284c7 100%);">
                    <i class="bi bi-truck"></i>
                    <span>ASSIGNMENT & STATUS</span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="vehicle_id" class="form-label">Vehicle</label>
                            <select class="form-select" id="vehicle_id" name="vehicle_id">
                                <option value="">Select Vehicle</option>
                                @foreach($vehicles as $vehicle)
                                <option value="{{ $vehicle->vehicle_id }}" {{ old('vehicle_id') == $vehicle->vehicle_id ? 'selected' : '' }}>{{ $vehicle->registration_no }} ({{ $vehicle->type }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="driver_id" class="form-label">Driver</label>
                            <select class="form-select" id="driver_id" name="driver_id">
                                <option value="">Select Driver</option>
                                @foreach($drivers as $driver)
                                <option value="{{ $driver->driver_id }}" {{ old('driver_id') == $driver->driver_id ? 'selected' : '' }}>{{ $driver->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="booked" {{ old('status') === 'booked' ? 'selected' : '' }}>Booked</option>
                                <option value="picked-up" {{ old('status') === 'picked-up' ? 'selected' : '' }}>Picked Up</option>
                                <option value="in-transit" {{ old('status') === 'in-transit' ? 'selected' : '' }}>In Transit</option>
                                <option value="out-for-delivery" {{ old('status') === 'out-for-delivery' ? 'selected' : '' }}>Out for Delivery</option>
                                <option value="delivered" {{ old('status') === 'delivered' ? 'selected' : '' }}>Delivered</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="pickup_date" class="form-label">Pickup Date</label>
                            <input type="date" 
                                   class="form-control" 
                                   id="pickup_date" 
                                   name="pickup_date" 
                                   value="{{ old('pickup_date') }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="delivery_date" class="form-label">Expected Delivery Date</label>
                            <input type="date" 
                                   class="form-control" 
                                   id="delivery_date" 
                                   name="delivery_date" 
                                   value="{{ old('delivery_date') }}">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notes Section -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea class="form-control" 
                                      id="notes" 
                                      name="notes" 
                                      rows="2">{{ old('notes') }}</textarea>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="special_instructions" class="form-label">Special Instructions</label>
                            <textarea class="form-control" 
                                      id="special_instructions" 
                                      name="special_instructions" 
                                      rows="2">{{ old('special_instructions') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="mt-3">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="bi bi-check-circle"></i> Create CN Entry
                </button>
                <a href="{{ route('shipments.index') }}" class="btn btn-secondary btn-lg">
                    <i class="bi bi-x-circle"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
// Auto-fill shipper details when code is selected
document.getElementById('shipper_code').addEventListener('change', function() {
    const option = this.options[this.selectedIndex];
    if (option.dataset.name) {
        document.getElementById('shipper_name').value = option.dataset.name || '';
        document.getElementById('shipper_address_line1').value = option.dataset.address || '';
        document.getElementById('shipper_contact').value = option.dataset.contact || '';
    }
});

// Auto-fill consignee details when code is selected
document.getElementById('consignee_code').addEventListener('change', function() {
    const option = this.options[this.selectedIndex];
    if (option.dataset.name) {
        document.getElementById('consignee_name').value = option.dataset.name || '';
        document.getElementById('consignee_address_line1').value = option.dataset.address || '';
        document.getElementById('consignee_contact').value = option.dataset.contact || '';
    }
});

// Auto-generate CN Number
document.getElementById('autoGenerateBtn').addEventListener('click', function() {
    const cnInput = document.getElementById('shipment_number');
    const autoGenerateInput = document.getElementById('auto_generate_cn');
    const systemYear = document.getElementById('system_year').value;
    const entryCity = document.getElementById('entry_city').value;
    
    // Set auto-generate flag
    autoGenerateInput.value = '1';
    
    // Clear the input to trigger auto-generation on server
    cnInput.value = '';
    cnInput.placeholder = 'Will be auto-generated on save';
    cnInput.readOnly = true;
    cnInput.style.backgroundColor = '#e9ecef';
    
    // Show message
    const message = document.createElement('small');
    message.className = 'text-success d-block mt-1';
    message.innerHTML = '<i class="bi bi-check-circle"></i> CN Number will be auto-generated on save';
    if (!cnInput.nextElementSibling || !cnInput.nextElementSibling.classList.contains('text-success')) {
        cnInput.parentElement.parentElement.appendChild(message);
    }
});

// Allow manual entry if user types
document.getElementById('shipment_number').addEventListener('input', function() {
    if (this.value.trim() !== '') {
        document.getElementById('auto_generate_cn').value = '0';
        this.readOnly = false;
        this.style.backgroundColor = '';
        this.placeholder = 'Enter CN Number';
    }
});
</script>
@endsection
