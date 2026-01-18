<?php $__env->startSection('title', 'Drivers'); ?>
<?php $__env->startSection('page-title', 'Drivers Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"> Drivers</h5>
        <a href="<?php echo e(route('drivers.create')); ?>" class="btn btn-primary btn-sm">
             Add Driver
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Driver ID</th>
                        <th>Name</th>
                        <th>License #</th>
                        <th>Contact</th>
                        <th>Assigned Vehicle</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $drivers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $driver): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($driver->driver_id); ?></td>
                        <td><?php echo e($driver->name); ?></td>
                        <td><?php echo e($driver->license_no); ?></td>
                        <td><?php echo e($driver->contact ?? 'N/A'); ?></td>
                        <td><?php echo e($driver->vehicle->registration_no ?? 'N/A'); ?></td>
                        <td><span class="badge bg-<?php echo e($driver->status === 'available' ? 'success' : ($driver->status === 'on-trip' ? 'warning' : 'secondary')); ?>"><?php echo e(ucfirst(str_replace('-', ' ', $driver->status))); ?></span></td>
                        <td>
                            <a href="<?php echo e(route('drivers.show', $driver)); ?>" class="btn btn-sm btn-outline-info">
                                
                            </a>
                            <a href="<?php echo e(route('drivers.edit', $driver)); ?>" class="btn btn-sm btn-outline-primary">
                                
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="text-center">No drivers found</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            <?php echo e($drivers->links()); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/Logistics-Management-System/resources/views/drivers/index.blade.php ENDPATH**/ ?>