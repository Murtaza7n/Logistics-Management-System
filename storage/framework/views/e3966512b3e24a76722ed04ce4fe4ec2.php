<?php $__env->startSection('title', 'Monthly Payroll Processing'); ?>
<?php $__env->startSection('page-title', 'Monthly Payroll Processing'); ?>

<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">
        
        Monthly Payroll Processing
    </h1>
    <p class="page-subtitle">Process monthly payroll for employees</p>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"> Payroll Processing Parameters</h5>
    </div>
    <div class="card-body">
        <form action="<?php echo e(route('payroll.process-payroll')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="row mb-4">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Month <span class="text-danger">*</span></label>
                    <select class="form-select" name="month" required>
                        <?php for($i = 1; $i <= 12; $i++): ?>
                        <option value="<?php echo e($i); ?>" <?php echo e($i == date('n') ? 'selected' : ''); ?>><?php echo e(date('F', mktime(0, 0, 0, $i, 1))); ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Year <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="year" value="<?php echo e(date('Y')); ?>" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Department (Optional)</label>
                    <select class="form-select" name="department_id">
                        <option value="">All Departments</option>
                        <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($dept->id); ?>"><?php echo e($dept->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>
            <div class="mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="process_all" id="process_all" value="1">
                    <label class="form-check-label" for="process_all">
                        Process payroll for all active employees
                    </label>
                </div>
            </div>
            <div class="alert alert-info">
                 This will calculate salaries, deductions, allowances, and generate payroll records for the selected period.
            </div>
            <button type="submit" class="btn btn-primary">
                 Process Payroll
            </button>
        </form>
    </div>
</div>

<div class="card mt-3">
    <div class="card-header">
        <h5 class="mb-0"> Recent Payroll Records</h5>
    </div>
    <div class="card-body">
        <div class="alert alert-secondary">
             Processed payroll records will appear here. Use the Payroll Records section to view detailed payroll information.
        </div>
        <a href="<?php echo e(route('payrolls.index')); ?>" class="btn btn-secondary">
             View All Payroll Records
        </a>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/Logistics-Management-System/resources/views/payroll/monthly-payroll-processing.blade.php ENDPATH**/ ?>