<?php $__env->startSection('title', 'Vendor-wise Report'); ?>
<?php $__env->startSection('page-title', 'Vendor-wise Report'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
        <h5 class="mb-0"> Vendor-wise Report</h5>
    </div>
    <div class="card-body">
        <form method="GET" class="mb-3">
            <div class="row g-2">
                <div class="col-md-4">
                    <select class="form-select" name="vendor_id">
                        <option value="">All Vendors</option>
                        <?php $__currentLoopData = $allVendors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vendor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($vendor->vendor_id); ?>" <?php echo e(request('vendor_id') == $vendor->vendor_id ? 'selected' : ''); ?>><?php echo e($vendor->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="<?php echo e(route('reports.vendor-wise')); ?>" class="btn btn-secondary">Reset</a>
                </div>
            </div>
        </form>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Vendor</th>
                        <th>Total Shipments</th>
                        <th>Total Billing</th>
                        <th>Total Paid</th>
                        <th>Balance</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $vendors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vendor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($vendor->name); ?></td>
                        <td><?php echo e($vendor->total_shipments); ?></td>
                        <td>Rs.<?php echo e(number_format($vendor->total_billing, 2)); ?></td>
                        <td>Rs.<?php echo e(number_format($vendor->total_paid, 2)); ?></td>
                        <td>Rs.<?php echo e(number_format($vendor->total_billing - $vendor->total_paid, 2)); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="text-center">No vendors found</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/Logistics-Management-System/resources/views/reports/vendor_wise.blade.php ENDPATH**/ ?>