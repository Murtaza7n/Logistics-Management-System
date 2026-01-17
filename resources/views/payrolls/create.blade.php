@extends('layouts.app')

@section('title', 'Create Payroll')
@section('page-title', 'Create Payroll')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0"> Create New Payroll</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('payrolls.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="emp_id" class="form-label">Employee <span class="text-danger">*</span></label>
                    <select class="form-select" id="emp_id" name="emp_id" required>
                        <option value="">Select Employee</option>
                        @foreach($employees as $emp)
                        <option value="{{ $emp->emp_id }}" {{ old('emp_id') == $emp->emp_id ? 'selected' : '' }}>{{ $emp->name }} (ID: {{ $emp->emp_id }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="month" class="form-label">Month <span class="text-danger">*</span></label>
                    <input type="month" class="form-control" id="month" name="month" value="{{ old('month', date('Y-m')) }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="basic_salary" class="form-label">Basic Salary <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" class="form-control" id="basic_salary" name="basic_salary" value="{{ old('basic_salary') }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="overtime" class="form-label">Overtime</label>
                    <input type="number" step="0.01" class="form-control" id="overtime" name="overtime" value="{{ old('overtime', 0) }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="bonus" class="form-label">Bonus</label>
                    <input type="number" step="0.01" class="form-control" id="bonus" name="bonus" value="{{ old('bonus', 0) }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="deductions" class="form-label">Deductions</label>
                    <input type="number" step="0.01" class="form-control" id="deductions" name="deductions" value="{{ old('deductions', 0) }}">
                </div>
                <div class="col-md-12 mb-3">
                    <label for="deduction_details" class="form-label">Deduction Details</label>
                    <textarea class="form-control" id="deduction_details" name="deduction_details" rows="2">{{ old('deduction_details') }}</textarea>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                    <select class="form-select" id="status" name="status" required>
                        <option value="pending" {{ old('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="paid" {{ old('status') === 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="cancelled" {{ old('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="payment_date" class="form-label">Payment Date</label>
                    <input type="date" class="form-control" id="payment_date" name="payment_date" value="{{ old('payment_date') }}">
                </div>
                <div class="col-md-12 mb-3">
                    <label for="notes" class="form-label">Notes</label>
                    <textarea class="form-control" id="notes" name="notes" rows="2">{{ old('notes') }}</textarea>
                </div>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">
                     Create Payroll
                </button>
                <a href="{{ route('payrolls.index') }}" class="btn btn-secondary">
                     Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection


