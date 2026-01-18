<?php $__env->startSection('title', 'Party/Area Rates'); ?>
<?php $__env->startSection('page-title', 'Party or Area-wise Rate Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <h1 class="page-title">Party or Area-wise Rate</h1>
            <p class="page-subtitle">Manage party and area-specific freight rates</p>
        </div>
        <div class="d-flex flex-wrap gap-2 mt-2 mt-md-0">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPartyAreaRateModal">
                Add Party/Area Rate
            </button>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <form method="GET" class="row g-2">
            <div class="col-md-2">
                <input type="text" class="form-control" name="search" value="<?php echo e(request('search')); ?>" placeholder="Search...">
            </div>
            <div class="col-md-2">
                <select class="form-select" name="party_type">
                    <option value="">All Types</option>
                    <option value="Customer" <?php echo e(request('party_type') === 'Customer' ? 'selected' : ''); ?>>Customer</option>
                    <option value="Vendor" <?php echo e(request('party_type') === 'Vendor' ? 'selected' : ''); ?>>Vendor</option>
                    <option value="Area" <?php echo e(request('party_type') === 'Area' ? 'selected' : ''); ?>>Area</option>
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-select" name="from_city">
                    <option value="">From City</option>
                    <?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($city->name); ?>" <?php echo e(request('from_city') == $city->name ? 'selected' : ''); ?>><?php echo e($city->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-select" name="to_city">
                    <option value="">To City</option>
                    <?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($city->name); ?>" <?php echo e(request('to_city') == $city->name ? 'selected' : ''); ?>><?php echo e($city->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-1">
                <select class="form-select" name="status">
                    <option value="">All</option>
                    <option value="active" <?php echo e(request('status') === 'active' ? 'selected' : ''); ?>>Active</option>
                    <option value="inactive" <?php echo e(request('status') === 'inactive' ? 'selected' : ''); ?>>Inactive</option>
                </select>
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
            <div class="col-md-1">
                <a href="<?php echo e(route('master-data.party-area-rates')); ?>" class="btn btn-secondary w-100">Reset</a>
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
                        <th>Party Type</th>
                        <th>Party Name</th>
                        <th>From City</th>
                        <th>To City</th>
                        <th>Rate/KG</th>
                        <th>Rate/Piece</th>
                        <th>Min Charge</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $partyAreaRates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><span class="badge bg-info"><?php echo e($rate->party_type ?? 'Area'); ?></span></td>
                        <td><?php echo e($rate->party_name); ?></td>
                        <td><?php echo e($rate->from_city ?? '-'); ?></td>
                        <td><?php echo e($rate->to_city ?? '-'); ?></td>
                        <td><?php echo e($rate->rate_per_kg ? number_format($rate->rate_per_kg, 2) : '-'); ?></td>
                        <td><?php echo e($rate->rate_per_piece ? number_format($rate->rate_per_piece, 2) : '-'); ?></td>
                        <td><?php echo e($rate->minimum_charge ? number_format($rate->minimum_charge, 2) : '-'); ?></td>
                        <td>
                            <span class="badge bg-<?php echo e($rate->is_active ? 'success' : 'secondary'); ?>">
                                <?php echo e($rate->is_active ? 'Active' : 'Inactive'); ?>

                            </span>
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-info" onclick="editPartyAreaRate(<?php echo e($rate->id); ?>)">Edit</button>
                            <form action="<?php echo e(route('master-data.party-area-rates.delete', $rate->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="9" class="text-center text-muted">No party/area rates found.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            <?php echo e($partyAreaRates->links()); ?>

        </div>
    </div>
</div>

<!-- Add/Edit Modal -->
<div class="modal fade" id="addPartyAreaRateModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="partyAreaRateForm" method="POST">
                <?php echo csrf_field(); ?>
                <div id="formMethod"></div>
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Add Party/Area Rate</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Party Type</label>
                            <select class="form-select" name="party_type" id="party_type">
                                <option value="">Select Type</option>
                                <option value="Customer">Customer</option>
                                <option value="Vendor">Vendor</option>
                                <option value="Area">Area</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Party Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="party_name" id="party_name" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">From City</label>
                            <select class="form-select" name="from_city" id="from_city">
                                <option value="">Select City</option>
                                <?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($city->name); ?>"><?php echo e($city->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">To City</label>
                            <select class="form-select" name="to_city" id="to_city">
                                <option value="">Select City</option>
                                <?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($city->name); ?>"><?php echo e($city->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Vehicle Type</label>
                            <input type="text" class="form-control" name="vehicle_type" id="vehicle_type">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Rate per KG</label>
                            <input type="number" step="0.01" class="form-control" name="rate_per_kg" id="rate_per_kg" value="0">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Rate per Piece</label>
                            <input type="number" step="0.01" class="form-control" name="rate_per_piece" id="rate_per_piece" value="0">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Minimum Charge</label>
                            <input type="number" step="0.01" class="form-control" name="minimum_charge" id="minimum_charge" value="0">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Effective From</label>
                            <input type="date" class="form-control" name="effective_from" id="effective_from">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Effective To</label>
                            <input type="date" class="form-control" name="effective_to" id="effective_to">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Area Name (if Area type)</label>
                        <input type="text" class="form-control" name="area_name" id="area_name">
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
let partyAreaRatesData = <?php echo json_encode($partyAreaRates->items(), 15, 512) ?>;

function editPartyAreaRate(id) {
    const rate = partyAreaRatesData.find(r => r.id === id);
    if (!rate) return;

    document.getElementById('modalTitle').textContent = 'Edit Party/Area Rate';
    document.getElementById('partyAreaRateForm').action = '<?php echo e(route("master-data.party-area-rates.update", ":id")); ?>'.replace(':id', id);
    document.getElementById('formMethod').innerHTML = '<input type="hidden" name="_method" value="PUT">';
    
    document.getElementById('party_type').value = rate.party_type || '';
    document.getElementById('party_name').value = rate.party_name;
    document.getElementById('from_city').value = rate.from_city || '';
    document.getElementById('to_city').value = rate.to_city || '';
    document.getElementById('vehicle_type').value = rate.vehicle_type || '';
    document.getElementById('rate_per_kg').value = rate.rate_per_kg || 0;
    document.getElementById('rate_per_piece').value = rate.rate_per_piece || 0;
    document.getElementById('minimum_charge').value = rate.minimum_charge || 0;
    document.getElementById('effective_from').value = rate.effective_from || '';
    document.getElementById('effective_to').value = rate.effective_to || '';
    document.getElementById('area_name').value = rate.area_name || '';
    document.getElementById('is_active').checked = rate.is_active;

    new bootstrap.Modal(document.getElementById('addPartyAreaRateModal')).show();
}

document.getElementById('addPartyAreaRateModal').addEventListener('hidden.bs.modal', function() {
    document.getElementById('partyAreaRateForm').reset();
    document.getElementById('partyAreaRateForm').action = '<?php echo e(route("master-data.party-area-rates.store")); ?>';
    document.getElementById('modalTitle').textContent = 'Add Party/Area Rate';
    document.getElementById('formMethod').innerHTML = '';
});
</script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/Logistics-Management-System/resources/views/master-data/party-area-rates.blade.php ENDPATH**/ ?>