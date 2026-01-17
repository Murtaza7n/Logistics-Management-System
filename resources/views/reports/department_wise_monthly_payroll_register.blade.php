@extends('layouts.app')

@section('title', 'Department-wise Monthly Payroll Register')
@section('page-title', 'Department-wise Monthly Payroll Register')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">
        
        Department-wise Monthly Payroll Register
    </h1>
    <p class="page-subtitle">Monthly payroll breakdown by department</p>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"> Filters</h5>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('reports.department-wise-monthly-payroll-register') }}" class="row g-3">
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
                <label class="form-label">Department</label>
                <select name="department_id" class="form-select">
                    <option value="">All Departments</option>
                    @foreach($departments as $dept)
                    <option value="{{ $dept->id }}" {{ request('department_id') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
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

@foreach($departmentWise as $deptData)
<div class="card mt-3">
    <div class="card-header">
        <h5 class="mb-0">
             
            {{ $deptData['department']->name ?? 'No Department' }}
            <span class="badge badge-secondary ms-2">{{ $deptData['total_employees'] }} employees</span>
        </h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Basic Salary</th>
                        <th>Overtime</th>
                        <th>Bonus</th>
                        <th>Deductions</th>
                        <th>Net Salary</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($deptData['payrolls'] as $payroll)
                    <tr>
                        <td><strong>{{ $payroll->employee->name ?? 'N/A' }}</strong></td>
                        <td>Rs.{{ number_format($payroll->basic_salary, 2) }}</td>
                        <td>Rs.{{ number_format($payroll->overtime, 2) }}</td>
                        <td>Rs.{{ number_format($payroll->bonus, 2) }}</td>
                        <td>Rs.{{ number_format($payroll->deductions, 2) }}</td>
                        <td><strong>Rs.{{ number_format($payroll->net_salary, 2) }}</strong></td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="table-dark">
                        <th>Department Total</th>
                        <th>Rs.{{ number_format($deptData['payrolls']->sum('basic_salary'), 2) }}</th>
                        <th>Rs.{{ number_format($deptData['payrolls']->sum('overtime'), 2) }}</th>
                        <th>Rs.{{ number_format($deptData['payrolls']->sum('bonus'), 2) }}</th>
                        <th>Rs.{{ number_format($deptData['payrolls']->sum('deductions'), 2) }}</th>
                        <th><strong>Rs.{{ number_format($deptData['total_net_salary'], 2) }}</strong></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endforeach

@if($departmentWise->isEmpty())
<div class="card mt-3">
    <div class="card-body">
        <div class="alert alert-info">
             No payroll records found for the selected criteria.
        </div>
    </div>
</div>
@endif
@endsection

