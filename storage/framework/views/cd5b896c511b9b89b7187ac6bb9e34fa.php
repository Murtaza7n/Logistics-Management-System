<?php $__env->startSection('title', 'Create User'); ?>
<?php $__env->startSection('page-title', 'SYSTEM USERS'); ?>

<?php $__env->startSection('content'); ?>
<style>
    .user-form-container {
        display: flex;
        gap: 1.5rem;
        margin-top: 1rem;
        min-height: 400px;
    }
    
    .user-details-section {
        flex: 1;
        min-width: 400px;
        display: block;
    }
    
    .menu-rights-section {
        flex: 1;
        min-width: 500px;
        display: block;
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
        padding-top: 1rem;
    }
    
    .tab-pane {
        display: none;
    }
    
    .tab-pane.show,
    .tab-pane.active {
        display: block !important;
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
        <h5 class="mb-0">Create New User</h5>
        <div>
            <button type="button" class="btn btn-sm btn-primary" onclick="resetForm()">
                <i class="bi bi-plus-circle"></i> New
            </button>
            <button type="submit" form="userForm" class="btn btn-sm btn-secondary" id="saveBtn" disabled>
                <i class="bi bi-save"></i> Save
            </button>
            <a href="<?php echo e(route('users.index')); ?>" class="btn btn-sm btn-secondary">
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
            <div class="tab-pane fade show active" id="menu-rights" role="tabpanel" aria-labelledby="menu-rights-tab">
                <form id="userForm" action="<?php echo e(route('users.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>
                    <div class="user-form-container">
                        <!-- Left: User Details -->
                        <div class="user-details-section">
                            <h6 class="mb-3">User Details</h6>
                            <div class="mb-3">
                                <label for="role" class="form-label">User Type <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <select class="form-select <?php $__errorArgs = ['role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="role" name="role" required>
                                        <option value="">Select User Type</option>
                                        <option value="admin" <?php echo e(old('role') === 'admin' ? 'selected' : ''); ?>>(1) Administrator</option>
                                        <option value="staff" <?php echo e(old('role') === 'staff' ? 'selected' : ''); ?>>(3) Staff</option>
                                        <option value="driver" <?php echo e(old('role') === 'driver' ? 'selected' : ''); ?>>(2) Guest</option>
                                    </select>
                                    <span class="input-group-text" style="cursor: pointer;" onclick="document.getElementById('role').focus()">
                                        <i class="bi bi-search"></i>
                                    </span>
                                </div>
                                <?php $__errorArgs = ['role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="mb-3">
                    <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="name" name="name" value="<?php echo e(old('name')); ?>" required>
                                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">User Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="email" name="email" value="<?php echo e(old('email')); ?>" required>
                                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                            <div class="mb-3">
                    <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="password" name="password" required>
                                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                            <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                </div>
                            <div class="mb-3">
                                <label for="contact" class="form-label">Contact</label>
                                <input type="text" class="form-control <?php $__errorArgs = ['contact'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="contact" name="contact" value="<?php echo e(old('contact')); ?>">
                                <?php $__errorArgs = ['contact'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <!-- Right: Dynamic Permissions -->
                        <div class="menu-rights-section">
                            <h6 class="mb-3">Menu Permissions (Dynamic)</h6>
                            <p class="text-muted small mb-3">
                                <i class="bi bi-info-circle"></i> Select which menu items and actions this user can access.
                            </p>
                            <?php
                                $dummyUser = new \App\Models\User(); // Dummy user for create form
                                $dummyUser->dynamic_permissions = old('dynamic_permissions', []);
                            ?>
                            <?php echo $__env->make('users.partials.dynamic-permissions-tree', ['user' => $dummyUser], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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
                                <?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($city->city_id); ?>" <?php echo e(old('primary_city_id') == $city->city_id ? 'selected' : ''); ?>>
                                    <?php echo e($city->name); ?> <?php if($city->code): ?>(<?php echo e($city->code); ?>)<?php endif; ?>
                                </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">City Permissions</h6>
                        </div>
                        <div class="card-body">
                            <div id="cityPermissionsContainer">
                                <?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="city-permission-item mb-3 p-3 border rounded">
                                    <div class="form-check mb-2">
                                        <input type="checkbox" 
                                               class="form-check-input city-checkbox" 
                                               id="city_<?php echo e($city->city_id); ?>" 
                                               name="city_permissions[<?php echo e($index); ?>][city_id]" 
                                               value="<?php echo e($city->city_id); ?>"
                                               form="userForm"
                                               onchange="toggleCityPermissions(this, <?php echo e($city->city_id); ?>)">
                                        <label class="form-check-label fw-bold" for="city_<?php echo e($city->city_id); ?>">
                                            <?php echo e($city->name); ?> <?php if($city->code): ?>(<?php echo e($city->code); ?>)<?php endif; ?>
                                        </label>
                                    </div>
                                    <div class="city-permission-details ms-4" id="city_details_<?php echo e($city->city_id); ?>" style="display: none;">
                                        <div class="row g-2">
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" name="city_permissions[<?php echo e($index); ?>][can_view]" value="1" form="userForm" checked>
                                                    <label class="form-check-label">View</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" name="city_permissions[<?php echo e($index); ?>][can_create]" value="1" form="userForm">
                                                    <label class="form-check-label">Create</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" name="city_permissions[<?php echo e($index); ?>][can_edit]" value="1" form="userForm">
                                                    <label class="form-check-label">Edit</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" name="city_permissions[<?php echo e($index); ?>][can_delete]" value="1" form="userForm">
                                                    <label class="form-check-label">Delete</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
    </div>
</div>

<script>
    // Enable save button when form is filled
    document.getElementById('userForm').addEventListener('input', function() {
        const name = document.getElementById('name').value;
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        const role = document.getElementById('role').value;
        
        if (name && email && password && role) {
            document.getElementById('saveBtn').disabled = false;
            document.getElementById('saveBtn').classList.remove('btn-secondary');
            document.getElementById('saveBtn').classList.add('btn-primary');
        } else {
            document.getElementById('saveBtn').disabled = true;
            document.getElementById('saveBtn').classList.remove('btn-primary');
            document.getElementById('saveBtn').classList.add('btn-secondary');
        }
    });

    function resetForm() {
        // Reset the form
        document.getElementById('userForm').reset();
        
        // Reset Save button state
        document.getElementById('saveBtn').disabled = true;
        document.getElementById('saveBtn').classList.remove('btn-primary');
        document.getElementById('saveBtn').classList.add('btn-secondary');
        
        // Reset all checkboxes in dynamic permissions tree
        document.querySelectorAll('.permission-tree input[type="checkbox"]').forEach(cb => {
            cb.checked = false;
        });
        
        // Reset all menu permission checkboxes (old style, if any)
        document.querySelectorAll('.menu-rights-list input[type="checkbox"]').forEach(cb => {
            cb.checked = false;
        });
        
        // Reset city permissions
        document.querySelectorAll('.city-checkbox').forEach(cb => {
            cb.checked = false;
            const cityId = cb.value;
            const detailsDiv = document.getElementById('city_details_' + cityId);
            if (detailsDiv) {
                detailsDiv.style.display = 'none';
            }
        });
        
        // Reset primary city dropdown
        const primaryCitySelect = document.getElementById('primary_city_id');
        if (primaryCitySelect) {
            primaryCitySelect.value = '';
        }
        
        // Reset role dropdown
        const roleSelect = document.getElementById('role');
        if (roleSelect) {
            roleSelect.value = '';
        }
        
        // Clear any validation errors
        document.querySelectorAll('.is-invalid').forEach(el => {
            el.classList.remove('is-invalid');
        });
        
        // Scroll to top
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function resetForm() {
        // Reset the form
        document.getElementById('userForm').reset();
        
        // Reset Save button state
        document.getElementById('saveBtn').disabled = true;
        document.getElementById('saveBtn').classList.remove('btn-primary');
        document.getElementById('saveBtn').classList.add('btn-secondary');
        
        // Reset all checkboxes in dynamic permissions
        document.querySelectorAll('.permission-tree input[type="checkbox"]').forEach(cb => {
            cb.checked = false;
        });
        
        // Reset all menu permission checkboxes (if any)
        document.querySelectorAll('.menu-rights-list input[type="checkbox"]').forEach(cb => {
            cb.checked = false;
        });
        
        // Reset city permissions
        document.querySelectorAll('.city-checkbox').forEach(cb => {
            cb.checked = false;
            const cityId = cb.value;
            const detailsDiv = document.getElementById('city_details_' + cityId);
            if (detailsDiv) {
                detailsDiv.style.display = 'none';
            }
        });
        
        // Reset primary city
        document.getElementById('primary_city_id').value = '';
        
        // Reset role dropdown
        document.getElementById('role').value = '';
        
        // Scroll to top
        window.scrollTo({ top: 0, behavior: 'smooth' });
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/Logistics-Management-System/resources/views/users/create.blade.php ENDPATH**/ ?>