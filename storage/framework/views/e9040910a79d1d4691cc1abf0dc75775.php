<?php $__env->startSection('title', 'Payroll'); ?>
<?php $__env->startSection('page-title', 'Payroll Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"> Payroll</h5>
        <a href="<?php echo e(route('payrolls.create')); ?>" class="btn btn-primary btn-sm">
             Add Payroll
        </a>
    </div>
    <div class="card-body">
        <form method="GET" class="mb-3">
            <div class="row g-2">
                <div class="col-md-3">
                    <input type="month" class="form-control" name="month" value="<?php echo e(request('month')); ?>" placeholder="Filter by Month">
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="emp_id">
                        <option value="">All Employees</option>
                        <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($emp->emp_id); ?>" <?php echo e(request('emp_id') == $emp->emp_id ? 'selected' : ''); ?>><?php echo e($emp->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="<?php echo e(route('payrolls.index')); ?>" class="btn btn-secondary">Reset</a>
                </div>
            </div>
        </form>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Payroll ID</th>
                        <th>Employee</th>
                        <th>Month</th>
                        <th>Basic Salary</th>
                        <th>Overtime</th>
                        <th>Deductions</th>
                        <th>Net Salary</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $payrolls; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payroll): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($payroll->payroll_id); ?></td>
                        <td><?php echo e($payroll->employee->name); ?></td>
                        <td><?php echo e($payroll->month); ?></td>
                        <td>Rs.<?php echo e(number_format($payroll->basic_salary, 2)); ?></td>
                        <td>Rs.<?php echo e(number_format($payroll->overtime, 2)); ?></td>
                        <td>Rs.<?php echo e(number_format($payroll->deductions, 2)); ?></td>
                        <td><strong>Rs.<?php echo e(number_format($payroll->net_salary, 2)); ?></strong></td>
                        <td><span class="badge bg-<?php echo e($payroll->status === 'paid' ? 'success' : ($payroll->status === 'pending' ? 'warning' : 'danger')); ?>"><?php echo e(ucfirst($payroll->status)); ?></span></td>
                        <td>
                            <a href="<?php echo e(route('payrolls.show', $payroll)); ?>" class="btn btn-sm btn-outline-info">
                                
                            </a>
                            <a href="<?php echo e(route('payrolls.edit', $payroll)); ?>" class="btn btn-sm btn-outline-primary">
                                
                            </a>
                            <a href="<?php echo e(route('payrolls.payslip', $payroll)); ?>" class="btn btn-sm btn-outline-success" target="_blank">
                                
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="9" class="text-center">No payroll records found</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            <?php echo e($payrolls->links()); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/Logistics-Management-System/resources/views/payrolls/index.blade.php ENDPATH**/ ?>