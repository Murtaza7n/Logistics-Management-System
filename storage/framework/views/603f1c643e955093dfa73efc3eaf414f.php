<?php $__env->startSection('title', 'Create Employee'); ?>
<?php $__env->startSection('page-title', 'Create Employee'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
        <h5 class="mb-0"> Create New Employee</h5>
    </div>
    <div class="card-body">
        <form action="<?php echo e(route('employees.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo e(old('name')); ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="role" class="form-label">Role <span class="text-danger">*</span></label>
                    <select class="form-select" id="role" name="role" required>
                        <option value="admin" <?php echo e(old('role') === 'admin' ? 'selected' : ''); ?>>Admin</option>
                        <option value="staff" <?php echo e(old('role') === 'staff' ? 'selected' : ''); ?>>Staff</option>
                        <option value="driver" <?php echo e(old('role') === 'driver' ? 'selected' : ''); ?>>Driver</option>
                        <option value="manager" <?php echo e(old('role') === 'manager' ? 'selected' : ''); ?>>Manager</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="contact" class="form-label">Contact</label>
                    <input type="text" class="form-control" id="contact" name="contact" value="<?php echo e(old('contact')); ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo e(old('email')); ?>">
                </div>
                <div class="col-md-12 mb-3">
                    <label for="address" class="form-label">Address</label>
                    <textarea class="form-control" id="address" name="address" rows="2"><?php echo e(old('address')); ?></textarea>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="bank_account" class="form-label">Bank Account</label>
                    <input type="text" class="form-control" id="bank_account" name="bank_account" value="<?php echo e(old('bank_account')); ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="bank_name" class="form-label">Bank Name</label>
                    <input type="text" class="form-control" id="bank_name" name="bank_name" value="<?php echo e(old('bank_name')); ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="hire_date" class="form-label">Hire Date</label>
                    <input type="date" class="form-control" id="hire_date" name="hire_date" value="<?php echo e(old('hire_date')); ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                    <select class="form-select" id="status" name="status" required>
                        <option value="active" <?php echo e(old('status') === 'active' ? 'selected' : ''); ?>>Active</option>
                        <option value="inactive" <?php echo e(old('status') === 'inactive' ? 'selected' : ''); ?>>Inactive</option>
                    </select>
                </div>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">
                     Create Employee
                </button>
                <a href="<?php echo e(route('employees.index')); ?>" class="btn btn-secondary">
                     Cancel
                </a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/Logistics-Management-System/resources/views/employees/create.blade.php ENDPATH**/ ?>