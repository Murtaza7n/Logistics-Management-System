@extends('layouts.app')

@section('title', 'Edit Employee')
@section('page-title', 'Edit Employee')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="bi bi-pencil"></i> Edit Employee</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('employees.update', $employee) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $employee->name) }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="role" class="form-label">Role <span class="text-danger">*</span></label>
                    <select class="form-select" id="role" name="role" required>
                        <option value="admin" {{ old('role', $employee->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="staff" {{ old('role', $employee->role) === 'staff' ? 'selected' : '' }}>Staff</option>
                        <option value="driver" {{ old('role', $employee->role) === 'driver' ? 'selected' : '' }}>Driver</option>
                        <option value="manager" {{ old('role', $employee->role) === 'manager' ? 'selected' : '' }}>Manager</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="contact" class="form-label">Contact</label>
                    <input type="text" class="form-control" id="contact" name="contact" value="{{ old('contact', $employee->contact) }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $employee->email) }}">
                </div>
                <div class="col-md-12 mb-3">
                    <label for="address" class="form-label">Address</label>
                    <textarea class="form-control" id="address" name="address" rows="2">{{ old('address', $employee->address) }}</textarea>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="bank_account" class="form-label">Bank Account</label>
                    <input type="text" class="form-control" id="bank_account" name="bank_account" value="{{ old('bank_account', $employee->bank_account) }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="bank_name" class="form-label">Bank Name</label>
                    <input type="text" class="form-control" id="bank_name" name="bank_name" value="{{ old('bank_name', $employee->bank_name) }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="hire_date" class="form-label">Hire Date</label>
                    <input type="date" class="form-control" id="hire_date" name="hire_date" value="{{ old('hire_date', $employee->hire_date?->format('Y-m-d')) }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                    <select class="form-select" id="status" name="status" required>
                        <option value="active" {{ old('status', $employee->status) === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $employee->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle"></i> Update Employee
                </button>
                <a href="{{ route('employees.index') }}" class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection


