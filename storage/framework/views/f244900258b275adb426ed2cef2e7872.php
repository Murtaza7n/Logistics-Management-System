<?php $__env->startSection('title', 'Cargo Officers'); ?>
<?php $__env->startSection('page-title', 'SPO/Cargo Officers Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <h1 class="page-title">SPO/Cargo Officers</h1>
            <p class="page-subtitle">Manage cargo officers and SPO</p>
        </div>
        <div class="d-flex flex-wrap gap-2 mt-2 mt-md-0">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCargoOfficerModal">
                Add Cargo Officer
            </button>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <form method="GET" class="row g-2">
            <div class="col-md-3">
                <input type="text" class="form-control" name="search" value="<?php echo e(request('search')); ?>" placeholder="Search...">
            </div>
            <div class="col-md-2">
                <select class="form-select" name="city">
                    <option value="">All Cities</option>
                    <?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($city->name); ?>" <?php echo e(request('city') == $city->name ? 'selected' : ''); ?>><?php echo e($city->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-select" name="status">
                    <option value="">All Status</option>
                    <option value="active" <?php echo e(request('status') === 'active' ? 'selected' : ''); ?>>Active</option>
                    <option value="inactive" <?php echo e(request('status') === 'inactive' ? 'selected' : ''); ?>>Inactive</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
            <div class="col-md-2">
                <a href="<?php echo e(route('master-data.cargo-officers')); ?>" class="btn btn-secondary w-100">Reset</a>
            </div>
        </form>
    </div>
    <div class="card-body">
        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Officer Code</th>
                        <th>Officer Name</th>
                        <th>Designation</th>
                        <th>City</th>
                        <th>Hub</th>
                        <th>Contact</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $cargoOfficers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $officer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><strong><?php echo e($officer->officer_code); ?></strong></td>
                        <td><?php echo e($officer->officer_name); ?></td>
                        <td><?php echo e($officer->designation ?? '-'); ?></td>
                        <td><?php echo e($officer->city ?? '-'); ?></td>
                        <td><?php echo e($officer->hub ?? '-'); ?></td>
                        <td><?php echo e($officer->contact_number ?? '-'); ?></td>
                        <td>
                            <span class="badge bg-<?php echo e($officer->is_active ? 'success' : 'secondary'); ?>">
                                <?php echo e($officer->is_active ? 'Active' : 'Inactive'); ?>

                            </span>
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-info" onclick="editCargoOfficer(<?php echo e($officer->id); ?>)">Edit</button>
                            <form action="<?php echo e(route('master-data.cargo-officers.delete', $officer->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="8" class="text-center text-muted">No cargo officers found.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            <?php echo e($cargoOfficers->links()); ?>

        </div>
    </div>
</div>

<!-- Add/Edit Modal -->
<div class="modal fade" id="addCargoOfficerModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="cargoOfficerForm" method="POST">
                <?php echo csrf_field(); ?>
                <div id="formMethod"></div>
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Add Cargo Officer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Officer Code <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="officer_code" id="officer_code" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Officer Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="officer_name" id="officer_name" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Designation</label>
                            <input type="text" class="form-control" name="designation" id="designation" placeholder="SPO, Cargo Officer, etc.">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Employee ID</label>
                            <input type="text" class="form-control" name="employee_id" id="employee_id">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">City</label>
                            <select class="form-select" name="city" id="city">
                                <option value="">Select City</option>
                                <?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($city->name); ?>"><?php echo e($city->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Hub</label>
                            <input type="text" class="form-control" name="hub" id="hub">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Contact Number</label>
                            <input type="text" class="form-control" name="contact_number" id="contact_number">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" id="email">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <textarea class="form-control" name="address" id="address" rows="2"></textarea>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" checked>
                            <label class="form-check-label" for="is_active">Active</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let cargoOfficersData = <?php echo json_encode($cargoOfficers->items(), 15, 512) ?>;

function editCargoOfficer(id) {
    const officer = cargoOfficersData.find(o => o.id === id);
    if (!officer) return;

    document.getElementById('modalTitle').textContent = 'Edit Cargo Officer';
    document.getElementById('cargoOfficerForm').action = '<?php echo e(route("master-data.cargo-officers.update", ":id")); ?>'.replace(':id', id);
    document.getElementById('formMethod').innerHTML = '<input type="hidden" name="_method" value="PUT">';
    
    document.getElementById('officer_code').value = officer.officer_code;
    document.getElementById('officer_name').value = officer.officer_name;
    document.getElementById('designation').value = officer.designation || '';
    document.getElementById('employee_id').value = officer.employee_id || '';
    document.getElementById('city').value = officer.city || '';
    document.getElementById('hub').value = officer.hub || '';
    document.getElementById('contact_number').value = officer.contact_number || '';
    document.getElementById('email').value = officer.email || '';
    document.getElementById('address').value = officer.address || '';
    document.getElementById('is_active').checked = officer.is_active;

    new bootstrap.Modal(document.getElementById('addCargoOfficerModal')).show();
}

document.getElementById('addCargoOfficerModal').addEventListener('hidden.bs.modal', function() {
    document.getElementById('cargoOfficerForm').reset();
    document.getElementById('cargoOfficerForm').action = '<?php echo e(route("master-data.cargo-officers.store")); ?>';
    document.getElementById('modalTitle').textContent = 'Add Cargo Officer';
    document.getElementById('formMethod').innerHTML = '';
});
</script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/Logistics-Management-System/resources/views/master-data/cargo-officers.blade.php ENDPATH**/ ?>