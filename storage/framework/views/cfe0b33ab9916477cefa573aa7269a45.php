<?php $__env->startSection('title', 'Department-wise Monthly Payroll Register'); ?>
<?php $__env->startSection('page-title', 'Department-wise Monthly Payroll Register'); ?>

<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">
        
        Department-wise Monthly Payroll Register
    </h1>
    <p class="page-subtitle">Monthly payroll breakdown by department</p>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"> Filters</h5>
    </div>
    <div class="card-body">
        <form method="GET" action="<?php echo e(route('reports.department-wise-monthly-payroll-register')); ?>" class="row g-3">
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
                <label class="form-label">Department</label>
                <select name="department_id" class="form-select">
                    <option value="">All Departments</option>
                    <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($dept->id); ?>" <?php echo e(request('department_id') == $dept->id ? 'selected' : ''); ?>><?php echo e($dept->name); ?></option>
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

<?php $__currentLoopData = $departmentWise; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deptData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="card mt-3">
    <div class="card-header">
        <h5 class="mb-0">
             
            <?php echo e($deptData['department']->name ?? 'No Department'); ?>

            <span class="badge badge-secondary ms-2"><?php echo e($deptData['total_employees']); ?> employees</span>
        </h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Basic Salary</th>
                        <th>Overtime</th>
                        <th>Bonus</th>
                        <th>Deductions</th>
                        <th>Net Salary</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $deptData['payrolls']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payroll): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><strong><?php echo e($payroll->employee->name ?? 'N/A'); ?></strong></td>
                        <td>Rs.<?php echo e(number_format($payroll->basic_salary, 2)); ?></td>
                        <td>Rs.<?php echo e(number_format($payroll->overtime, 2)); ?></td>
                        <td>Rs.<?php echo e(number_format($payroll->bonus, 2)); ?></td>
                        <td>Rs.<?php echo e(number_format($payroll->deductions, 2)); ?></td>
                        <td><strong>Rs.<?php echo e(number_format($payroll->net_salary, 2)); ?></strong></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
                <tfoot>
                    <tr class="table-dark">
                        <th>Department Total</th>
                        <th>Rs.<?php echo e(number_format($deptData['payrolls']->sum('basic_salary'), 2)); ?></th>
                        <th>Rs.<?php echo e(number_format($deptData['payrolls']->sum('overtime'), 2)); ?></th>
                        <th>Rs.<?php echo e(number_format($deptData['payrolls']->sum('bonus'), 2)); ?></th>
                        <th>Rs.<?php echo e(number_format($deptData['payrolls']->sum('deductions'), 2)); ?></th>
                        <th><strong>Rs.<?php echo e(number_format($deptData['total_net_salary'], 2)); ?></strong></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php if($departmentWise->isEmpty()): ?>
<div class="card mt-3">
    <div class="card-body">
        <div class="alert alert-info">
             No payroll records found for the selected criteria.
        </div>
    </div>
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/Logistics-Management-System/resources/views/reports/department_wise_monthly_payroll_register.blade.php ENDPATH**/ ?>