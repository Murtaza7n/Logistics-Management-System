<?php $__env->startSection('title', 'Payroll Details'); ?>
<?php $__env->startSection('page-title', 'Payroll Details'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"> Payroll Information</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="40%">Payroll ID:</th>
                        <td><?php echo e($payroll->payroll_id); ?></td>
                    </tr>
                    <tr>
                        <th>Employee:</th>
                        <td><?php echo e($payroll->employee->name); ?> (ID: <?php echo e($payroll->employee->emp_id); ?>)</td>
                    </tr>
                    <tr>
                        <th>Month:</th>
                        <td><?php echo e($payroll->month); ?></td>
                    </tr>
                    <tr>
                        <th>Basic Salary:</th>
                        <td>Rs.<?php echo e(number_format($payroll->basic_salary, 2)); ?></td>
                    </tr>
                    <tr>
                        <th>Overtime:</th>
                        <td>Rs.<?php echo e(number_format($payroll->overtime, 2)); ?></td>
                    </tr>
                    <tr>
                        <th>Bonus:</th>
                        <td>Rs.<?php echo e(number_format($payroll->bonus, 2)); ?></td>
                    </tr>
                    <tr>
                        <th>Deductions:</th>
                        <td>Rs.<?php echo e(number_format($payroll->deductions, 2)); ?></td>
                    </tr>
                    <tr>
                        <th>Deduction Details:</th>
                        <td><?php echo e($payroll->deduction_details ?? 'N/A'); ?></td>
                    </tr>
                    <tr>
                        <th><strong>Net Salary:</strong></th>
                        <td><strong>Rs.<?php echo e(number_format($payroll->net_salary, 2)); ?></strong></td>
                    </tr>
                    <tr>
                        <th>Status:</th>
                        <td><span class="badge bg-<?php echo e($payroll->status === 'paid' ? 'success' : ($payroll->status === 'pending' ? 'warning' : 'danger')); ?>"><?php echo e(ucfirst($payroll->status)); ?></span></td>
                    </tr>
                    <tr>
                        <th>Payment Date:</th>
                        <td><?php echo e($payroll->payment_date?->format('M d, Y') ?? 'N/A'); ?></td>
                    </tr>
                    <tr>
                        <th>Notes:</th>
                        <td><?php echo e($payroll->notes ?? 'N/A'); ?></td>
                    </tr>
                </table>
                <div class="mt-3">
                    <a href="<?php echo e(route('payrolls.edit', $payroll)); ?>" class="btn btn-primary">
                         Edit
                    </a>
                    <a href="<?php echo e(route('payrolls.payslip', $payroll)); ?>" class="btn btn-success" target="_blank">
                         Print Payslip
                    </a>
                    <a href="<?php echo e(route('payrolls.index')); ?>" class="btn btn-secondary">
                         Back
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/Logistics-Management-System/resources/views/payrolls/show.blade.php ENDPATH**/ ?>