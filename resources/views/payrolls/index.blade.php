@extends('layouts.app')

@section('title', 'Payroll')
@section('page-title', 'Payroll Management')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="bi bi-cash-stack"></i> Payroll</h5>
        <a href="{{ route('payrolls.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-circle"></i> Add Payroll
        </a>
    </div>
    <div class="card-body">
        <form method="GET" class="mb-3">
            <div class="row g-2">
                <div class="col-md-3">
                    <input type="month" class="form-control" name="month" value="{{ request('month') }}" placeholder="Filter by Month">
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
                    <a href="{{ route('payrolls.index') }}" class="btn btn-secondary">Reset</a>
                </div>
            </div>
        </form>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Payroll ID</th>
                        <th>Employee</th>
                        <th>Month</th>
                        <th>Basic Salary</th>
                        <th>Overtime</th>
                        <th>Deductions</th>
                        <th>Net Salary</th>
                        <th>Status</th>
                        <th>Actions</th>
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
                        <td>${{ number_format($payroll->deductions, 2) }}</td>
                        <td><strong>${{ number_format($payroll->net_salary, 2) }}</strong></td>
                        <td><span class="badge bg-{{ $payroll->status === 'paid' ? 'success' : ($payroll->status === 'pending' ? 'warning' : 'danger') }}">{{ ucfirst($payroll->status) }}</span></td>
                        <td>
                            <a href="{{ route('payrolls.show', $payroll) }}" class="btn btn-sm btn-outline-info">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('payrolls.edit', $payroll) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <a href="{{ route('payrolls.payslip', $payroll) }}" class="btn btn-sm btn-outline-success" target="_blank">
                                <i class="bi bi-printer"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center">No payroll records found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $payrolls->links() }}
        </div>
    </div>
</div>
@endsection


