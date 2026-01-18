<?php $__env->startSection('title', 'List of Monthly Deduction/Allowances'); ?>
<?php $__env->startSection('page-title', 'List of Monthly Deduction/Allowances'); ?>

<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">
        
        List of Monthly Deduction/Allowances
    </h1>
    <p class="page-subtitle">Monthly deductions and allowances report</p>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"> Filters</h5>
    </div>
    <div class="card-body">
        <form method="GET" action="<?php echo e(route('reports.list-of-monthly-deduction-allowances')); ?>" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Month</label>
                <select name="month" class="form-select">
                    <option value="">All Months</option>
                    <?php for($i = 1; $i <= 12; $i++): ?>
                    <option value="<?php echo e($i); ?>" <?php echo e(request('month') == $i ? 'selected' : ''); ?>><?php echo e(date('F', mktime(0, 0, 0, $i, 1))); ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Year</label>
                <input type="number" class="form-control" name="year" value="<?php echo e(request('year', date('Y'))); ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label">Employee</label>
                <select name="employee_id" class="form-select">
                    <option value="">All Employees</option>
                    <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($employee->emp_id); ?>" <?php echo e(request('employee_id') == $employee->emp_id ? 'selected' : ''); ?>><?php echo e($employee->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">&nbsp;</label>
                <div>
                    <button type="submit" class="btn btn-primary w-100">
                         Filter
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"> Monthly Deductions/Allowances (<?php echo e($deductionsAllowances->count()); ?> records)</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Month/Year</th>
                        <th>Deduction Type</th>
                        <th>Deduction Amount</th>
                        <th>Allowance Type</th>
                        <th>Allowance Amount</th>
                        <th>Net Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $deductionsAllowances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $netAmount = $item->allowance_amount - $item->deduction_amount;
                    ?>
                    <tr>
                        <td><strong><?php echo e($item->employee->name ?? 'N/A'); ?></strong></td>
                        <td><?php echo e(date('F', mktime(0, 0, 0, $item->month, 1))); ?> <?php echo e($item->year); ?></td>
                        <td><?php echo e($item->deduction_type ?? 'N/A'); ?></td>
                        <td>Rs.<?php echo e(number_format($item->deduction_amount, 2)); ?></td>
                        <td><?php echo e($item->allowance_type ?? 'N/A'); ?></td>
                        <td>Rs.<?php echo e(number_format($item->allowance_amount, 2)); ?></td>
                        <td>
                            <span class="badge badge-<?php echo e($netAmount >= 0 ? 'primary' : 'dark'); ?>">
                                Rs.<?php echo e(number_format($netAmount, 2)); ?>

                            </span>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="text-center">No records found</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/Logistics-Management-System/resources/views/reports/list_of_monthly_deduction_allowances.blade.php ENDPATH**/ ?>