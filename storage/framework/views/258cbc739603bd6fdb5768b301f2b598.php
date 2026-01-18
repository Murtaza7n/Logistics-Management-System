<?php $__env->startSection('title', 'Create Driver'); ?>
<?php $__env->startSection('page-title', 'Create Driver'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
        <h5 class="mb-0"> Create New Driver</h5>
    </div>
    <div class="card-body">
        <form action="<?php echo e(route('drivers.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo e(old('name')); ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="license_no" class="form-label">License Number <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="license_no" name="license_no" value="<?php echo e(old('license_no')); ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="contact" class="form-label">Contact</label>
                    <input type="text" class="form-control" id="contact" name="contact" value="<?php echo e(old('contact')); ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="assigned_vehicle" class="form-label">Assigned Vehicle</label>
                    <select class="form-select" id="assigned_vehicle" name="assigned_vehicle">
                        <option value="">Select Vehicle</option>
                        <?php $__currentLoopData = $vehicles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vehicle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($vehicle->vehicle_id); ?>" <?php echo e(old('assigned_vehicle') == $vehicle->vehicle_id ? 'selected' : ''); ?>><?php echo e($vehicle->registration_no); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                    <select class="form-select" id="status" name="status" required>
                        <option value="available" <?php echo e(old('status') === 'available' ? 'selected' : ''); ?>>Available</option>
                        <option value="on-trip" <?php echo e(old('status') === 'on-trip' ? 'selected' : ''); ?>>On Trip</option>
                        <option value="off-duty" <?php echo e(old('status') === 'off-duty' ? 'selected' : ''); ?>>Off Duty</option>
                    </select>
                </div>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">
                     Create Driver
                </button>
                <a href="<?php echo e(route('drivers.index')); ?>" class="btn btn-secondary">
                     Cancel
                </a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/Logistics-Management-System/resources/views/drivers/create.blade.php ENDPATH**/ ?>