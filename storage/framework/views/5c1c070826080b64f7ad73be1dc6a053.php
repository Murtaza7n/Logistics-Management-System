<?php $__env->startSection('title', 'C/N In-Stock Report'); ?>
<?php $__env->startSection('page-title', 'C/N In-Stock Report'); ?>

<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">
        
        C/N In-Stock Report
    </h1>
    <p class="page-subtitle">Consignment notes currently in stock (booked or picked up)</p>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"> Filters</h5>
    </div>
    <div class="card-body">
        <form method="GET" action="<?php echo e(route('reports.cn-in-stock')); ?>" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">City</label>
                <select name="city_id" class="form-select">
                    <option value="">All Cities</option>
                    <?php $__currentLoopData = \App\Models\City::where('is_active', true)->orderBy('name')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($city->city_id); ?>" <?php echo e(request('city_id') == $city->city_id ? 'selected' : ''); ?>>
                        <?php echo e($city->name); ?>

                    </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
        <h5 class="mb-0"> C/N In-Stock (<?php echo e($shipments->count()); ?> records)</h5>
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
                        <th>Status</th>
                        <th>Created Date</th>
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
                        <td>
                            <span class="badge badge-secondary">
                                <?php echo e(ucfirst(str_replace('-', ' ', $shipment->status))); ?>

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


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/Logistics-Management-System/resources/views/reports/cn_in_stock.blade.php ENDPATH**/ ?>