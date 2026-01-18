<?php $__env->startSection('title', 'C/N Profit Loss Report'); ?>
<?php $__env->startSection('page-title', 'C/N Profit Loss Report'); ?>

<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">
        
        C/N Profit Loss Report
    </h1>
    <p class="page-subtitle">Profit and loss analysis for consignment notes</p>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"> Filters</h5>
    </div>
    <div class="card-body">
        <form method="GET" action="<?php echo e(route('reports.cn-profit-loss')); ?>" class="row g-3">
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

<!-- Summary Cards -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="stat-card">
            <h3><?php echo e($summary['total_cns']); ?></h3>
            <p> Total CNs</p>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="stat-card stat-card-silver">
            <h3>Rs.<?php echo e(number_format($summary['total_revenue'], 2)); ?></h3>
            <p> Total Revenue</p>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="stat-card stat-card-dark">
            <h3>Rs.<?php echo e(number_format($summary['total_cost'], 2)); ?></h3>
            <p> Total Cost</p>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="stat-card stat-card-silver">
            <h3>Rs.<?php echo e(number_format($summary['total_profit'], 2)); ?></h3>
            <p> Total Profit</p>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"> C/N Profit Loss Details</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>C/N No.</th>
                        <th>Shipper</th>
                        <th>Consignee</th>
                        <th>Revenue</th>
                        <th>Cost</th>
                        <th>Profit</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $shipments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shipment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $revenue = $shipment->freight_charges + $shipment->labor_charges + $shipment->other_charges;
                        $cost = 0; // Can be calculated based on vehicle/driver costs
                        $profit = $revenue - $cost;
                    ?>
                    <tr>
                        <td><strong><?php echo e($shipment->shipment_number); ?></strong></td>
                        <td><?php echo e($shipment->shipper_name ?? 'N/A'); ?></td>
                        <td><?php echo e($shipment->consignee_name ?? 'N/A'); ?></td>
                        <td>Rs.<?php echo e(number_format($revenue, 2)); ?></td>
                        <td>Rs.<?php echo e(number_format($cost, 2)); ?></td>
                        <td>
                            <span class="badge badge-<?php echo e($profit >= 0 ? 'primary' : 'dark'); ?>">
                                Rs.<?php echo e(number_format($profit, 2)); ?>

                            </span>
                        </td>
                        <td><?php echo e($shipment->created_at->format('Y-m-d')); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="text-center">No records found</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/Logistics-Management-System/resources/views/reports/cn_profit_loss.blade.php ENDPATH**/ ?>