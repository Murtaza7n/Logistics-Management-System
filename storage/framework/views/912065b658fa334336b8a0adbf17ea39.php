<?php $__env->startSection('title', 'Shipper-wise Profit Loss Report'); ?>
<?php $__env->startSection('page-title', 'Shipper-wise Profit Loss Report'); ?>

<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">
        
        Shipper-wise Profit Loss Report
    </h1>
    <p class="page-subtitle">Profit and loss breakdown by shipper</p>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"> Filters</h5>
    </div>
    <div class="card-body">
        <form method="GET" action="<?php echo e(route('reports.shipper-wise-profit-loss')); ?>" class="row g-3">
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
        <h5 class="mb-0"> Shipper-wise Summary</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Shipper</th>
                        <th>Total CNs</th>
                        <th>Total Revenue</th>
                        <th>Average per CN</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $shipperWise; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shipperData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><strong><?php echo e($shipperData['shipper']); ?></strong></td>
                        <td><?php echo e($shipperData['count']); ?></td>
                        <td>Rs.<?php echo e(number_format($shipperData['revenue'], 2)); ?></td>
                        <td>Rs.<?php echo e($shipperData['count'] > 0 ? number_format($shipperData['revenue'] / $shipperData['count'], 2) : '0.00'); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="4" class="text-center">No records found</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/Logistics-Management-System/resources/views/reports/shipper_wise_profit_loss.blade.php ENDPATH**/ ?>