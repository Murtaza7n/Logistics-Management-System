<?php $__env->startSection('title', 'List of Invoices'); ?>
<?php $__env->startSection('page-title', 'List of Invoices'); ?>

<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">
        
        List of Invoices
    </h1>
    <p class="page-subtitle">Complete list of all invoices</p>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"> Filters</h5>
    </div>
    <div class="card-body">
        <form method="GET" action="<?php echo e(route('reports.list-of-invoices')); ?>" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    <option value="draft" <?php echo e(request('status') == 'draft' ? 'selected' : ''); ?>>Draft</option>
                    <option value="sent" <?php echo e(request('status') == 'sent' ? 'selected' : ''); ?>>Sent</option>
                    <option value="paid" <?php echo e(request('status') == 'paid' ? 'selected' : ''); ?>>Paid</option>
                    <option value="overdue" <?php echo e(request('status') == 'overdue' ? 'selected' : ''); ?>>Overdue</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">From Date</label>
                <input type="date" name="from_date" class="form-control" value="<?php echo e(request('from_date')); ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label">To Date</label>
                <input type="date" name="to_date" class="form-control" value="<?php echo e(request('to_date')); ?>">
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
        <h5 class="mb-0"> Invoices (<?php echo e($invoices->count()); ?> records)</h5>
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
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><strong><?php echo e($invoice->invoice_number); ?></strong></td>
                        <td><?php echo e($invoice->customer->name ?? $invoice->vendor->name ?? 'N/A'); ?></td>
                        <td><?php echo e($invoice->invoice_date ? $invoice->invoice_date->format('Y-m-d') : 'N/A'); ?></td>
                        <td><?php echo e($invoice->due_date ? $invoice->due_date->format('Y-m-d') : 'N/A'); ?></td>
                        <td>Rs.<?php echo e(number_format($invoice->total, 2)); ?></td>
                        <td>
                            <span class="badge bg-<?php echo e($invoice->status === 'paid' ? 'success' : ($invoice->status === 'overdue' ? 'danger' : 'warning')); ?>">
                                <?php echo e(ucfirst($invoice->status)); ?>

                            </span>
                        </td>
                        <td>
                            <a href="<?php echo e(route('invoices.show', $invoice)); ?>" class="btn btn-sm btn-outline-info">
                                
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="text-center">No invoices found</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/Logistics-Management-System/resources/views/reports/list_of_invoices.blade.php ENDPATH**/ ?>