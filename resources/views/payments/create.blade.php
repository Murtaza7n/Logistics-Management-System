@extends('layouts.app')

@section('title', 'Record Payment')
@section('page-title', 'Record Payment')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="bi bi-credit-card"></i> Record Payment</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('payments.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="invoice_id" class="form-label">Invoice <span class="text-danger">*</span></label>
                    <select class="form-select" id="invoice_id" name="invoice_id" required>
                        <option value="">Select Invoice</option>
                        @foreach($invoices as $inv)
                        <option value="{{ $inv->invoice_id }}" {{ old('invoice_id', request('invoice_id')) == $inv->invoice_id ? 'selected' : '' }}>
                            {{ $inv->invoice_number }} - Balance: ${{ number_format($inv->balance, 2) }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="amount_paid" class="form-label">Amount Paid <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" class="form-control" id="amount_paid" name="amount_paid" value="{{ old('amount_paid') }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="payment_date" class="form-label">Payment Date <span class="text-danger">*</span></label>
                    <input type="date" class="form-control" id="payment_date" name="payment_date" value="{{ old('payment_date', date('Y-m-d')) }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="method" class="form-label">Payment Method <span class="text-danger">*</span></label>
                    <select class="form-select" id="method" name="method" required>
                        <option value="cash" {{ old('method') === 'cash' ? 'selected' : '' }}>Cash</option>
                        <option value="bank_transfer" {{ old('method') === 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                        <option value="cheque" {{ old('method') === 'cheque' ? 'selected' : '' }}>Cheque</option>
                        <option value="credit_card" {{ old('method') === 'credit_card' ? 'selected' : '' }}>Credit Card</option>
                        <option value="other" {{ old('method') === 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="reference_number" class="form-label">Reference Number</label>
                    <input type="text" class="form-control" id="reference_number" name="reference_number" value="{{ old('reference_number') }}">
                </div>
                <div class="col-md-12 mb-3">
                    <label for="notes" class="form-label">Notes</label>
                    <textarea class="form-control" id="notes" name="notes" rows="2">{{ old('notes') }}</textarea>
                </div>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle"></i> Record Payment
                </button>
                <a href="{{ route('payments.index') }}" class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection


