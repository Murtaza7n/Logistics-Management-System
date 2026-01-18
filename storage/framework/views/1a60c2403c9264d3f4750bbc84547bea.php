<?php $__env->startSection('title', 'Vehicle Usage Report'); ?>
<?php $__env->startSection('page-title', 'Vehicle Usage Report'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
        <h5 class="mb-0"> Vehicle Usage Report</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Vehicle</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Total Shipments</th>
                        <th>Total Revenue</th>
                        <th>Assigned Driver</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $vehicles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vehicle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($vehicle->registration_no); ?></td>
                        <td><?php echo e($vehicle->type); ?></td>
                        <td><span class="badge bg-<?php echo e($vehicle->status === 'available' ? 'success' : 'warning'); ?>"><?php echo e(ucfirst(str_replace('-', ' ', $vehicle->status))); ?></span></td>
                        <td><?php echo e($vehicle->total_shipments); ?></td>
                        <td>Rs.<?php echo e(number_format($vehicle->total_revenue, 2)); ?></td>
                        <td><?php echo e($vehicle->driver->name ?? 'N/A'); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="text-center">No vehicles found</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/Logistics-Management-System/resources/views/reports/vehicle_usage.blade.php ENDPATH**/ ?>