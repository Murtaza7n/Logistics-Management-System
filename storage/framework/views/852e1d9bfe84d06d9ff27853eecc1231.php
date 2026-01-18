<?php $__env->startSection('title', 'Payments'); ?>
<?php $__env->startSection('page-title', 'Payments Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"> Payments</h5>
        <a href="<?php echo e(route('payments.create')); ?>" class="btn btn-primary btn-sm">
             Record Payment
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Payment ID</th>
                        <th>Invoice #</th>
                        <th>Amount Paid</th>
                        <th>Payment Date</th>
                        <th>Method</th>
                        <th>Reference</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($payment->payment_id); ?></td>
                        <td><a href="<?php echo e(route('invoices.show', $payment->invoice)); ?>"><?php echo e($payment->invoice->invoice_number); ?></a></td>
                        <td>Rs.<?php echo e(number_format($payment->amount_paid, 2)); ?></td>
                        <td><?php echo e($payment->payment_date->format('M d, Y')); ?></td>
                        <td><span class="badge bg-info"><?php echo e(ucfirst(str_replace('_', ' ', $payment->method))); ?></span></td>
                        <td><?php echo e($payment->reference_number ?? 'N/A'); ?></td>
                        <td>
                            <a href="<?php echo e(route('payments.show', $payment)); ?>" class="btn btn-sm btn-outline-info">
                                
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="text-center">No payments found</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            <?php echo e($payments->links()); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/Logistics-Management-System/resources/views/payments/index.blade.php ENDPATH**/ ?>