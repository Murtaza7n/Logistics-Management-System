<?php $__env->startSection('title', 'Group/Party Outstanding with S/Tax'); ?>
<?php $__env->startSection('page-title', 'Group/Party Outstanding with S/Tax'); ?>

<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">
        
        Group/Party Outstanding with S/Tax
    </h1>
    <p class="page-subtitle">Outstanding amounts by customer/party including sales tax</p>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"> Outstanding Parties (<?php echo e($customers->count()); ?> records)</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Party/Customer</th>
                        <th>Contact</th>
                        <th>Total Invoiced</th>
                        <th>Total Paid</th>
                        <th>Outstanding Amount</th>
                        <th>Sales Tax</th>
                        <th>Total Outstanding</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $totalInvoiced = $customer->invoices()->sum('total');
                        $totalPaid = $customer->invoices()->get()->sum(function($inv) {
                            return $inv->payments()->sum('amount_paid');
                        });
                        $outstanding = $totalInvoiced - $totalPaid;
                        $salesTax = $outstanding * 0.15; // Assuming 15% sales tax
                        $totalOutstanding = $outstanding + $salesTax;
                    ?>
                    <tr>
                        <td><strong><?php echo e($customer->name); ?></strong></td>
                        <td><?php echo e($customer->contact ?? 'N/A'); ?></td>
                        <td>Rs.<?php echo e(number_format($totalInvoiced, 2)); ?></td>
                        <td>Rs.<?php echo e(number_format($totalPaid, 2)); ?></td>
                        <td>Rs.<?php echo e(number_format($outstanding, 2)); ?></td>
                        <td>Rs.<?php echo e(number_format($salesTax, 2)); ?></td>
                        <td><strong>Rs.<?php echo e(number_format($totalOutstanding, 2)); ?></strong></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="text-center">No outstanding amounts found</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
                <tfoot>
                    <tr class="table-dark">
                        <th colspan="4">Total Outstanding</th>
                        <th>Rs.<?php echo e(number_format($customers->sum('outstanding'), 2)); ?></th>
                        <th>Rs.<?php echo e(number_format($customers->sum('outstanding') * 0.15, 2)); ?></th>
                        <th>Rs.<?php echo e(number_format($customers->sum('outstanding') * 1.15, 2)); ?></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/Logistics-Management-System/resources/views/reports/group_party_outstanding.blade.php ENDPATH**/ ?>