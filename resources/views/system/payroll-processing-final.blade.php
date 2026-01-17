@extends('layouts.app')

@section('title', 'Payroll Processing - Final')
@section('page-title', 'Payroll Processing - (FINAL)')

@section('content')
<div class="page-header">
    <h1 class="page-title">
        <i class="bi bi-cash-coin"></i> Payroll Processing - (FINAL)
    </h1>
    <p class="page-subtitle">Final payroll processing and posting</p>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Final Payroll Processing</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('system.process-payroll-final') }}" onsubmit="return confirm('Are you sure you want to process final payroll? This will post all payroll records.');">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="payroll_month" class="form-label">Payroll Month</label>
                        <input type="month" class="form-control @error('payroll_month') is-invalid @enderror" 
                               id="payroll_month" name="payroll_month" 
                               value="{{ date('Y-m') }}" required>
                        @error('payroll_month')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Department (Optional)</label>
                        <select class="form-select" name="department_id">
                            <option value="">All Departments</option>
                            <!-- Add departments dynamically -->
                        </select>
                    </div>
                </div>
            </div>
            <div class="alert alert-warning">
                <i class="bi bi-exclamation-triangle"></i> <strong>Final Processing:</strong> This will finalize and post all payroll records for the selected month. This action cannot be reversed.
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-circle"></i> Process Final Payroll
            </button>
        </form>
    </div>
</div>
@endsection

