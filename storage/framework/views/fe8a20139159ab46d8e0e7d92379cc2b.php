<?php $__env->startSection('title', 'Shipment Details'); ?>
<?php $__env->startSection('page-title', 'Shipment Details'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"> Shipment Information</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="40%">CN Number / Consignment Note:</th>
                        <td><strong><?php echo e($shipment->shipment_number); ?></strong></td>
                    </tr>
                    <tr>
                        <th>Customer:</th>
                        <td><?php echo e($shipment->customer->name); ?></td>
                    </tr>
                    <tr>
                        <th>Vendor:</th>
                        <td><?php echo e($shipment->vendor->name ?? 'N/A'); ?></td>
                    </tr>
                    <tr>
                        <th>Sender:</th>
                        <td><?php echo e($shipment->sender); ?></td>
                    </tr>
                    <tr>
                        <th>Receiver:</th>
                        <td><?php echo e($shipment->receiver); ?></td>
                    </tr>
                    <tr>
                        <th>Route:</th>
                        <td><?php echo e($shipment->pickup_city); ?> → <?php echo e($shipment->delivery_city); ?></td>
                    </tr>
                    <tr>
                        <th>Cargo Type:</th>
                        <td><?php echo e($shipment->cargo_type); ?></td>
                    </tr>
                    <tr>
                        <th>Weight:</th>
                        <td><?php echo e($shipment->weight ?? 'N/A'); ?> kg</td>
                    </tr>
                    <tr>
                        <th>Dimension:</th>
                        <td><?php echo e($shipment->dimension ?? 'N/A'); ?></td>
                    </tr>
                    <tr>
                        <th>Vehicle:</th>
                        <td><?php echo e($shipment->vehicle->registration_no ?? 'N/A'); ?></td>
                    </tr>
                    <tr>
                        <th>Driver:</th>
                        <td><?php echo e($shipment->driver->name ?? 'N/A'); ?></td>
                    </tr>
                    <tr>
                        <th>Status:</th>
                        <td><span class="badge bg-<?php echo e($shipment->status === 'delivered' ? 'success' : ($shipment->status === 'cancelled' ? 'danger' : 'warning')); ?>"><?php echo e(ucfirst(str_replace('-', ' ', $shipment->status))); ?></span></td>
                    </tr>
                    <tr>
                        <th>Total Charges:</th>
                        <td><strong>Rs.<?php echo e(number_format($shipment->total_charges, 2)); ?></strong></td>
                    </tr>
                </table>
                <div class="mt-3">
                    <a href="<?php echo e(route('shipments.edit', $shipment)); ?>" class="btn btn-primary">
                         Edit
                    </a>
                    <a href="<?php echo e(route('shipments.index')); ?>" class="btn btn-secondary">
                         Back
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/Logistics-Management-System/resources/views/shipments/show.blade.php ENDPATH**/ ?>