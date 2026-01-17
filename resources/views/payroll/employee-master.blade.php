@extends('layouts.app')

@section('title', 'Employee Master File')
@section('page-title', 'Employee Master File')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">
        
        Employee Master File
    </h1>
    <p class="page-subtitle">Complete employee information and management</p>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"> All Employees ({{ $employees->count() }} records)</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Employee ID</th>
                        <th>Name</th>
                        <th>Role</th>
                        <th>Contact</th>
                        <th>Email</th>
                        <th>Hire Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($employees as $employee)
                    <tr>
                        <td><strong>{{ $employee->emp_id }}</strong></td>
                        <td>{{ $employee->name }}</td>
                        <td>{{ ucfirst($employee->role) }}</td>
                        <td>{{ $employee->contact ?? 'N/A' }}</td>
                        <td>{{ $employee->email ?? 'N/A' }}</td>
                        <td>{{ $employee->hire_date ? $employee->hire_date->format('Y-m-d') : 'N/A' }}</td>
                        <td>
                            <span class="badge badge-{{ $employee->status === 'active' ? 'primary' : 'secondary' }}">
                                {{ ucfirst($employee->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('employees.show', $employee) }}" class="btn btn-sm btn-outline-primary">
                                
                            </a>
                            <a href="{{ route('employees.edit', $employee) }}" class="btn btn-sm btn-outline-secondary">
                                
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">No employees found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

