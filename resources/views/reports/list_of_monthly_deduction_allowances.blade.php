@extends('layouts.app')

@section('title', 'List of Monthly Deduction/Allowances')
@section('page-title', 'List of Monthly Deduction/Allowances')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">
        
        List of Monthly Deduction/Allowances
    </h1>
    <p class="page-subtitle">Monthly deductions and allowances report</p>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"> Filters</h5>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('reports.list-of-monthly-deduction-allowances') }}" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Month</label>
                <select name="month" class="form-select">
                    <option value="">All Months</option>
                    @for($i = 1; $i <= 12; $i++)
                    <option value="{{ $i }}" {{ request('month') == $i ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                    @endfor
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Year</label>
                <input type="number" class="form-control" name="year" value="{{ request('year', date('Y')) }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Employee</label>
                <select name="employee_id" class="form-select">
                    <option value="">All Employees</option>
                    @foreach($employees as $employee)
                    <option value="{{ $employee->emp_id }}" {{ request('employee_id') == $employee->emp_id ? 'selected' : '' }}>{{ $employee->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">&nbsp;</label>
                <div>
                    <button type="submit" class="btn btn-primary w-100">
                         Filter
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"> Monthly Deductions/Allowances ({{ $deductionsAllowances->count() }} records)</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Month/Year</th>
                        <th>Deduction Type</th>
                        <th>Deduction Amount</th>
                        <th>Allowance Type</th>
                        <th>Allowance Amount</th>
                        <th>Net Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($deductionsAllowances as $item)
                    @php
                        $netAmount = $item->allowance_amount - $item->deduction_amount;
                    @endphp
                    <tr>
                        <td><strong>{{ $item->employee->name ?? 'N/A' }}</strong></td>
                        <td>{{ date('F', mktime(0, 0, 0, $item->month, 1)) }} {{ $item->year }}</td>
                        <td>{{ $item->deduction_type ?? 'N/A' }}</td>
                        <td>Rs.{{ number_format($item->deduction_amount, 2) }}</td>
                        <td>{{ $item->allowance_type ?? 'N/A' }}</td>
                        <td>Rs.{{ number_format($item->allowance_amount, 2) }}</td>
                        <td>
                            <span class="badge badge-{{ $netAmount >= 0 ? 'primary' : 'dark' }}">
                                Rs.{{ number_format($netAmount, 2) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">No records found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

