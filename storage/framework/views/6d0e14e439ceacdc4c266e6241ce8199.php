<?php $__env->startSection('title', 'Invoices'); ?>
<?php $__env->startSection('page-title', 'Invoices Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"> Invoices</h5>
        <a href="<?php echo e(route('invoices.create')); ?>" class="btn btn-primary btn-sm">
             Create Invoice
        </a>
    </div>
    <div class="card-body">
        <form method="GET" class="mb-3">
            <div class="row g-2">
                <div class="col-md-3">
                    <select class="form-select" name="status">
                        <option value="">All Status</option>
                        <option value="draft" <?php echo e(request('status') === 'draft' ? 'selected' : ''); ?>>Draft</option>
                        <option value="sent" <?php echo e(request('status') === 'sent' ? 'selected' : ''); ?>>Sent</option>
                        <option value="paid" <?php echo e(request('status') === 'paid' ? 'selected' : ''); ?>>Paid</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="invoice_type">
                        <option value="">All Types</option>
                        <option value="customer" <?php echo e(request('invoice_type') === 'customer' ? 'selected' : ''); ?>>Customer</option>
                        <option value="vendor" <?php echo e(request('invoice_type') === 'vendor' ? 'selected' : ''); ?>>Vendor</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="<?php echo e(route('invoices.index')); ?>" class="btn btn-secondary">Reset</a>
                </div>
            </div>
        </form>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Invoice #</th>
                        <th>Type</th>
                        <th>Customer/Vendor</th>
                        <th>Date</th>
                        <th>Total</th>
                        <th>Paid</th>
                        <th>Balance</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><a href="<?php echo e(route('invoices.show', $invoice)); ?>"><?php echo e($invoice->invoice_number); ?></a></td>
                        <td><span class="badge bg-<?php echo e($invoice->invoice_type === 'customer' ? 'primary' : 'info'); ?>"><?php echo e(ucfirst($invoice->invoice_type)); ?></span></td>
                        <td><?php echo e($invoice->customer->name ?? $invoice->vendor->name); ?></td>
                        <td><?php echo e($invoice->invoice_date->format('M d, Y')); ?></td>
                        <td>Rs.<?php echo e(number_format($invoice->total, 2)); ?></td>
                        <td>Rs.<?php echo e(number_format($invoice->total_paid, 2)); ?></td>
                        <td>Rs.<?php echo e(number_format($invoice->balance, 2)); ?></td>
                        <td><span class="badge bg-<?php echo e($invoice->status === 'paid' ? 'success' : ($invoice->status === 'overdue' ? 'danger' : 'warning')); ?>"><?php echo e(ucfirst($invoice->status)); ?></span></td>
                        <td>
                            <a href="<?php echo e(route('invoices.show', $invoice)); ?>" class="btn btn-sm btn-outline-info">
                                
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="9" class="text-center">No invoices found</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            <?php echo e($invoices->links()); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/Logistics-Management-System/resources/views/invoices/index.blade.php ENDPATH**/ ?>