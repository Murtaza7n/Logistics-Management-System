<?php $__env->startSection('title', 'Edit Payroll'); ?>
<?php $__env->startSection('page-title', 'Edit Payroll'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
        <h5 class="mb-0"> Edit Payroll</h5>
    </div>
    <div class="card-body">
        <form action="<?php echo e(route('payrolls.update', $payroll)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="emp_id" class="form-label">Employee <span class="text-danger">*</span></label>
                    <select class="form-select" id="emp_id" name="emp_id" required>
                        <option value="">Select Employee</option>
                        <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($emp->emp_id); ?>" <?php echo e(old('emp_id', $payroll->emp_id) == $emp->emp_id ? 'selected' : ''); ?>><?php echo e($emp->name); ?> (ID: <?php echo e($emp->emp_id); ?>)</option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="month" class="form-label">Month <span class="text-danger">*</span></label>
                    <input type="month" class="form-control" id="month" name="month" value="<?php echo e(old('month', $payroll->month)); ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="basic_salary" class="form-label">Basic Salary <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" class="form-control" id="basic_salary" name="basic_salary" value="<?php echo e(old('basic_salary', $payroll->basic_salary)); ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="overtime" class="form-label">Overtime</label>
                    <input type="number" step="0.01" class="form-control" id="overtime" name="overtime" value="<?php echo e(old('overtime', $payroll->overtime)); ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="bonus" class="form-label">Bonus</label>
                    <input type="number" step="0.01" class="form-control" id="bonus" name="bonus" value="<?php echo e(old('bonus', $payroll->bonus)); ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="deductions" class="form-label">Deductions</label>
                    <input type="number" step="0.01" class="form-control" id="deductions" name="deductions" value="<?php echo e(old('deductions', $payroll->deductions)); ?>">
                </div>
                <div class="col-md-12 mb-3">
                    <label for="deduction_details" class="form-label">Deduction Details</label>
                    <textarea class="form-control" id="deduction_details" name="deduction_details" rows="2"><?php echo e(old('deduction_details', $payroll->deduction_details)); ?></textarea>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                    <select class="form-select" id="status" name="status" required>
                        <option value="pending" <?php echo e(old('status', $payroll->status) === 'pending' ? 'selected' : ''); ?>>Pending</option>
                        <option value="paid" <?php echo e(old('status', $payroll->status) === 'paid' ? 'selected' : ''); ?>>Paid</option>
                        <option value="cancelled" <?php echo e(old('status', $payroll->status) === 'cancelled' ? 'selected' : ''); ?>>Cancelled</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="payment_date" class="form-label">Payment Date</label>
                    <input type="date" class="form-control" id="payment_date" name="payment_date" value="<?php echo e(old('payment_date', $payroll->payment_date?->format('Y-m-d'))); ?>">
                </div>
                <div class="col-md-12 mb-3">
                    <label for="notes" class="form-label">Notes</label>
                    <textarea class="form-control" id="notes" name="notes" rows="2"><?php echo e(old('notes', $payroll->notes)); ?></textarea>
                </div>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">
                     Update Payroll
                </button>
                <a href="<?php echo e(route('payrolls.index')); ?>" class="btn btn-secondary">
                     Cancel
                </a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/Logistics-Management-System/resources/views/payrolls/edit.blade.php ENDPATH**/ ?>