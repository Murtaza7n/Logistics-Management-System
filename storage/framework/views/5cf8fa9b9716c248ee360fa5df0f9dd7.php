<?php $__env->startSection('title', 'Bookings'); ?>
<?php $__env->startSection('page-title', 'Bookings Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <h1 class="page-title">Bookings</h1>
            <p class="page-subtitle">View and manage all booking entries</p>
        </div>
        <div class="d-flex flex-wrap gap-2 mt-2 mt-md-0">
            <a href="<?php echo e(route('bookings.create')); ?>" class="btn btn-primary">
                New Booking
            </a>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">All Bookings</h5>
    </div>
    <div class="card-body">
        <form method="GET" class="mb-3">
            <div class="row g-2">
                <div class="col-md-2">
                    <input type="text" class="form-control" name="booking_number" value="<?php echo e(request('booking_number')); ?>" placeholder="Booking Number">
                </div>
                <div class="col-md-2">
                    <select class="form-select" name="status">
                        <option value="">All Status</option>
                        <option value="pending" <?php echo e(request('status') === 'pending' ? 'selected' : ''); ?>>Pending</option>
                        <option value="confirmed" <?php echo e(request('status') === 'confirmed' ? 'selected' : ''); ?>>Confirmed</option>
                        <option value="cancelled" <?php echo e(request('status') === 'cancelled' ? 'selected' : ''); ?>>Cancelled</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-select" name="pickup_city">
                        <option value="">All Pickup Cities</option>
                        <?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($city->name); ?>" <?php echo e(request('pickup_city') == $city->name ? 'selected' : ''); ?>><?php echo e($city->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-select" name="delivery_city">
                        <option value="">All Delivery Cities</option>
                        <?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($city->name); ?>" <?php echo e(request('delivery_city') == $city->name ? 'selected' : ''); ?>><?php echo e($city->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="date" class="form-control" name="date_from" value="<?php echo e(request('date_from')); ?>" placeholder="From Date">
                </div>
                <div class="col-md-2">
                    <input type="date" class="form-control" name="date_to" value="<?php echo e(request('date_to')); ?>" placeholder="To Date">
                </div>
                <div class="col-md-12 mt-2">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="<?php echo e(route('bookings.index')); ?>" class="btn btn-secondary">Reset</a>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Booking No.</th>
                        <th>Date</th>
                        <th>Shipper</th>
                        <th>Consignee</th>
                        <th>Pickup City</th>
                        <th>Delivery City</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($booking->booking_number); ?></td>
                        <td><?php echo e($booking->booking_date->format('Y-m-d')); ?></td>
                        <td><?php echo e($booking->shipper_name); ?></td>
                        <td><?php echo e($booking->consignee_name); ?></td>
                        <td><?php echo e($booking->pickup_city); ?></td>
                        <td><?php echo e($booking->delivery_city); ?></td>
                        <td>
                            <span class="badge bg-<?php echo e($booking->status === 'confirmed' ? 'success' : ($booking->status === 'cancelled' ? 'danger' : 'warning')); ?>">
                                <?php echo e(ucfirst($booking->status)); ?>

                            </span>
                        </td>
                        <td>
                            <a href="<?php echo e(route('bookings.show', $booking)); ?>" class="btn btn-sm btn-outline-info" title="View">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="<?php echo e(route('bookings.edit', $booking)); ?>" class="btn btn-sm btn-outline-primary" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="<?php echo e(route('bookings.destroy', $booking)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this booking?')">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="8" class="text-center">No bookings found</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            <?php echo e($bookings->links()); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/Logistics-Management-System/resources/views/bookings/index.blade.php ENDPATH**/ ?>