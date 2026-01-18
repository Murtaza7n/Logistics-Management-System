@extends('layouts.app')

@section('title', 'Create Invoice')
@section('page-title', 'Create Invoice')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0"> Create New Invoice</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('invoices.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="invoice_type" class="form-label">Invoice Type <span class="text-danger">*</span></label>
                    <select class="form-select" id="invoice_type" name="invoice_type" required>
                        <option value="customer" {{ old('invoice_type') === 'customer' ? 'selected' : '' }}>Customer</option>
                        <option value="vendor" {{ old('invoice_type') === 'vendor' ? 'selected' : '' }}>Vendor</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3" id="customer_field">
                    <label for="customer_id" class="form-label">Customer <span class="text-danger">*</span></label>
                    <select class="form-select" id="customer_id" name="customer_id">
                        <option value="">Select Customer</option>
                        @foreach($customers as $customer)
                        <option value="{{ $customer->customer_id }}" {{ old('customer_id') == $customer->customer_id ? 'selected' : '' }}>{{ $customer->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3" id="vendor_field" style="display:none;">
                    <label for="vendor_id" class="form-label">Vendor <span class="text-danger">*</span></label>
                    <select class="form-select" id="vendor_id" name="vendor_id">
                        <option value="">Select Vendor</option>
                        @foreach($vendors as $vendor)
                        <option value="{{ $vendor->vendor_id }}" {{ old('vendor_id') == $vendor->vendor_id ? 'selected' : '' }}>{{ $vendor->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="invoice_date" class="form-label">Invoice Date <span class="text-danger">*</span></label>
                    <input type="date" class="form-control" id="invoice_date" name="invoice_date" value="{{ old('invoice_date', date('Y-m-d')) }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="due_date" class="form-label">Due Date</label>
                    <input type="date" class="form-control" id="due_date" name="due_date" value="{{ old('due_date') }}">
                </div>
                <div class="col-md-12 mb-3">
                    <label for="shipment_ids" class="form-label">Shipments <span class="text-danger">*</span></label>
                    <select class="form-select" id="shipment_ids" name="shipment_ids[]" multiple required size="5">
                        @foreach($shipments as $shipment)
                        <option value="{{ $shipment->shipment_id }}">{{ $shipment->shipment_number }} - Rs.{{ number_format($shipment->total_charges, 2) }}</option>
                        @endforeach
                    </select>
                    <small class="form-text text-muted">Hold Ctrl/Cmd to select multiple shipments</small>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="tax_rate" class="form-label">Tax Rate (%)</label>
                    <input type="number" step="0.01" class="form-control" id="tax_rate" name="tax_rate" value="{{ old('tax_rate', 0) }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="discount" class="form-label">Discount</label>
                    <input type="number" step="0.01" class="form-control" id="discount" name="discount" value="{{ old('discount', 0) }}">
                </div>
                <div class="col-md-12 mb-3">
                    <label for="notes" class="form-label">Notes</label>
                    <textarea class="form-control" id="notes" name="notes" rows="2">{{ old('notes') }}</textarea>
                </div>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">
                     Create Invoice
                </button>
                <a href="{{ route('invoices.index') }}" class="btn btn-secondary">
                     Cancel
                </a>
            </div>
        </form>
    </div>
</div>
<script>
document.getElementById('invoice_type').addEventListener('change', function() {
    const customerField = document.getElementById('customer_field');
    const vendorField = document.getElementById('vendor_field');
    if (this.value === 'vendor') {
        customerField.style.display = 'none';
        vendorField.style.display = 'block';
        document.getElementById('customer_id').required = false;
        document.getElementById('vendor_id').required = true;
    } else {
        customerField.style.display = 'block';
        vendorField.style.display = 'none';
        document.getElementById('customer_id').required = true;
        document.getElementById('vendor_id').required = false;
    }
});
</script>
@endsection

