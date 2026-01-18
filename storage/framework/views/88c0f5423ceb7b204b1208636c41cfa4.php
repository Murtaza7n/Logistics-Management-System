<?php $__env->startSection('title', 'Payroll Processing - Final'); ?>
<?php $__env->startSection('page-title', 'Payroll Processing - (FINAL)'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <h1 class="page-title">
        <i class="bi bi-cash-coin"></i> Payroll Processing - (FINAL)
    </h1>
    <p class="page-subtitle">Final payroll processing and posting</p>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Final Payroll Processing</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="<?php echo e(route('system.process-payroll-final')); ?>" onsubmit="return confirm('Are you sure you want to process final payroll? This will post all payroll records.');">
            <?php echo csrf_field(); ?>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="payroll_month" class="form-label">Payroll Month</label>
                        <input type="month" class="form-control <?php $__errorArgs = ['payroll_month'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               id="payroll_month" name="payroll_month" 
                               value="<?php echo e(date('Y-m')); ?>" required>
                        <?php $__errorArgs = ['payroll_month'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Department (Optional)</label>
                        <select class="form-select" name="department_id">
                            <option value="">All Departments</option>
                            <!-- Add departments dynamically -->
                        </select>
                    </div>
                </div>
            </div>
            <div class="alert alert-warning">
                <i class="bi bi-exclamation-triangle"></i> <strong>Final Processing:</strong> This will finalize and post all payroll records for the selected month. This action cannot be reversed.
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-circle"></i> Process Final Payroll
            </button>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/Logistics-Management-System/resources/views/system/payroll-processing-final.blade.php ENDPATH**/ ?>