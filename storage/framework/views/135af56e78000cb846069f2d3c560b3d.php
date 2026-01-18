<?php $__env->startSection('title', 'Edit Shipment'); ?>
<?php $__env->startSection('page-title', 'Edit Shipment'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
        <h5 class="mb-0"> Edit Shipment</h5>
    </div>
    <div class="card-body">
        <form action="<?php echo e(route('shipments.update', $shipment)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="shipment_number" class="form-label">
                        CN Number / Consignment Note <span class="text-danger">*</span>
                        <small class="text-muted d-block">(Shipment Number)</small>
                    </label>
                    <input type="text" 
                           class="form-control <?php $__errorArgs = ['shipment_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                           id="shipment_number" 
                           name="shipment_number" 
                           value="<?php echo e(old('shipment_number', $shipment->shipment_number)); ?>" 
                           placeholder="Enter CN/Consignment Note Number"
                           required>
                    <?php $__errorArgs = ['shipment_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    <small class="form-text text-muted">Enter the unique Consignment Note (CN) number for this shipment</small>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="customer_id" class="form-label">Customer <span class="text-danger">*</span></label>
                    <select class="form-select" id="customer_id" name="customer_id" required>
                        <option value="">Select Customer</option>
                        <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($customer->customer_id); ?>" <?php echo e(old('customer_id', $shipment->customer_id) == $customer->customer_id ? 'selected' : ''); ?>><?php echo e($customer->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                    <select class="form-select" id="status" name="status" required>
                        <option value="booked" <?php echo e(old('status', $shipment->status) === 'booked' ? 'selected' : ''); ?>>Booked</option>
                        <option value="picked-up" <?php echo e(old('status', $shipment->status) === 'picked-up' ? 'selected' : ''); ?>>Picked Up</option>
                        <option value="in-transit" <?php echo e(old('status', $shipment->status) === 'in-transit' ? 'selected' : ''); ?>>In Transit</option>
                        <option value="out-for-delivery" <?php echo e(old('status', $shipment->status) === 'out-for-delivery' ? 'selected' : ''); ?>>Out for Delivery</option>
                        <option value="delivered" <?php echo e(old('status', $shipment->status) === 'delivered' ? 'selected' : ''); ?>>Delivered</option>
                        <option value="cancelled" <?php echo e(old('status', $shipment->status) === 'cancelled' ? 'selected' : ''); ?>>Cancelled</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="vehicle_id" class="form-label">Vehicle</label>
                    <select class="form-select" id="vehicle_id" name="vehicle_id">
                        <option value="">Select Vehicle</option>
                        <?php $__currentLoopData = $vehicles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vehicle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($vehicle->vehicle_id); ?>" <?php echo e(old('vehicle_id', $shipment->vehicle_id) == $vehicle->vehicle_id ? 'selected' : ''); ?>><?php echo e($vehicle->registration_no); ?> (<?php echo e($vehicle->type); ?>)</option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">
                     Update Shipment
                </button>
                <a href="<?php echo e(route('shipments.index')); ?>" class="btn btn-secondary">
                     Cancel
                </a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/Logistics-Management-System/resources/views/shipments/edit.blade.php ENDPATH**/ ?>