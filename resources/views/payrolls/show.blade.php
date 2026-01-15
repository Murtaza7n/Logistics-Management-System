@extends('layouts.app')

@section('title', 'Payroll Details')
@section('page-title', 'Payroll Details')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-cash-stack"></i> Payroll Information</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="40%">Payroll ID:</th>
                        <td>{{ $payroll->payroll_id }}</td>
                    </tr>
                    <tr>
                        <th>Employee:</th>
                        <td>{{ $payroll->employee->name }} (ID: {{ $payroll->employee->emp_id }})</td>
                    </tr>
                    <tr>
                        <th>Month:</th>
                        <td>{{ $payroll->month }}</td>
                    </tr>
                    <tr>
                        <th>Basic Salary:</th>
                        <td>${{ number_format($payroll->basic_salary, 2) }}</td>
                    </tr>
                    <tr>
                        <th>Overtime:</th>
                        <td>${{ number_format($payroll->overtime, 2) }}</td>
                    </tr>
                    <tr>
                        <th>Bonus:</th>
                        <td>${{ number_format($payroll->bonus, 2) }}</td>
                    </tr>
                    <tr>
                        <th>Deductions:</th>
                        <td>${{ number_format($payroll->deductions, 2) }}</td>
                    </tr>
                    <tr>
                        <th>Deduction Details:</th>
                        <td>{{ $payroll->deduction_details ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th><strong>Net Salary:</strong></th>
                        <td><strong>${{ number_format($payroll->net_salary, 2) }}</strong></td>
                    </tr>
                    <tr>
                        <th>Status:</th>
                        <td><span class="badge bg-{{ $payroll->status === 'paid' ? 'success' : ($payroll->status === 'pending' ? 'warning' : 'danger') }}">{{ ucfirst($payroll->status) }}</span></td>
                    </tr>
                    <tr>
                        <th>Payment Date:</th>
                        <td>{{ $payroll->payment_date?->format('M d, Y') ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Notes:</th>
                        <td>{{ $payroll->notes ?? 'N/A' }}</td>
                    </tr>
                </table>
                <div class="mt-3">
                    <a href="{{ route('payrolls.edit', $payroll) }}" class="btn btn-primary">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                    <a href="{{ route('payrolls.payslip', $payroll) }}" class="btn btn-success" target="_blank">
                        <i class="bi bi-printer"></i> Print Payslip
                    </a>
                    <a href="{{ route('payrolls.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Back
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


