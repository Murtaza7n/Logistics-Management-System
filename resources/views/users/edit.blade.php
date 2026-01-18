@extends('layouts.app')

@section('title', 'Edit User')
@section('page-title', 'SYSTEM USERS')

@section('content')
<style>
    .user-form-container {
        display: flex;
        gap: 1.5rem;
        margin-top: 1rem;
    }
    
    .user-details-section {
        flex: 1;
        min-width: 400px;
    }
    
    .menu-rights-section {
        flex: 1;
        min-width: 500px;
    }
    
    .menu-rights-list {
        max-height: 500px;
        overflow-y: auto;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 1rem;
        background: #f8f9fa;
    }
    
    .menu-item {
        display: flex;
        align-items: center;
        padding: 0.75rem;
        margin-bottom: 0.5rem;
        background: white;
        border-radius: 6px;
        border-left: 3px solid #FF6B35;
    }
    
    .menu-item input[type="checkbox"] {
        margin-right: 0.75rem;
        width: 18px;
        height: 18px;
        cursor: pointer;
    }
    
    .menu-item label {
        margin: 0;
        cursor: pointer;
        flex: 1;
        color: #dc3545;
        font-weight: 500;
    }
    
    .menu-item .arrow-icon {
        color: #28a745;
        margin-right: 0.5rem;
    }
    
    .tab-content {
        display: none;
    }
    
    .tab-content.active {
        display: block;
    }
    
    .nav-tabs .nav-link {
        color: #495057;
        border: 1px solid #dee2e6;
        border-bottom: none;
    }
    
    .nav-tabs .nav-link.active {
        background-color: #fff;
        color: #FF6B35;
        border-color: #dee2e6 #dee2e6 #fff;
        font-weight: 600;
    }
    
    @media (max-width: 992px) {
        .user-form-container {
            flex-direction: column;
        }
    }
</style>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Edit User: {{ $user->name }}</h5>
        <div>
            <button type="button" class="btn btn-sm btn-primary" onclick="resetForm()">
                <i class="bi bi-plus-circle"></i> New
            </button>
            <button type="submit" form="userForm" class="btn btn-sm btn-primary">
                <i class="bi bi-save"></i> Save
            </button>
            <a href="{{ route('users.index') }}" class="btn btn-sm btn-secondary">
                <i class="bi bi-x"></i> Cancel
            </a>
        </div>
    </div>
    <div class="card-body">
        <!-- Tabs -->
        <ul class="nav nav-tabs mb-3" id="userTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="menu-rights-tab" data-bs-toggle="tab" data-bs-target="#menu-rights" type="button" role="tab">
                    Users & Menu Rights
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="user-cities-tab" data-bs-toggle="tab" data-bs-target="#user-cities" type="button" role="tab">
                    User Cities
                </button>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content" id="userTabsContent">
            <!-- Users & Menu Rights Tab -->
            <div class="tab-pane fade show active" id="menu-rights" role="tabpanel">
                <form id="userForm" action="{{ route('users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')
                    <div class="user-form-container">
                        <!-- Left: User Details -->
                        <div class="user-details-section">
                            <h6 class="mb-3">User Details</h6>
                            <div class="mb-3">
                                <label for="role" class="form-label">User Type <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
                                        <option value="">Select User Type</option>
                                        <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>(1) Administrator</option>
                                        <option value="staff" {{ old('role', $user->role) === 'staff' ? 'selected' : '' }}>(3) Staff</option>
                                        <option value="driver" {{ old('role', $user->role) === 'driver' ? 'selected' : '' }}>(2) Guest</option>
                                    </select>
                                    <span class="input-group-text" style="cursor: pointer;" onclick="document.getElementById('role').focus()">
                                        <i class="bi bi-search"></i>
                                    </span>
                                </div>
                                @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                    <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">User Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                </div>
                            <div class="mb-3">
                    <label for="password" class="form-label">Password (leave blank to keep current)</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                </div>
                            <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                </div>
                            <div class="mb-3">
                                <label for="contact" class="form-label">Contact</label>
                                <input type="text" class="form-control @error('contact') is-invalid @enderror" id="contact" name="contact" value="{{ old('contact', $user->contact ?? '') }}">
                                @error('contact')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Right: Dynamic Permissions -->
                        <div class="menu-rights-section">
                            <h6 class="mb-3">Menu Permissions (Dynamic)</h6>
                            <p class="text-muted small mb-3">
                                <i class="bi bi-info-circle"></i> Select which menu items and actions this user can access.
                            </p>
                            @include('users.partials.dynamic-permissions-tree', ['user' => $user])
                        </div>
                    </div>
                </form>
            </div>

            <!-- User Cities Tab -->
            <div class="tab-pane fade" id="user-cities" role="tabpanel">
                <div class="user-cities-section">
                    <h6 class="mb-3">Assign Cities to User</h6>
                    <div class="row">
                <div class="col-md-6 mb-3">
                            <label for="primary_city_id" class="form-label">Primary City</label>
                            <select class="form-select" id="primary_city_id" name="primary_city_id" form="userForm">
                                <option value="">Select Primary City</option>
                                @foreach($cities as $city)
                                <option value="{{ $city->city_id }}" {{ old('primary_city_id', $user->primary_city_id) == $city->city_id ? 'selected' : '' }}>
                                    {{ $city->name }} @if($city->code)({{ $city->code }})@endif
                                </option>
                                @endforeach
                    </select>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">City Permissions</h6>
                        </div>
                        <div class="card-body">
                            <div id="cityPermissionsContainer">
                                @php
                                    $permissionIndex = 0;
                                @endphp
                                @foreach($cities as $city)
                                @php
                                    $existingPermission = $userPermissions->get($city->city_id);
                                    $isChecked = $existingPermission ? true : false;
                                @endphp
                                <div class="city-permission-item mb-3 p-3 border rounded">
                                    <div class="form-check mb-2">
                                        <input type="checkbox" 
                                               class="form-check-input city-checkbox" 
                                               id="city_{{ $city->city_id }}" 
                                               name="city_permissions[{{ $permissionIndex }}][city_id]" 
                                               value="{{ $city->city_id }}"
                                               form="userForm"
                                               {{ $isChecked ? 'checked' : '' }}
                                               onchange="toggleCityPermissions(this, {{ $city->city_id }})">
                                        <label class="form-check-label fw-bold" for="city_{{ $city->city_id }}">
                                            {{ $city->name }} @if($city->code)({{ $city->code }})@endif
                                        </label>
                                    </div>
                                    <div class="city-permission-details ms-4" id="city_details_{{ $city->city_id }}" style="display: {{ $isChecked ? 'block' : 'none' }};">
                                        <div class="row g-2">
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" name="city_permissions[{{ $permissionIndex }}][can_view]" value="1" form="userForm" {{ $existingPermission && $existingPermission->can_view ? 'checked' : '' }}>
                                                    <label class="form-check-label">View</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" name="city_permissions[{{ $permissionIndex }}][can_create]" value="1" form="userForm" {{ $existingPermission && $existingPermission->can_create ? 'checked' : '' }}>
                                                    <label class="form-check-label">Create</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" name="city_permissions[{{ $permissionIndex }}][can_edit]" value="1" form="userForm" {{ $existingPermission && $existingPermission->can_edit ? 'checked' : '' }}>
                                                    <label class="form-check-label">Edit</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" name="city_permissions[{{ $permissionIndex }}][can_delete]" value="1" form="userForm" {{ $existingPermission && $existingPermission->can_delete ? 'checked' : '' }}>
                                                    <label class="form-check-label">Delete</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if($isChecked) @php $permissionIndex++; @endphp @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
    </div>
</div>

<script>
    function resetForm() {
        window.location.href = '{{ route("users.create") }}';
    }

    function selectAllMenus() {
        document.querySelectorAll('.menu-rights-list input[type="checkbox"]').forEach(cb => {
            cb.checked = true;
        });
    }

    function deselectAllMenus() {
        document.querySelectorAll('.menu-rights-list input[type="checkbox"]').forEach(cb => {
            cb.checked = false;
        });
    }

    function toggleCityPermissions(checkbox, cityId) {
        const detailsDiv = document.getElementById('city_details_' + cityId);
        if (checkbox.checked) {
            detailsDiv.style.display = 'block';
        } else {
            detailsDiv.style.display = 'none';
        }
    }

    // Auto-check menu permissions based on role
    document.getElementById('role').addEventListener('change', function() {
        const role = this.value;
        if (role === 'admin') {
            // Admin gets all permissions
            selectAllMenus();
        } else if (role === 'staff') {
            // Staff gets logistics and reports
            deselectAllMenus();
            document.getElementById('menu_logistics').checked = true;
            document.getElementById('menu_logistics_reports').checked = true;
            document.getElementById('menu_finance').checked = true;
            document.getElementById('menu_finance_reports').checked = true;
        } else if (role === 'driver') {
            // Driver gets minimal permissions
            deselectAllMenus();
        }
    });
</script>
@endsection
