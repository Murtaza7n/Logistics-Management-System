@extends('layouts.app')

@section('title', 'Employee Details')
@section('page-title', 'Employee Details')

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"> Employee Information</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="40%">Employee ID:</th>
                        <td>{{ $employee->emp_id }}</td>
                    </tr>
                    <tr>
                        <th>Name:</th>
                        <td>{{ $employee->name }}</td>
                    </tr>
                    <tr>
                        <th>Role:</th>
                        <td><span class="badge bg-info">{{ ucfirst($employee->role) }}</span></td>
                    </tr>
                    <tr>
                        <th>Contact:</th>
                        <td>{{ $employee->contact ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Email:</th>
                        <td>{{ $employee->email ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Address:</th>
                        <td>{{ $employee->address ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Bank Account:</th>
                        <td>{{ $employee->bank_account ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Bank Name:</th>
                        <td>{{ $employee->bank_name ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Hire Date:</th>
                        <td>{{ $employee->hire_date?->format('M d, Y') ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Status:</th>
                        <td><span class="badge bg-{{ $employee->status === 'active' ? 'success' : 'secondary' }}">{{ ucfirst($employee->status) }}</span></td>
                    </tr>
                </table>
                <div class="mt-3">
                    <a href="{{ route('employees.edit', $employee) }}" class="btn btn-primary">
                         Edit
                    </a>
                    <a href="{{ route('employees.index') }}" class="btn btn-secondary">
                         Back
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"> Payroll History</h5>
            </div>
            <div class="card-body">
                @if($employee->payrolls->count() > 0)
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Month</th>
                                <th>Net Salary</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($employee->payrolls->take(10) as $payroll)
                            <tr>
                                <td>{{ $payroll->month }}</td>
                                <td>Rs.{{ number_format($payroll->net_salary, 2) }}</td>
                                <td><span class="badge bg-{{ $payroll->status === 'paid' ? 'success' : 'warning' }}">{{ ucfirst($payroll->status) }}</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p class="text-muted">No payroll records found.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection


