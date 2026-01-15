@extends('layouts.app')

@section('title', 'Payroll Reports')
@section('page-title', 'Payroll Reports')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="bi bi-person-badge"></i> Payroll Reports</h5>
    </div>
    <div class="card-body">
        <form method="GET" class="mb-3">
            <div class="row g-2">
                <div class="col-md-3">
                    <input type="month" class="form-control" name="month" value="{{ request('month') }}" placeholder="Month">
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="emp_id">
                        <option value="">All Employees</option>
                        @foreach($employees as $emp)
                        <option value="{{ $emp->emp_id }}" {{ request('emp_id') == $emp->emp_id ? 'selected' : '' }}>{{ $emp->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="{{ route('reports.payroll') }}" class="btn btn-secondary">Reset</a>
                </div>
            </div>
        </form>
        
        <div class="row mb-3">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h6>Total Employees</h6>
                        <h3>{{ $summary['total_employees'] }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h6>Total Basic Salary</h6>
                        <h3>${{ number_format($summary['total_basic_salary'], 2) }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <h6>Total Overtime</h6>
                        <h3>${{ number_format($summary['total_overtime'], 2) }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <h6>Net Salary</h6>
                        <h3>${{ number_format($summary['total_net_salary'], 2) }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('reports.payroll', array_merge(request()->all(), ['export' => 'pdf'])) }}" class="btn btn-danger">
                <i class="bi bi-file-pdf"></i> Export PDF
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Payroll ID</th>
                        <th>Employee</th>
                        <th>Month</th>
                        <th>Basic Salary</th>
                        <th>Overtime</th>
                        <th>Bonus</th>
                        <th>Deductions</th>
                        <th>Net Salary</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payrolls as $payroll)
                    <tr>
                        <td>{{ $payroll->payroll_id }}</td>
                        <td>{{ $payroll->employee->name }}</td>
                        <td>{{ $payroll->month }}</td>
                        <td>${{ number_format($payroll->basic_salary, 2) }}</td>
                        <td>${{ number_format($payroll->overtime, 2) }}</td>
                        <td>${{ number_format($payroll->bonus, 2) }}</td>
                        <td>${{ number_format($payroll->deductions, 2) }}</td>
                        <td><strong>${{ number_format($payroll->net_salary, 2) }}</strong></td>
                        <td><span class="badge bg-{{ $payroll->status === 'paid' ? 'success' : 'warning' }}">{{ ucfirst($payroll->status) }}</span></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center">No payroll records found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection


