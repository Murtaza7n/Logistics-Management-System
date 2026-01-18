<?php $__env->startSection('title', 'List of City Codes'); ?>
<?php $__env->startSection('page-title', 'List of City Codes'); ?>

<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">
        
        List of City Codes
    </h1>
    <p class="page-subtitle">Master list of all cities and their codes</p>
</div>

<!-- Success/Error Messages -->
<?php if(session('success')): ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <?php echo e(session('success')); ?>

    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<?php if(session('error')): ?>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <?php echo e(session('error')); ?>

    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<!-- Add City Card -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0"> Add New City</h5>
    </div>
    <div class="card-body">
        <form action="<?php echo e(route('cities.store')); ?>" method="POST" id="addCityForm">
            <?php echo csrf_field(); ?>
            <div class="row g-3">
                <div class="col-md-4">
                    <label for="name" class="form-label">City Name <span class="text-danger">*</span></label>
                    <input type="text" 
                           class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                           id="name" 
                           name="name" 
                           value="<?php echo e(old('name')); ?>" 
                           required 
                           placeholder="e.g., Karachi">
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
                <div class="col-md-3">
                    <label for="code" class="form-label">City Code</label>
                    <input type="text" 
                           class="form-control <?php $__errorArgs = ['code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                           id="code" 
                           name="code" 
                           value="<?php echo e(old('code')); ?>" 
                           maxlength="10"
                           placeholder="e.g., KHI"
                           style="text-transform: uppercase;">
                    <?php $__errorArgs = ['code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    <small class="text-muted">Optional: 3-letter code</small>
                </div>
                <div class="col-md-3">
                    <label for="state" class="form-label">State/Province</label>
                    <input type="text" 
                           class="form-control <?php $__errorArgs = ['state'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                           id="state" 
                           name="state" 
                           value="<?php echo e(old('state')); ?>" 
                           placeholder="e.g., Sindh">
                    <?php $__errorArgs = ['state'];
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
                <div class="col-md-2">
                    <label for="is_active" class="form-label">Status</label>
                    <select class="form-select" id="is_active" name="is_active">
                        <option value="1" <?php echo e(old('is_active', '1') == '1' ? 'selected' : ''); ?>>Active</option>
                        <option value="0" <?php echo e(old('is_active') == '0' ? 'selected' : ''); ?>>Inactive</option>
                    </select>
                </div>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">
                     Add City
                </button>
                <button type="reset" class="btn btn-secondary">
                     Clear
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Cities List Card -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"> Cities (<?php echo e($cities->count()); ?> records)</h5>
        <div class="d-flex gap-2">
            <!-- Search Form -->
            <form method="GET" action="<?php echo e(route('cities.index')); ?>" class="d-flex gap-2">
                <input type="text" 
                       class="form-control form-control-sm" 
                       name="search" 
                       value="<?php echo e(request('search')); ?>" 
                       placeholder="Search cities..." 
                       style="width: 200px;">
                <select class="form-select form-select-sm" name="status" style="width: 120px;">
                    <option value="">All Status</option>
                    <option value="active" <?php echo e(request('status') === 'active' ? 'selected' : ''); ?>>Active</option>
                    <option value="inactive" <?php echo e(request('status') === 'inactive' ? 'selected' : ''); ?>>Inactive</option>
                </select>
                <button type="submit" class="btn btn-sm btn-primary">
                     Filter
                </button>
                <?php if(request()->hasAny(['search', 'status'])): ?>
                <a href="<?php echo e(route('cities.index')); ?>" class="btn btn-sm btn-secondary">
                     Clear
                </a>
                <?php endif; ?>
            </form>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>City ID</th>
                        <th>City Name</th>
                        <th>Code</th>
                        <th>State/Province</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($city->city_id); ?></td>
                        <td><strong><?php echo e($city->name); ?></strong></td>
                        <td>
                            <?php if($city->code): ?>
                                <span class="badge bg-info"><?php echo e($city->code); ?></span>
                            <?php else: ?>
                                <span class="text-muted">N/A</span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo e($city->state ?? 'N/A'); ?></td>
                        <td>
                            <span class="badge bg-<?php echo e($city->is_active ? 'success' : 'secondary'); ?>">
                                <?php echo e($city->is_active ? 'Active' : 'Inactive'); ?>

                            </span>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <form action="<?php echo e(route('cities.toggle-status', $city->city_id)); ?>" method="POST" class="d-inline">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('PATCH'); ?>
                                    <button type="submit" 
                                            class="btn btn-sm btn-<?php echo e($city->is_active ? 'warning' : 'success'); ?>"
                                            title="<?php echo e($city->is_active ? 'Deactivate' : 'Activate'); ?>">
                                        
                                    </button>
                                </form>
                                <form action="<?php echo e(route('cities.destroy', $city->city_id)); ?>" 
                                      method="POST" 
                                      class="d-inline delete-city-form"
                                      data-city-name="<?php echo e($city->name); ?>"
                                      data-shipments-count="<?php echo e($city->shipments()->count()); ?>">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" 
                                            class="btn btn-sm btn-danger"
                                            title="Delete City">
                                        
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="text-center">
                            <?php if(request()->hasAny(['search', 'status'])): ?>
                                No cities found matching your search criteria.
                            <?php else: ?>
                                No cities found. Add your first city above.
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-uppercase city code
    const codeInput = document.getElementById('code');
    if (codeInput) {
        codeInput.addEventListener('input', function() {
            this.value = this.value.toUpperCase();
        });
    }

    // Delete confirmation with shipment check
    const deleteForms = document.querySelectorAll('.delete-city-form');
    deleteForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const cityName = this.getAttribute('data-city-name');
            const shipmentsCount = parseInt(this.getAttribute('data-shipments-count')) || 0;
            
            let message = `Are you sure you want to delete the city "${cityName}"?`;
            
            if (shipmentsCount > 0) {
                message += `\n\nWARNING: This city is currently used in ${shipmentsCount} shipment(s). Deleting it may cause data inconsistencies.`;
                message += `\n\nIt is recommended to deactivate the city instead of deleting it.`;
                
                if (!confirm(message)) {
                    return;
                }
                
                // Double confirmation for cities in use
                if (!confirm('This action cannot be undone. Are you absolutely sure?')) {
                    return;
                }
            } else {
                if (!confirm(message + '\n\nThis action cannot be undone.')) {
                    return;
                }
            }
            
            this.submit();
        });
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/Logistics-Management-System/resources/views/reports/list_of_city_codes.blade.php ENDPATH**/ ?>