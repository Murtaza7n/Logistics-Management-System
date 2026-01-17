@extends('layouts.app')

@section('title', 'Employee\'s Leaves Status')
@section('page-title', 'Employee\'s Leaves Status')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">
        
        Employee's Leaves Status
    </h1>
    <p class="page-subtitle">Current leave status for all employees</p>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"> Filters</h5>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('reports.employees-leaves-status') }}" class="row g-3">
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
        <h5 class="mb-0"> Employees Leaves Status ({{ $employeeLeaves->count() }} employees)</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Leave Type</th>
                        <th>Total</th>
                        <th>Used</th>
                        <th>Remaining</th>
                        <th>Year</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($employeeLeaves as $employeeData)
                    @foreach($employeeData['leaves'] as $leave)
                    <tr>
                        <td><strong>{{ $employeeData['employee']->name ?? 'N/A' }}</strong></td>
                        <td>{{ $leave->leave_type }}</td>
                        <td>{{ $leave->total_leaves }}</td>
                        <td>{{ $leave->used_leaves }}</td>
                        <td>
                            <span class="badge badge-{{ $leave->remaining_leaves > 0 ? 'primary' : 'dark' }}">
                                {{ $leave->remaining_leaves }}
                            </span>
                        </td>
                        <td>{{ $leave->year }}</td>
                    </tr>
                    @endforeach
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">No records found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

