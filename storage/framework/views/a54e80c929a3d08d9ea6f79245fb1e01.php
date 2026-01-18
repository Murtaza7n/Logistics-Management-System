<?php $__env->startSection('title', 'Vehicles'); ?>
<?php $__env->startSection('page-title', 'Vehicles Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"> Vehicles</h5>
        <a href="<?php echo e(route('vehicles.create')); ?>" class="btn btn-primary btn-sm">
             Add Vehicle
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Vehicle ID</th>
                        <th>Type</th>
                        <th>Registration #</th>
                        <th>Make/Model</th>
                        <th>Capacity</th>
                        <th>Assigned Driver</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $vehicles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vehicle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($vehicle->vehicle_id); ?></td>
                        <td><?php echo e($vehicle->type); ?></td>
                        <td><?php echo e($vehicle->registration_no); ?></td>
                        <td><?php echo e($vehicle->make); ?> <?php echo e($vehicle->model); ?></td>
                        <td><?php echo e($vehicle->capacity ?? 'N/A'); ?> kg</td>
                        <td><?php echo e($vehicle->driver->name ?? 'N/A'); ?></td>
                        <td><span class="badge bg-<?php echo e($vehicle->status === 'available' ? 'success' : ($vehicle->status === 'in-use' ? 'warning' : 'secondary')); ?>"><?php echo e(ucfirst(str_replace('-', ' ', $vehicle->status))); ?></span></td>
                        <td>
                            <a href="<?php echo e(route('vehicles.show', $vehicle)); ?>" class="btn btn-sm btn-outline-info">
                                
                            </a>
                            <a href="<?php echo e(route('vehicles.edit', $vehicle)); ?>" class="btn btn-sm btn-outline-primary">
                                
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="8" class="text-center">No vehicles found</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            <?php echo e($vehicles->links()); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/Logistics-Management-System/resources/views/vehicles/index.blade.php ENDPATH**/ ?>