@extends('layouts.app')

@section('title', 'Monthly Payroll Processing')
@section('page-title', 'Monthly Payroll Processing')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">
        
        Monthly Payroll Processing
    </h1>
    <p class="page-subtitle">Process monthly payroll for employees</p>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"> Payroll Processing Parameters</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('payroll.process-payroll') }}" method="POST">
            @csrf
            <div class="row mb-4">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Month <span class="text-danger">*</span></label>
                    <select class="form-select" name="month" required>
                        @for($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ $i == date('n') ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Year <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="year" value="{{ date('Y') }}" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Department (Optional)</label>
                    <select class="form-select" name="department_id">
                        <option value="">All Departments</option>
                        @foreach($departments as $dept)
                        <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="process_all" id="process_all" value="1">
                    <label class="form-check-label" for="process_all">
                        Process payroll for all active employees
                    </label>
                </div>
            </div>
            <div class="alert alert-info">
                 This will calculate salaries, deductions, allowances, and generate payroll records for the selected period.
            </div>
            <button type="submit" class="btn btn-primary">
                 Process Payroll
            </button>
        </form>
    </div>
</div>

<div class="card mt-3">
    <div class="card-header">
        <h5 class="mb-0"> Recent Payroll Records</h5>
    </div>
    <div class="card-body">
        <div class="alert alert-secondary">
             Processed payroll records will appear here. Use the Payroll Records section to view detailed payroll information.
        </div>
        <a href="{{ route('payrolls.index') }}" class="btn btn-secondary">
             View All Payroll Records
        </a>
    </div>
</div>
@endsection

