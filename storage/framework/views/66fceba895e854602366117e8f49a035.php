<?php $__env->startSection('title', 'Employee Details'); ?>
<?php $__env->startSection('page-title', 'Employee Details'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"> Employee Information</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="40%">Employee ID:</th>
                        <td><?php echo e($employee->emp_id); ?></td>
                    </tr>
                    <tr>
                        <th>Name:</th>
                        <td><?php echo e($employee->name); ?></td>
                    </tr>
                    <tr>
                        <th>Role:</th>
                        <td><span class="badge bg-info"><?php echo e(ucfirst($employee->role)); ?></span></td>
                    </tr>
                    <tr>
                        <th>Contact:</th>
                        <td><?php echo e($employee->contact ?? 'N/A'); ?></td>
                    </tr>
                    <tr>
                        <th>Email:</th>
                        <td><?php echo e($employee->email ?? 'N/A'); ?></td>
                    </tr>
                    <tr>
                        <th>Address:</th>
                        <td><?php echo e($employee->address ?? 'N/A'); ?></td>
                    </tr>
                    <tr>
                        <th>Bank Account:</th>
                        <td><?php echo e($employee->bank_account ?? 'N/A'); ?></td>
                    </tr>
                    <tr>
                        <th>Bank Name:</th>
                        <td><?php echo e($employee->bank_name ?? 'N/A'); ?></td>
                    </tr>
                    <tr>
                        <th>Hire Date:</th>
                        <td><?php echo e($employee->hire_date?->format('M d, Y') ?? 'N/A'); ?></td>
                    </tr>
                    <tr>
                        <th>Status:</th>
                        <td><span class="badge bg-<?php echo e($employee->status === 'active' ? 'success' : 'secondary'); ?>"><?php echo e(ucfirst($employee->status)); ?></span></td>
                    </tr>
                </table>
                <div class="mt-3">
                    <a href="<?php echo e(route('employees.edit', $employee)); ?>" class="btn btn-primary">
                         Edit
                    </a>
                    <a href="<?php echo e(route('employees.index')); ?>" class="btn btn-secondary">
                         Back
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"> Payroll History</h5>
            </div>
            <div class="card-body">
                <?php if($employee->payrolls->count() > 0): ?>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Month</th>
                                <th>Net Salary</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $employee->payrolls->take(10); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payroll): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($payroll->month); ?></td>
                                <td>Rs.<?php echo e(number_format($payroll->net_salary, 2)); ?></td>
                                <td><span class="badge bg-<?php echo e($payroll->status === 'paid' ? 'success' : 'warning'); ?>"><?php echo e(ucfirst($payroll->status)); ?></span></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <p class="text-muted">No payroll records found.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/Logistics-Management-System/resources/views/employees/show.blade.php ENDPATH**/ ?>