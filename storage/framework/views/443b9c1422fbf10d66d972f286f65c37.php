<?php $__env->startSection('title', 'Zone Codes'); ?>
<?php $__env->startSection('page-title', 'Zone Codes Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <h1 class="page-title">Zone Codes</h1>
            <p class="page-subtitle">Manage zone codes and base rates</p>
        </div>
        <div class="d-flex flex-wrap gap-2 mt-2 mt-md-0">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addZoneCodeModal">
                Add Zone Code
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
                <a href="<?php echo e(route('master-data.zone-codes')); ?>" class="btn btn-secondary w-100">Reset</a>
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
                        <th>Zone Code</th>
                        <th>Zone Name</th>
                        <th>City</th>
                        <th>State</th>
                        <th>Base Rate</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $zoneCodes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><strong><?php echo e($zone->zone_code); ?></strong></td>
                        <td><?php echo e($zone->zone_name); ?></td>
                        <td><?php echo e($zone->city ?? '-'); ?></td>
                        <td><?php echo e($zone->state ?? '-'); ?></td>
                        <td><?php echo e($zone->base_rate ? number_format($zone->base_rate, 2) : '-'); ?></td>
                        <td>
                            <span class="badge bg-<?php echo e($zone->is_active ? 'success' : 'secondary'); ?>">
                                <?php echo e($zone->is_active ? 'Active' : 'Inactive'); ?>

                            </span>
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-info" onclick="editZoneCode(<?php echo e($zone->id); ?>)">Edit</button>
                            <form action="<?php echo e(route('master-data.zone-codes.delete', $zone->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted">No zone codes found.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            <?php echo e($zoneCodes->links()); ?>

        </div>
    </div>
</div>

<!-- Add/Edit Modal -->
<div class="modal fade" id="addZoneCodeModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="zoneCodeForm" method="POST">
                <?php echo csrf_field(); ?>
                <div id="formMethod"></div>
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Add Zone Code</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Zone Code <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="zone_code" id="zone_code" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Zone Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="zone_name" id="zone_name" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">City</label>
                            <select class="form-select" name="city" id="city">
                                <option value="">Select City</option>
                                <?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($city->name); ?>"><?php echo e($city->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">State</label>
                            <input type="text" class="form-control" name="state" id="state">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Base Rate</label>
                            <input type="number" step="0.01" class="form-control" name="base_rate" id="base_rate" value="0">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" id="description" rows="2"></textarea>
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
let zoneCodesData = <?php echo json_encode($zoneCodes->items(), 15, 512) ?>;

function editZoneCode(id) {
    const zone = zoneCodesData.find(z => z.id === id);
    if (!zone) return;

    document.getElementById('modalTitle').textContent = 'Edit Zone Code';
    document.getElementById('zoneCodeForm').action = '<?php echo e(route("master-data.zone-codes.update", ":id")); ?>'.replace(':id', id);
    document.getElementById('formMethod').innerHTML = '<input type="hidden" name="_method" value="PUT">';
    
    document.getElementById('zone_code').value = zone.zone_code;
    document.getElementById('zone_name').value = zone.zone_name;
    document.getElementById('city').value = zone.city || '';
    document.getElementById('state').value = zone.state || '';
    document.getElementById('base_rate').value = zone.base_rate || 0;
    document.getElementById('description').value = zone.description || '';
    document.getElementById('is_active').checked = zone.is_active;

    new bootstrap.Modal(document.getElementById('addZoneCodeModal')).show();
}

document.getElementById('addZoneCodeModal').addEventListener('hidden.bs.modal', function() {
    document.getElementById('zoneCodeForm').reset();
    document.getElementById('zoneCodeForm').action = '<?php echo e(route("master-data.zone-codes.store")); ?>';
    document.getElementById('modalTitle').textContent = 'Add Zone Code';
    document.getElementById('formMethod').innerHTML = '';
});
</script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/Logistics-Management-System/resources/views/master-data/zone-codes.blade.php ENDPATH**/ ?>