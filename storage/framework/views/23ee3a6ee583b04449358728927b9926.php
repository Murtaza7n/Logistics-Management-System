<?php $__env->startSection('title', 'List of Pending Invoices'); ?>
<?php $__env->startSection('page-title', 'List of Pending Invoices'); ?>

<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">
        
        List of Pending Invoices
    </h1>
    <p class="page-subtitle">Invoices with outstanding payments</p>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"> Pending Invoices (<?php echo e($invoices->count()); ?> records)</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Invoice #</th>
                        <th>Customer/Vendor</th>
                        <th>Invoice Date</th>
                        <th>Due Date</th>
                        <th>Total Amount</th>
                        <th>Paid Amount</th>
                        <th>Outstanding</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $paid = $invoice->payments()->sum('amount_paid');
                        $outstanding = $invoice->total - $paid;
                    ?>
                    <tr>
                        <td><strong><?php echo e($invoice->invoice_number); ?></strong></td>
                        <td><?php echo e($invoice->customer->name ?? $invoice->vendor->name ?? 'N/A'); ?></td>
                        <td><?php echo e($invoice->invoice_date ? $invoice->invoice_date->format('Y-m-d') : 'N/A'); ?></td>
                        <td><?php echo e($invoice->due_date ? $invoice->due_date->format('Y-m-d') : 'N/A'); ?></td>
                        <td>Rs.<?php echo e(number_format($invoice->total, 2)); ?></td>
                        <td>Rs.<?php echo e(number_format($paid, 2)); ?></td>
                        <td><strong>Rs.<?php echo e(number_format($outstanding, 2)); ?></strong></td>
                        <td>
                            <span class="badge badge-<?php echo e($invoice->status === 'overdue' ? 'dark' : 'secondary'); ?>">
                                <?php echo e(ucfirst($invoice->status)); ?>

                            </span>
                        </td>
                        <td>
                            <a href="<?php echo e(route('invoices.show', $invoice)); ?>" class="btn btn-sm btn-outline-primary">
                                
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="9" class="text-center">No pending invoices found</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/Logistics-Management-System/resources/views/reports/list_of_pending_invoices.blade.php ENDPATH**/ ?>