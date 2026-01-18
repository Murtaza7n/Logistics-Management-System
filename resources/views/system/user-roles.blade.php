@extends('layouts.app')

@section('title', 'User Roles')
@section('page-title', 'User Roles Management')

@section('content')
<div class="page-header">
    <h1 class="page-title">
        <i class="bi bi-shield-check"></i> User Roles Management
    </h1>
    <p class="page-subtitle">Manage user roles and permissions</p>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Available Roles</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Role</th>
                        <th>Description</th>
                        <th>Users Count</th>
                        <th>Permissions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><span class="badge bg-primary">Admin</span></td>
                        <td>Full system access with all permissions</td>
                        <td>{{ \App\Models\User::where('role', 'admin')->count() }}</td>
                        <td>All modules, All cities</td>
                    </tr>
                    <tr>
                        <td><span class="badge bg-secondary">Staff</span></td>
                        <td>Standard user with limited permissions</td>
                        <td>{{ \App\Models\User::where('role', 'staff')->count() }}</td>
                        <td>Assigned modules, Assigned cities</td>
                    </tr>
                    <tr>
                        <td><span class="badge bg-info">Driver</span></td>
                        <td>Driver with delivery-related permissions</td>
                        <td>{{ \App\Models\User::where('role', 'driver')->count() }}</td>
                        <td>Delivery tracking, Assigned vehicles</td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            <h6 class="mb-3">Role Permissions Matrix</h6>
            <p class="text-muted small mb-3">
                <i class="bi bi-info-circle"></i> Click the edit button next to each role column to modify permissions for that role.
            </p>
            
            <!-- Edit Forms for each role -->
            @foreach(['admin', 'staff', 'driver'] as $role)
            <form id="permissionsForm{{ ucfirst($role) }}" method="POST" action="{{ route('system.update-role-permissions') }}" style="display: none;" class="role-edit-form">
                @csrf
                <input type="hidden" name="role" value="{{ $role }}">
                <div class="alert alert-info mb-3">
                    <i class="bi bi-info-circle"></i> Editing permissions for <strong>{{ ucfirst($role) }}</strong> role
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-sm">
                        <thead>
                            <tr>
                                <th>Module</th>
                                <th>Permission</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($modules as $moduleKey => $moduleName)
                            <tr>
                                <td><strong>{{ $moduleName }}</strong></td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input type="hidden" name="permissions[{{ $moduleKey }}]" value="0">
                                        <input type="checkbox" 
                                               name="permissions[{{ $moduleKey }}]" 
                                               value="1" 
                                               class="form-check-input"
                                               id="perm_{{ $role }}_{{ $moduleKey }}"
                                               {{ $rolePermissions[$role]->hasModulePermission($moduleKey) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="perm_{{ $role }}_{{ $moduleKey }}">
                                            {{ $rolePermissions[$role]->hasModulePermission($moduleKey) ? 'Allowed' : 'Denied' }}
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Save {{ ucfirst($role) }} Permissions
                    </button>
                    <button type="button" class="btn btn-secondary" onclick="cancelEditMode('{{ $role }}')">
                        <i class="bi bi-x"></i> Cancel
                    </button>
                </div>
            </form>
            @endforeach
            
            <div id="viewModeTable" class="table-responsive">
                <table class="table table-bordered table-sm">
                    <thead>
                        <tr>
                            <th>Module</th>
                            <th>
                                Admin
                                <button type="button" class="btn btn-sm btn-outline-primary ms-2" onclick="editRole('admin')" title="Edit Admin Permissions">
                                    <i class="bi bi-pencil"></i>
                                </button>
                            </th>
                            <th>
                                Staff
                                <button type="button" class="btn btn-sm btn-outline-secondary ms-2" onclick="editRole('staff')" title="Edit Staff Permissions">
                                    <i class="bi bi-pencil"></i>
                                </button>
                            </th>
                            <th>
                                Driver
                                <button type="button" class="btn btn-sm btn-outline-info ms-2" onclick="editRole('driver')" title="Edit Driver Permissions">
                                    <i class="bi bi-pencil"></i>
                                </button>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($modules as $moduleKey => $moduleName)
                        <tr>
                            <td><strong>{{ $moduleName }}</strong></td>
                            <td>
                                @if($rolePermissions['admin']->hasModulePermission($moduleKey))
                                    <i class="bi bi-check-circle-fill text-success"></i>
                                @else
                                    <i class="bi bi-x-circle-fill text-danger"></i>
                                @endif
                            </td>
                            <td>
                                @if($rolePermissions['staff']->hasModulePermission($moduleKey))
                                    <i class="bi bi-check-circle-fill text-success"></i>
                                @else
                                    <i class="bi bi-x-circle-fill text-danger"></i>
                                @endif
                            </td>
                            <td>
                                @if($rolePermissions['driver']->hasModulePermission($moduleKey))
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
        </div>
    </div>
</div>

<script>
    function editRole(role) {
        // Hide view table
        document.getElementById('viewModeTable').style.display = 'none';
        
        // Hide all edit forms
        document.querySelectorAll('.role-edit-form').forEach(form => {
            form.style.display = 'none';
        });
        
        // Show selected role's edit form
        document.getElementById('permissionsForm' + role.charAt(0).toUpperCase() + role.slice(1)).style.display = 'block';
        
        // Scroll to form
        document.getElementById('permissionsForm' + role.charAt(0).toUpperCase() + role.slice(1)).scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    function cancelEditMode(role) {
        // Hide edit form
        document.getElementById('permissionsForm' + role.charAt(0).toUpperCase() + role.slice(1)).style.display = 'none';
        
        // Show view table
        document.getElementById('viewModeTable').style.display = 'block';
        
        // Scroll to table
        document.getElementById('viewModeTable').scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
</script>

<style>
    .form-check-input {
        cursor: pointer;
    }
    
    .table th {
        background-color: #f8f9fa;
        font-weight: 600;
    }
</style>
@endsection
