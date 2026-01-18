<?php $__env->startSection('title', 'Create Vehicle'); ?>
<?php $__env->startSection('page-title', 'Create Vehicle'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
        <h5 class="mb-0"> Create New Vehicle</h5>
    </div>
    <div class="card-body">
        <form action="<?php echo e(route('vehicles.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="type" class="form-label">Type <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="type" name="type" value="<?php echo e(old('type')); ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="registration_no" class="form-label">Registration Number <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="registration_no" name="registration_no" value="<?php echo e(old('registration_no')); ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="make" class="form-label">Make</label>
                    <input type="text" class="form-control" id="make" name="make" value="<?php echo e(old('make')); ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="model" class="form-label">Model</label>
                    <input type="text" class="form-control" id="model" name="model" value="<?php echo e(old('model')); ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="year" class="form-label">Year</label>
                    <input type="number" class="form-control" id="year" name="year" value="<?php echo e(old('year')); ?>" min="1900" max="<?php echo e(date('Y')); ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="capacity" class="form-label">Capacity (kg)</label>
                    <input type="number" step="0.01" class="form-control" id="capacity" name="capacity" value="<?php echo e(old('capacity')); ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                    <select class="form-select" id="status" name="status" required>
                        <option value="available" <?php echo e(old('status') === 'available' ? 'selected' : ''); ?>>Available</option>
                        <option value="in-use" <?php echo e(old('status') === 'in-use' ? 'selected' : ''); ?>>In Use</option>
                        <option value="maintenance" <?php echo e(old('status') === 'maintenance' ? 'selected' : ''); ?>>Maintenance</option>
                        <option value="retired" <?php echo e(old('status') === 'retired' ? 'selected' : ''); ?>>Retired</option>
                    </select>
                </div>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">
                     Create Vehicle
                </button>
                <a href="<?php echo e(route('vehicles.index')); ?>" class="btn btn-secondary">
                     Cancel
                </a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/Logistics-Management-System/resources/views/vehicles/create.blade.php ENDPATH**/ ?>