@extends('layouts.app')

@section('title', 'Employees')
@section('page-title', 'Employees Management')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="bi bi-person-badge"></i> Employees</h5>
        <a href="{{ route('employees.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-circle"></i> Add Employee
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Emp ID</th>
                        <th>Name</th>
                        <th>Role</th>
                        <th>Contact</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($employees as $employee)
                    <tr>
                        <td>{{ $employee->emp_id }}</td>
                        <td>{{ $employee->name }}</td>
                        <td><span class="badge bg-info">{{ ucfirst($employee->role) }}</span></td>
                        <td>{{ $employee->contact ?? 'N/A' }}</td>
                        <td><span class="badge bg-{{ $employee->status === 'active' ? 'success' : 'secondary' }}">{{ ucfirst($employee->status) }}</span></td>
                        <td>
                            <a href="{{ route('employees.show', $employee) }}" class="btn btn-sm btn-outline-info">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('employees.edit', $employee) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('employees.destroy', $employee) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">No employees found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $employees->links() }}
        </div>
    </div>
</div>
@endsection


