<?php $__env->startSection('title', 'Customer-wise Report'); ?>
<?php $__env->startSection('page-title', 'Customer-wise Report'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
        <h5 class="mb-0"> Customer-wise Report</h5>
    </div>
    <div class="card-body">
        <form method="GET" class="mb-3">
            <div class="row g-2">
                <div class="col-md-4">
                    <select class="form-select" name="customer_id">
                        <option value="">All Customers</option>
                        <?php $__currentLoopData = $allCustomers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($customer->customer_id); ?>" <?php echo e(request('customer_id') == $customer->customer_id ? 'selected' : ''); ?>><?php echo e($customer->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="<?php echo e(route('reports.customer-wise')); ?>" class="btn btn-secondary">Reset</a>
                </div>
            </div>
        </form>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Customer</th>
                        <th>Total Shipments</th>
                        <th>Total Revenue</th>
                        <th>Pending Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($customer->name); ?></td>
                        <td><?php echo e($customer->total_shipments); ?></td>
                        <td>Rs.<?php echo e(number_format($customer->total_revenue, 2)); ?></td>
                        <td>Rs.<?php echo e(number_format($customer->pending_amount, 2)); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="4" class="text-center">No customers found</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/Logistics-Management-System/resources/views/reports/customer_wise.blade.php ENDPATH**/ ?>