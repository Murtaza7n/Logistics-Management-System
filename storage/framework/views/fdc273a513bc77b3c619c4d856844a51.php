<?php $__env->startSection('title', 'Shipments'); ?>
<?php $__env->startSection('page-title', 'Shipments Management'); ?>

<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <h1 class="page-title">
                CN Entries Management
            </h1>
            <p class="page-subtitle">View and manage all consignment note entries</p>
        </div>
        <div class="d-flex flex-wrap gap-2 mt-2 mt-md-0">
            <a href="<?php echo e(route('shipments.detail-search')); ?>" class="btn btn-info">
                Detail Search
            </a>
            <a href="<?php echo e(route('shipments.create')); ?>" class="btn btn-primary">
                New CN Entry
            </a>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">All CN Entries</h5>
    </div>
    <div class="card-body">
        <form method="GET" class="mb-3">
            <div class="row g-2">
                <div class="col-md-3">
                    <input type="text" class="form-control" name="shipment_number" value="<?php echo e(request('shipment_number')); ?>" placeholder="CN / Shipment Number">
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="status">
                        <option value="">All Status</option>
                        <option value="booked" <?php echo e(request('status') === 'booked' ? 'selected' : ''); ?>>Booked</option>
                        <option value="picked-up" <?php echo e(request('status') === 'picked-up' ? 'selected' : ''); ?>>Picked Up</option>
                        <option value="in-transit" <?php echo e(request('status') === 'in-transit' ? 'selected' : ''); ?>>In Transit</option>
                        <option value="delivered" <?php echo e(request('status') === 'delivered' ? 'selected' : ''); ?>>Delivered</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="customer_id">
                        <option value="">All Customers</option>
                        <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($customer->customer_id); ?>" <?php echo e(request('customer_id') == $customer->customer_id ? 'selected' : ''); ?>><?php echo e($customer->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="<?php echo e(route('shipments.index')); ?>" class="btn btn-secondary">Reset</a>
                </div>
            </div>
        </form>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>CN / Shipment #</th>
                        <th>Customer</th>
                        <th>From → To</th>
                        <th>Cargo Type</th>
                        <th>Vehicle</th>
                        <th>Driver</th>
                        <th>Total Charges</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $shipments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shipment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><a href="<?php echo e(route('shipments.show', $shipment)); ?>"><?php echo e($shipment->shipment_number); ?></a></td>
                        <td><?php echo e($shipment->customer->name); ?></td>
                        <td><?php echo e($shipment->pickup_city); ?> → <?php echo e($shipment->delivery_city); ?></td>
                        <td><?php echo e($shipment->cargo_type); ?></td>
                        <td><?php echo e($shipment->vehicle->registration_no ?? 'N/A'); ?></td>
                        <td><?php echo e($shipment->driver->name ?? 'N/A'); ?></td>
                        <td>Rs.<?php echo e(number_format($shipment->total_charges, 2)); ?></td>
                        <td><span class="badge bg-<?php echo e($shipment->status === 'delivered' ? 'success' : ($shipment->status === 'cancelled' ? 'danger' : 'warning')); ?>"><?php echo e(ucfirst(str_replace('-', ' ', $shipment->status))); ?></span></td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="<?php echo e(route('shipments.show', $shipment)); ?>" class="btn btn-sm btn-outline-info" title="View">
                                    View
                                </a>
                                <a href="<?php echo e(route('shipments.edit', $shipment)); ?>" class="btn btn-sm btn-outline-primary" title="Edit">
                                    Edit
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="9" class="text-center">No shipments found</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            <?php echo e($shipments->links()); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/Logistics-Management-System/resources/views/shipments/index.blade.php ENDPATH**/ ?>