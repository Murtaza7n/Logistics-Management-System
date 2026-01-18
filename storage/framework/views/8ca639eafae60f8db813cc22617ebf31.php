<?php $__env->startSection('title', 'Detail Search - CN Entries'); ?>
<?php $__env->startSection('page-title', 'Detail Search - CN Entries'); ?>

<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">
        
        Detail Search - CN Entries
    </h1>
    <p class="page-subtitle">Search and filter consignment notes with advanced criteria</p>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"> Search Filters</h5>
    </div>
    <div class="card-body">
        <form method="GET" action="<?php echo e(route('shipments.detail-search')); ?>" id="searchForm">
            <div class="row mb-4">
                <div class="col-md-3 mb-3">
                    <label for="cn_number" class="form-label">CN Number</label>
                    <input type="text" 
                           class="form-control" 
                           id="cn_number" 
                           name="cn_number" 
                           value="<?php echo e(request('cn_number')); ?>" 
                           placeholder="Enter CN Number">
                </div>
                <div class="col-md-3 mb-3">
                    <label for="shipper_name" class="form-label">Shipper Name</label>
                    <input type="text" 
                           class="form-control" 
                           id="shipper_name" 
                           name="shipper_name" 
                           value="<?php echo e(request('shipper_name')); ?>" 
                           placeholder="Enter Shipper Name">
                </div>
                <div class="col-md-3 mb-3">
                    <label for="consignee_name" class="form-label">Consignee Name</label>
                    <input type="text" 
                           class="form-control" 
                           id="consignee_name" 
                           name="consignee_name" 
                           value="<?php echo e(request('consignee_name')); ?>" 
                           placeholder="Enter Consignee Name">
                </div>
                <div class="col-md-3 mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">All Status</option>
                        <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($status); ?>" <?php echo e(request('status') == $status ? 'selected' : ''); ?>>
                            <?php echo e(ucfirst(str_replace('-', ' ', $status))); ?>

                        </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="city" class="form-label">Entry City</label>
                    <select class="form-select" id="city" name="city">
                        <option value="">All Cities</option>
                        <?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($city->city_id); ?>" <?php echo e(request('city') == $city->city_id ? 'selected' : ''); ?>>
                            <?php echo e($city->name); ?>

                        </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="vehicle_id" class="form-label">Vehicle</label>
                    <select class="form-select" id="vehicle_id" name="vehicle_id">
                        <option value="">All Vehicles</option>
                        <?php $__currentLoopData = $vehicles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vehicle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($vehicle->vehicle_id); ?>" <?php echo e(request('vehicle_id') == $vehicle->vehicle_id ? 'selected' : ''); ?>>
                            <?php echo e($vehicle->registration_no); ?> (<?php echo e($vehicle->type); ?>)
                        </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="driver_id" class="form-label">Driver</label>
                    <select class="form-select" id="driver_id" name="driver_id">
                        <option value="">All Drivers</option>
                        <?php $__currentLoopData = $drivers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $driver): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($driver->driver_id); ?>" <?php echo e(request('driver_id') == $driver->driver_id ? 'selected' : ''); ?>>
                            <?php echo e($driver->name); ?>

                        </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="date_from" class="form-label">Date From</label>
                    <input type="date" 
                           class="form-control" 
                           id="date_from" 
                           name="date_from" 
                           value="<?php echo e(request('date_from')); ?>">
                </div>
                <div class="col-md-3 mb-3">
                    <label for="date_to" class="form-label">Date To</label>
                    <input type="date" 
                           class="form-control" 
                           id="date_to" 
                           name="date_to" 
                           value="<?php echo e(request('date_to')); ?>">
                </div>
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary">
                     Search
                </button>
                <a href="<?php echo e(route('shipments.detail-search')); ?>" class="btn btn-secondary">
                     Reset
                </a>
                <?php if(request()->hasAny(['cn_number', 'shipper_name', 'consignee_name', 'status', 'city', 'vehicle_id', 'driver_id', 'date_from', 'date_to'])): ?>
                <a href="<?php echo e(route('shipments.detail-search', request()->all())); ?>&export=excel" class="btn btn-success">
                     Export Excel
                </a>
                <?php endif; ?>
            </div>
        </form>

        <?php if($shipments->count() > 0): ?>
        <div class="table-responsive">
            <table class="table table-hover table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>CN Number</th>
                        <th>Entry City</th>
                        <th>Shipper</th>
                        <th>Consignee</th>
                        <th>Pickup → Delivery</th>
                        <th>Vehicle</th>
                        <th>Driver</th>
                        <th>Status</th>
                        <th>Total Charges</th>
                        <th>Created Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $shipments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shipment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><strong><?php echo e($shipment->shipment_number); ?></strong></td>
                        <td><?php echo e($shipment->entryCity->name ?? 'N/A'); ?></td>
                        <td><?php echo e($shipment->shipper_name); ?></td>
                        <td><?php echo e($shipment->consignee_name); ?></td>
                        <td><?php echo e($shipment->pickup_city); ?> → <?php echo e($shipment->delivery_city); ?></td>
                        <td><?php echo e($shipment->vehicle->registration_no ?? 'N/A'); ?></td>
                        <td><?php echo e($shipment->driver->name ?? 'N/A'); ?></td>
                        <td>
                            <span class="badge bg-<?php echo e($shipment->status === 'delivered' ? 'success' : ($shipment->status === 'cancelled' ? 'danger' : 'warning')); ?>">
                                <?php echo e(ucfirst(str_replace('-', ' ', $shipment->status))); ?>

                            </span>
                        </td>
                        <td>Rs.<?php echo e(number_format($shipment->total_charges, 2)); ?></td>
                        <td><?php echo e($shipment->created_at->format('Y-m-d')); ?></td>
                        <td>
                            <a href="<?php echo e(route('shipments.show', $shipment)); ?>" class="btn btn-sm btn-outline-info" title="View">
                                
                            </a>
                            <a href="<?php echo e(route('shipments.edit', $shipment)); ?>" class="btn btn-sm btn-outline-primary" title="Edit">
                                
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            <?php echo e($shipments->links()); ?>

        </div>
        <div class="mt-2">
            <p class="text-muted">Found <strong><?php echo e($shipments->total()); ?></strong> CN entries matching your criteria.</p>
        </div>
        <?php elseif(request()->hasAny(['cn_number', 'shipper_name', 'consignee_name', 'status', 'city', 'vehicle_id', 'driver_id', 'date_from', 'date_to'])): ?>
        <div class="alert alert-info mt-3">
             No CN entries found matching your search criteria.
        </div>
        <?php else: ?>
        <div class="alert alert-secondary mt-3">
             Enter search criteria above to find CN entries.
        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/Logistics-Management-System/resources/views/shipments/detail-search.blade.php ENDPATH**/ ?>