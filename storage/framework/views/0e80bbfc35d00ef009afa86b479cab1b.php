<?php $__env->startSection('title', 'Vendor Details'); ?>
<?php $__env->startSection('page-title', 'Vendor Details'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"> Vendor Information</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="40%">Vendor ID:</th>
                        <td><?php echo e($vendor->vendor_id); ?></td>
                    </tr>
                    <tr>
                        <th>Name:</th>
                        <td><?php echo e($vendor->name); ?></td>
                    </tr>
                    <tr>
                        <th>Services:</th>
                        <td><?php echo e($vendor->services ?? 'N/A'); ?></td>
                    </tr>
                    <tr>
                        <th>Contact:</th>
                        <td><?php echo e($vendor->contact ?? 'N/A'); ?></td>
                    </tr>
                    <tr>
                        <th>Email:</th>
                        <td><?php echo e($vendor->email ?? 'N/A'); ?></td>
                    </tr>
                    <tr>
                        <th>Address:</th>
                        <td><?php echo e($vendor->address ?? 'N/A'); ?></td>
                    </tr>
                    <tr>
                        <th>Billing Terms:</th>
                        <td><?php echo e($vendor->billing_terms ?? 'N/A'); ?></td>
                    </tr>
                    <tr>
                        <th>Tax ID:</th>
                        <td><?php echo e($vendor->tax_id ?? 'N/A'); ?></td>
                    </tr>
                    <tr>
                        <th>Status:</th>
                        <td><span class="badge bg-<?php echo e($vendor->status === 'active' ? 'success' : 'secondary'); ?>"><?php echo e(ucfirst($vendor->status)); ?></span></td>
                    </tr>
                </table>
                <div class="mt-3">
                    <a href="<?php echo e(route('vendors.edit', $vendor)); ?>" class="btn btn-primary">
                         Edit
                    </a>
                    <a href="<?php echo e(route('vendors.index')); ?>" class="btn btn-secondary">
                         Back
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"> Shipments (<?php echo e($vendor->shipments->count()); ?>)</h5>
            </div>
            <div class="card-body">
                <?php if($vendor->shipments->count() > 0): ?>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Shipment #</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $vendor->shipments->take(10); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shipment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><a href="<?php echo e(route('shipments.show', $shipment)); ?>"><?php echo e($shipment->shipment_number); ?></a></td>
                                <td><span class="badge bg-<?php echo e($shipment->status === 'delivered' ? 'success' : 'warning'); ?>"><?php echo e(ucfirst(str_replace('-', ' ', $shipment->status))); ?></span></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <p class="text-muted">No shipments found.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/Logistics-Management-System/resources/views/vendors/show.blade.php ENDPATH**/ ?>