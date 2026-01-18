<?php $__env->startSection('title', 'List of Vehicle Types'); ?>
<?php $__env->startSection('page-title', 'List of Vehicle Types'); ?>

<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">
        
        List of Vehicle Types
    </h1>
    <p class="page-subtitle">Master list of all vehicle types and their counts</p>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"> Vehicle Types (<?php echo e($vehicleTypes->count()); ?> records)</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Vehicle Type</th>
                        <th>Count</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $vehicleTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><strong><?php echo e($type->type ?? 'N/A'); ?></strong></td>
                        <td>
                            <span class="badge badge-primary"><?php echo e($type->count); ?></span>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="2" class="text-center">No vehicle types found</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/Logistics-Management-System/resources/views/reports/list_of_vehicle_types.blade.php ENDPATH**/ ?>