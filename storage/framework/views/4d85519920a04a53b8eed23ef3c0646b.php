<?php $__env->startSection('title', 'Edit Customer'); ?>
<?php $__env->startSection('page-title', 'Edit Customer'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
        <h5 class="mb-0"> Edit Customer</h5>
    </div>
    <div class="card-body">
        <form action="<?php echo e(route('customers.update', $customer)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo e(old('name', $customer->name)); ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="contact" class="form-label">Contact</label>
                    <input type="text" class="form-control" id="contact" name="contact" value="<?php echo e(old('contact', $customer->contact)); ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo e(old('email', $customer->email)); ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="tax_id" class="form-label">Tax ID</label>
                    <input type="text" class="form-control" id="tax_id" name="tax_id" value="<?php echo e(old('tax_id', $customer->tax_id)); ?>">
                </div>
                <div class="col-md-12 mb-3">
                    <label for="address" class="form-label">Address</label>
                    <textarea class="form-control" id="address" name="address" rows="2"><?php echo e(old('address', $customer->address)); ?></textarea>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="city" class="form-label">City</label>
                    <input type="text" class="form-control" id="city" name="city" value="<?php echo e(old('city', $customer->city)); ?>">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="state" class="form-label">State</label>
                    <input type="text" class="form-control" id="state" name="state" value="<?php echo e(old('state', $customer->state)); ?>">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="country" class="form-label">Country</label>
                    <input type="text" class="form-control" id="country" name="country" value="<?php echo e(old('country', $customer->country)); ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                    <select class="form-select" id="status" name="status" required>
                        <option value="active" <?php echo e(old('status', $customer->status) === 'active' ? 'selected' : ''); ?>>Active</option>
                        <option value="inactive" <?php echo e(old('status', $customer->status) === 'inactive' ? 'selected' : ''); ?>>Inactive</option>
                    </select>
                </div>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">
                     Update Customer
                </button>
                <a href="<?php echo e(route('customers.index')); ?>" class="btn btn-secondary">
                     Cancel
                </a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/Logistics-Management-System/resources/views/customers/edit.blade.php ENDPATH**/ ?>