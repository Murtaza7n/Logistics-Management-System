@extends('layouts.app')

@section('title', 'View User')
@section('page-title', 'SYSTEM USERS - View User')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">User Details: {{ $user->name }}</h5>
        <div>
            <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-primary">
                <i class="bi bi-pencil"></i> Edit
            </a>
            <a href="{{ route('users.index') }}" class="btn btn-sm btn-secondary">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr>
                        <th style="width: 40%;">Name:</th>
                        <td>{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <th>User Name:</th>
                        <td><code>{{ $user->email }}</code></td>
                    </tr>
                    <tr>
                        <th>Email:</th>
                        <td>{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <th>Contact:</th>
                        <td>{{ $user->contact ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Role:</th>
                        <td>
                            <span class="badge bg-{{ $user->role === 'admin' ? 'danger' : ($user->role === 'staff' ? 'primary' : 'info') }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Primary City:</th>
                        <td>{{ $user->primaryCity->name ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Created At:</th>
                        <td>{{ $user->created_at->format('M d, Y h:i A') }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <h6>Menu Permissions</h6>
                <div class="list-group">
                    @php
                        $menuPermissions = $user->menu_permissions ?? [];
                        $menus = [
                            'logistics' => 'Logistics',
                            'logistics_reports' => 'Logistics Reports',
                            'finance' => 'Finance',
                            'finance_reports' => 'Finance Reports',
                            'payroll' => 'Payroll',
                            'payroll_reports' => 'Payroll Reports',
                            'system' => 'System',
                        ];
                    @endphp
                    @foreach($menus as $key => $label)
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <span>{{ $label }}</span>
                        @if(isset($menuPermissions[$key]) && $menuPermissions[$key])
                            <span class="badge bg-success">Allowed</span>
                        @else
                            <span class="badge bg-danger">Denied</span>
                        @endif
                    </div>
                    @endforeach
                </div>
                
                <h6 class="mt-4">City Permissions</h6>
                @if($userPermissions->count() > 0)
                <div class="table-responsive">
                    <table class="table table-sm table-bordered">
                        <thead>
                            <tr>
                                <th>City</th>
                                <th>View</th>
                                <th>Create</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($userPermissions as $permission)
                            <tr>
                                <td>{{ $permission->city->name }}</td>
                                <td class="text-center">
                                    @if($permission->can_view)
                                        <i class="bi bi-check-circle-fill text-success"></i>
                                    @else
                                        <i class="bi bi-x-circle-fill text-danger"></i>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($permission->can_create)
                                        <i class="bi bi-check-circle-fill text-success"></i>
                                    @else
                                        <i class="bi bi-x-circle-fill text-danger"></i>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($permission->can_edit)
                                        <i class="bi bi-check-circle-fill text-success"></i>
                                    @else
                                        <i class="bi bi-x-circle-fill text-danger"></i>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($permission->can_delete)
                                        <i class="bi bi-check-circle-fill text-success"></i>
                                    @else
                                        <i class="bi bi-x-circle-fill text-danger"></i>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p class="text-muted">No city permissions assigned</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
