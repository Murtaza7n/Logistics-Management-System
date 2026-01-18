<?php $__env->startSection('title', 'Customer Details'); ?>
<?php $__env->startSection('page-title', 'Customer Details'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"> Customer Information</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="40%">Customer ID:</th>
                        <td><?php echo e($customer->customer_id); ?></td>
                    </tr>
                    <tr>
                        <th>Name:</th>
                        <td><?php echo e($customer->name); ?></td>
                    </tr>
                    <tr>
                        <th>Contact:</th>
                        <td><?php echo e($customer->contact ?? 'N/A'); ?></td>
                    </tr>
                    <tr>
                        <th>Email:</th>
                        <td><?php echo e($customer->email ?? 'N/A'); ?></td>
                    </tr>
                    <tr>
                        <th>Address:</th>
                        <td><?php echo e($customer->address ?? 'N/A'); ?></td>
                    </tr>
                    <tr>
                        <th>City:</th>
                        <td><?php echo e($customer->city ?? 'N/A'); ?></td>
                    </tr>
                    <tr>
                        <th>State:</th>
                        <td><?php echo e($customer->state ?? 'N/A'); ?></td>
                    </tr>
                    <tr>
                        <th>Country:</th>
                        <td><?php echo e($customer->country ?? 'N/A'); ?></td>
                    </tr>
                    <tr>
                        <th>Tax ID:</th>
                        <td><?php echo e($customer->tax_id ?? 'N/A'); ?></td>
                    </tr>
                    <tr>
                        <th>Status:</th>
                        <td><span class="badge bg-<?php echo e($customer->status === 'active' ? 'success' : 'secondary'); ?>"><?php echo e(ucfirst($customer->status)); ?></span></td>
                    </tr>
                </table>
                <div class="mt-3">
                    <a href="<?php echo e(route('customers.edit', $customer)); ?>" class="btn btn-primary">
                         Edit
                    </a>
                    <a href="<?php echo e(route('customers.index')); ?>" class="btn btn-secondary">
                         Back
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"> Shipments (<?php echo e($customer->shipments->count()); ?>)</h5>
            </div>
            <div class="card-body">
                <?php if($customer->shipments->count() > 0): ?>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Shipment #</th>
                                <th>Status</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $customer->shipments->take(10); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shipment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><a href="<?php echo e(route('shipments.show', $shipment)); ?>"><?php echo e($shipment->shipment_number); ?></a></td>
                                <td><span class="badge bg-<?php echo e($shipment->status === 'delivered' ? 'success' : 'warning'); ?>"><?php echo e(ucfirst(str_replace('-', ' ', $shipment->status))); ?></span></td>
                                <td>Rs.<?php echo e(number_format($shipment->total_charges, 2)); ?></td>
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



<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/Logistics-Management-System/resources/views/customers/show.blade.php ENDPATH**/ ?>