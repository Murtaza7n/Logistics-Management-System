<?php $__env->startSection('title', 'Shipment Reports'); ?>
<?php $__env->startSection('page-title', 'Shipment Reports'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
        <h5 class="mb-0"> Shipment Reports</h5>
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
                        <option value="booked" <?php echo e(request('status') === 'booked' ? 'selected' : ''); ?>>Booked</option>
                        <option value="delivered" <?php echo e(request('status') === 'delivered' ? 'selected' : ''); ?>>Delivered</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="<?php echo e(route('reports.shipments')); ?>" class="btn btn-secondary">Reset</a>
                </div>
            </div>
        </form>
        
        <div class="row mb-3">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h6>Total Shipments</h6>
                        <h3><?php echo e($summary['total']); ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h6>Total Freight</h6>
                        <h3>Rs.<?php echo e(number_format($summary['total_freight'], 2)); ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <h6>Total Labor</h6>
                        <h3>Rs.<?php echo e(number_format($summary['total_labor'], 2)); ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <h6>Grand Total</h6>
                        <h3>Rs.<?php echo e(number_format($summary['grand_total'], 2)); ?></h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end mb-3">
            <a href="<?php echo e(route('reports.shipments', array_merge(request()->all(), ['export' => 'pdf']))); ?>" class="btn btn-danger">
                 Export PDF
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Shipment #</th>
                        <th>Customer</th>
                        <th>From → To</th>
                        <th>Status</th>
                        <th>Freight</th>
                        <th>Labor</th>
                        <th>Other</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $shipments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shipment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($shipment->shipment_number); ?></td>
                        <td><?php echo e($shipment->customer->name); ?></td>
                        <td><?php echo e($shipment->pickup_city); ?> → <?php echo e($shipment->delivery_city); ?></td>
                        <td><span class="badge bg-<?php echo e($shipment->status === 'delivered' ? 'success' : 'warning'); ?>"><?php echo e(ucfirst(str_replace('-', ' ', $shipment->status))); ?></span></td>
                        <td>Rs.<?php echo e(number_format($shipment->freight_charges, 2)); ?></td>
                        <td>Rs.<?php echo e(number_format($shipment->labor_charges, 2)); ?></td>
                        <td>Rs.<?php echo e(number_format($shipment->other_charges, 2)); ?></td>
                        <td><strong>Rs.<?php echo e(number_format($shipment->total_charges, 2)); ?></strong></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="8" class="text-center">No shipments found</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/Logistics-Management-System/resources/views/reports/shipments.blade.php ENDPATH**/ ?>