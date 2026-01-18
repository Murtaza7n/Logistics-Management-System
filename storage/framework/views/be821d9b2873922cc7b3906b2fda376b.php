<?php $__env->startSection('title', 'Revenue Reports'); ?>
<?php $__env->startSection('page-title', 'Revenue Reports'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
        <h5 class="mb-0"> Revenue Reports</h5>
    </div>
    <div class="card-body">
        <form method="GET" class="mb-3">
            <div class="row g-2">
                <div class="col-md-3">
                    <input type="date" class="form-control" name="from_date" value="<?php echo e(request('from_date')); ?>" placeholder="From Date">
                </div>
                <div class="col-md-3">
                    <input type="date" class="form-control" name="to_date" value="<?php echo e(request('to_date')); ?>" placeholder="To Date">
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="status">
                        <option value="">All Status</option>
                        <option value="paid" <?php echo e(request('status') === 'paid' ? 'selected' : ''); ?>>Paid</option>
                        <option value="pending" <?php echo e(request('status') === 'pending' ? 'selected' : ''); ?>>Pending</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="<?php echo e(route('reports.revenue')); ?>" class="btn btn-secondary">Reset</a>
                </div>
            </div>
        </form>
        
        <div class="row mb-3">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h6>Total Invoices</h6>
                        <h3><?php echo e($summary['total_invoices']); ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h6>Total Amount</h6>
                        <h3>Rs.<?php echo e(number_format($summary['total_amount'], 2)); ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <h6>Total Paid</h6>
                        <h3>Rs.<?php echo e(number_format($summary['total_paid'], 2)); ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <h6>Pending</h6>
                        <h3>Rs.<?php echo e(number_format($summary['total_pending'], 2)); ?></h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end mb-3">
            <a href="<?php echo e(route('reports.revenue', array_merge(request()->all(), ['export' => 'pdf']))); ?>" class="btn btn-danger">
                 Export PDF
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Invoice #</th>
                        <th>Type</th>
                        <th>Customer/Vendor</th>
                        <th>Date</th>
                        <th>Subtotal</th>
                        <th>Tax</th>
                        <th>Total</th>
                        <th>Paid</th>
                        <th>Balance</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($invoice->invoice_number); ?></td>
                        <td><span class="badge bg-<?php echo e($invoice->invoice_type === 'customer' ? 'primary' : 'info'); ?>"><?php echo e(ucfirst($invoice->invoice_type)); ?></span></td>
                        <td><?php echo e($invoice->customer->name ?? $invoice->vendor->name); ?></td>
                        <td><?php echo e($invoice->invoice_date->format('M d, Y')); ?></td>
                        <td>Rs.<?php echo e(number_format($invoice->subtotal, 2)); ?></td>
                        <td>Rs.<?php echo e(number_format($invoice->tax_amount, 2)); ?></td>
                        <td><strong>Rs.<?php echo e(number_format($invoice->total, 2)); ?></strong></td>
                        <td>Rs.<?php echo e(number_format($invoice->total_paid, 2)); ?></td>
                        <td>Rs.<?php echo e(number_format($invoice->balance, 2)); ?></td>
                        <td><span class="badge bg-<?php echo e($invoice->status === 'paid' ? 'success' : ($invoice->status === 'overdue' ? 'danger' : 'warning')); ?>"><?php echo e(ucfirst($invoice->status)); ?></span></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="10" class="text-center">No invoices found</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/Logistics-Management-System/resources/views/reports/revenue.blade.php ENDPATH**/ ?>