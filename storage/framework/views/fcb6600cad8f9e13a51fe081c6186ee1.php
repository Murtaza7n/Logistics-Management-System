<?php $__env->startSection('title', 'Driver Performance Report'); ?>
<?php $__env->startSection('page-title', 'Driver Performance Report'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
        <h5 class="mb-0"> Driver Performance Report</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Driver</th>
                        <th>License #</th>
                        <th>Status</th>
                        <th>Total Shipments</th>
                        <th>Delivered</th>
                        <th>On-Time Deliveries</th>
                        <th>Assigned Vehicle</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $drivers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $driver): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($driver->name); ?></td>
                        <td><?php echo e($driver->license_no); ?></td>
                        <td><span class="badge bg-<?php echo e($driver->status === 'available' ? 'success' : 'warning'); ?>"><?php echo e(ucfirst(str_replace('-', ' ', $driver->status))); ?></span></td>
                        <td><?php echo e($driver->total_shipments); ?></td>
                        <td><?php echo e($driver->delivered_shipments); ?></td>
                        <td><?php echo e($driver->on_time_deliveries); ?></td>
                        <td><?php echo e($driver->vehicle->registration_no ?? 'N/A'); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="text-center">No drivers found</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/Logistics-Management-System/resources/views/reports/driver_performance.blade.php ENDPATH**/ ?>