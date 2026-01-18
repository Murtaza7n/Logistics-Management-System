<?php $__env->startSection('title', 'Delivery CN Detail Report'); ?>
<?php $__env->startSection('page-title', 'Delivery CN Detail Report'); ?>

<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">
        
        Delivery CN Detail Report
    </h1>
    <p class="page-subtitle">Detailed report of delivered and out-for-delivery consignment notes</p>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"> Filters</h5>
    </div>
    <div class="card-body">
        <form method="GET" action="<?php echo e(route('reports.delivery-cn-detail')); ?>" class="row g-3">
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
        <h5 class="mb-0"> Delivery CN Details (<?php echo e($shipments->count()); ?> records)</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>C/N No.</th>
                        <th>Shipper</th>
                        <th>Consignee</th>
                        <th>Vehicle</th>
                        <th>Driver</th>
                        <th>Expected Delivery</th>
                        <th>Actual Delivery</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $shipments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shipment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><strong><?php echo e($shipment->shipment_number); ?></strong></td>
                        <td><?php echo e($shipment->shipper_name ?? 'N/A'); ?></td>
                        <td><?php echo e($shipment->consignee_name ?? 'N/A'); ?></td>
                        <td><?php echo e($shipment->vehicle->registration_no ?? 'N/A'); ?></td>
                        <td><?php echo e($shipment->driver->name ?? 'N/A'); ?></td>
                        <td><?php echo e($shipment->delivery_date ? $shipment->delivery_date->format('Y-m-d') : 'N/A'); ?></td>
                        <td><?php echo e($shipment->actual_delivery_date ? $shipment->actual_delivery_date->format('Y-m-d') : 'N/A'); ?></td>
                        <td>
                            <span class="badge badge-<?php echo e($shipment->status === 'delivered' ? 'primary' : 'secondary'); ?>">
                                <?php echo e(ucfirst(str_replace('-', ' ', $shipment->status))); ?>

                            </span>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="8" class="text-center">No records found</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/Logistics-Management-System/resources/views/reports/delivery_cn_detail.blade.php ENDPATH**/ ?>