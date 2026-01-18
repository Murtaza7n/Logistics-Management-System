@extends('layouts.app')

@section('title', 'Employee\'s Authorized Leaves Detail')
@section('page-title', 'Employee\'s Authorized Leaves Detail')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">
        
        Employee's Authorized Leaves Detail
    </h1>
    <p class="page-subtitle">Detailed authorized leaves information for employees</p>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"> Filters</h5>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('reports.employees-authorized-leaves-detail') }}" class="row g-3">
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
                <label class="form-label">Leave Type</label>
                <select name="leave_type" class="form-select">
                    <option value="">All Types</option>
                    <option value="Annual" {{ request('leave_type') == 'Annual' ? 'selected' : '' }}>Annual</option>
                    <option value="Sick" {{ request('leave_type') == 'Sick' ? 'selected' : '' }}>Sick</option>
                    <option value="Casual" {{ request('leave_type') == 'Casual' ? 'selected' : '' }}>Casual</option>
                    <option value="Unpaid" {{ request('leave_type') == 'Unpaid' ? 'selected' : '' }}>Unpaid</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Year</label>
                <input type="number" class="form-control" name="year" value="{{ request('year', date('Y')) }}">
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
        <h5 class="mb-0"> Authorized Leaves ({{ $leaves->count() }} records)</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Leave Type</th>
                        <th>Year</th>
                        <th>Total Leaves</th>
                        <th>Used Leaves</th>
                        <th>Remaining Leaves</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($leaves as $leave)
                    <tr>
                        <td><strong>{{ $leave->employee->name ?? 'N/A' }}</strong></td>
                        <td>{{ $leave->leave_type }}</td>
                        <td>{{ $leave->year }}</td>
                        <td>{{ $leave->total_leaves }}</td>
                        <td>{{ $leave->used_leaves }}</td>
                        <td>
                            <span class="badge badge-{{ $leave->remaining_leaves > 0 ? 'primary' : 'dark' }}">
                                {{ $leave->remaining_leaves }}
                            </span>
                        </td>
                        <td>{{ $leave->notes ?? 'N/A' }}</td>
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

