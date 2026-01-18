<?php $__env->startSection('title', 'C/Ns Detail Report'); ?>
<?php $__env->startSection('page-title', 'C/Ns Detail Report'); ?>

<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">
        
        C/Ns Detail Report
    </h1>
    <p class="page-subtitle">Comprehensive detail report of all consignment notes</p>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"> Filters</h5>
    </div>
    <div class="card-body">
        <form method="GET" action="<?php echo e(route('reports.cn-detail')); ?>" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">From Date</label>
                <input type="date" name="from_date" class="form-control" value="<?php echo e(request('from_date')); ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label">To Date</label>
                <input type="date" name="to_date" class="form-control" value="<?php echo e(request('to_date')); ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    <option value="booked" <?php echo e(request('status') == 'booked' ? 'selected' : ''); ?>>Booked</option>
                    <option value="picked-up" <?php echo e(request('status') == 'picked-up' ? 'selected' : ''); ?>>Picked Up</option>
                    <option value="in-transit" <?php echo e(request('status') == 'in-transit' ? 'selected' : ''); ?>>In Transit</option>
                    <option value="out-for-delivery" <?php echo e(request('status') == 'out-for-delivery' ? 'selected' : ''); ?>>Out for Delivery</option>
                    <option value="delivered" <?php echo e(request('status') == 'delivered' ? 'selected' : ''); ?>>Delivered</option>
                    <option value="cancelled" <?php echo e(request('status') == 'cancelled' ? 'selected' : ''); ?>>Cancelled</option>
                </select>
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
        <h5 class="mb-0"> C/N Details (<?php echo e($shipments->count()); ?> records)</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>C/N No.</th>
                        <th>Entry City</th>
                        <th>Shipper</th>
                        <th>Consignee</th>
                        <th>Route</th>
                        <th>Vehicle</th>
                        <th>Driver</th>
                        <th>Status</th>
                        <th>Total Charges</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $shipments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shipment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><strong><?php echo e($shipment->shipment_number); ?></strong></td>
                        <td><?php echo e($shipment->entryCity->name ?? 'N/A'); ?></td>
                        <td><?php echo e($shipment->shipper_name ?? 'N/A'); ?></td>
                        <td><?php echo e($shipment->consignee_name ?? 'N/A'); ?></td>
                        <td><?php echo e($shipment->pickup_city); ?> → <?php echo e($shipment->delivery_city); ?></td>
                        <td><?php echo e($shipment->vehicle->registration_no ?? 'N/A'); ?></td>
                        <td><?php echo e($shipment->driver->name ?? 'N/A'); ?></td>
                        <td>
                            <span class="badge bg-<?php echo e($shipment->status === 'delivered' ? 'success' : ($shipment->status === 'cancelled' ? 'danger' : 'warning')); ?>">
                                <?php echo e(ucfirst(str_replace('-', ' ', $shipment->status))); ?>

                            </span>
                        </td>
                        <td>Rs.<?php echo e(number_format($shipment->freight_charges + $shipment->labor_charges + $shipment->other_charges, 2)); ?></td>
                        <td><?php echo e($shipment->created_at->format('Y-m-d')); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="10" class="text-center">No records found</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/Logistics-Management-System/resources/views/reports/cn_detail.blade.php ENDPATH**/ ?>