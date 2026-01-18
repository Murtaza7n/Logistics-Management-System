<?php $__env->startSection('title', 'Create Booking'); ?>
<?php $__env->startSection('page-title', 'Create New Booking'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <h1 class="page-title">Create New Booking</h1>
    <p class="page-subtitle">Enter booking details</p>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Booking Details</h5>
    </div>
    <div class="card-body">
        <form action="<?php echo e(route('bookings.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            
            <div class="row mb-3">
                <div class="col-md-3">
                    <label for="booking_number" class="form-label">Booking Number <span class="text-danger">*</span></label>
                    <input type="text" class="form-control <?php $__errorArgs = ['booking_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                           id="booking_number" name="booking_number" 
                           value="<?php echo e(old('booking_number')); ?>" required>
                    <?php $__errorArgs = ['booking_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="col-md-3">
                    <label for="booking_date" class="form-label">Booking Date <span class="text-danger">*</span></label>
                    <input type="date" class="form-control <?php $__errorArgs = ['booking_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                           id="booking_date" name="booking_date" 
                           value="<?php echo e(old('booking_date', date('Y-m-d'))); ?>" required>
                    <?php $__errorArgs = ['booking_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="col-md-3">
                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                    <select class="form-select <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="status" name="status" required>
                        <option value="pending" <?php echo e(old('status') == 'pending' ? 'selected' : ''); ?>>Pending</option>
                        <option value="confirmed" <?php echo e(old('status') == 'confirmed' ? 'selected' : ''); ?>>Confirmed</option>
                        <option value="cancelled" <?php echo e(old('status') == 'cancelled' ? 'selected' : ''); ?>>Cancelled</option>
                    </select>
                    <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <!-- Shipper Section -->
            <div class="card mb-3" style="border-left: 4px solid var(--success-color);">
                <div class="card-header bg-success text-white">
                    <strong>SHIPPER INFORMATION</strong>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label for="shipper_code" class="form-label">Code</label>
                            <select class="form-select" id="shipper_code" name="shipper_code">
                                <option value="">Choose Account Code...</option>
                                <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($customer->account_code ?? $customer->customer_id); ?>" 
                                        data-name="<?php echo e($customer->name); ?>"
                                        data-address="<?php echo e($customer->address); ?>"
                                        data-contact="<?php echo e($customer->contact); ?>"
                                        <?php echo e(old('shipper_code') == ($customer->account_code ?? $customer->customer_id) ? 'selected' : ''); ?>>
                                    <?php echo e($customer->account_code ?? 'CUST-' . $customer->customer_id); ?> - <?php echo e($customer->name); ?>

                                </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="customer_id" class="form-label">Link Customer</label>
                            <select class="form-select" id="customer_id" name="customer_id">
                                <option value="">Select Customer (Optional)</option>
                                <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($customer->customer_id); ?>" <?php echo e(old('customer_id') == $customer->customer_id ? 'selected' : ''); ?>><?php echo e($customer->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="shipper_name" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control <?php $__errorArgs = ['shipper_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="shipper_name" name="shipper_name" 
                                   value="<?php echo e(old('shipper_name')); ?>" required>
                            <?php $__errorArgs = ['shipper_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="shipper_address_line1" class="form-label">Address Line 1</label>
                            <input type="text" class="form-control" id="shipper_address_line1" 
                                   name="shipper_address_line1" value="<?php echo e(old('shipper_address_line1')); ?>">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="shipper_address_line2" class="form-label">Address Line 2</label>
                            <input type="text" class="form-control" id="shipper_address_line2" 
                                   name="shipper_address_line2" value="<?php echo e(old('shipper_address_line2')); ?>">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="shipper_address_line3" class="form-label">Address Line 3</label>
                            <input type="text" class="form-control" id="shipper_address_line3" 
                                   name="shipper_address_line3" value="<?php echo e(old('shipper_address_line3')); ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="shipper_contact" class="form-label">Contact</label>
                            <input type="text" class="form-control" id="shipper_contact" 
                                   name="shipper_contact" value="<?php echo e(old('shipper_contact')); ?>">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Consignee Section -->
            <div class="card mb-3" style="border-left: 4px solid var(--info-color);">
                <div class="card-header bg-info text-white">
                    <strong>CONSIGNEE INFORMATION</strong>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label for="consignee_code" class="form-label">Code</label>
                            <select class="form-select" id="consignee_code" name="consignee_code">
                                <option value="">Choose Account Code...</option>
                                <?php $__currentLoopData = $vendors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vendor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($vendor->account_code ?? $vendor->vendor_id); ?>" 
                                        data-name="<?php echo e($vendor->name); ?>"
                                        data-address="<?php echo e($vendor->address); ?>"
                                        data-contact="<?php echo e($vendor->contact); ?>"
                                        <?php echo e(old('consignee_code') == ($vendor->account_code ?? $vendor->vendor_id) ? 'selected' : ''); ?>>
                                    <?php echo e($vendor->account_code ?? 'VEND-' . $vendor->vendor_id); ?> - <?php echo e($vendor->name); ?>

                                </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="vendor_id" class="form-label">Link Vendor</label>
                            <select class="form-select" id="vendor_id" name="vendor_id">
                                <option value="">Select Vendor (Optional)</option>
                                <?php $__currentLoopData = $vendors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vendor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($vendor->vendor_id); ?>" <?php echo e(old('vendor_id') == $vendor->vendor_id ? 'selected' : ''); ?>><?php echo e($vendor->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="consignee_name" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control <?php $__errorArgs = ['consignee_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="consignee_name" name="consignee_name" 
                                   value="<?php echo e(old('consignee_name')); ?>" required>
                            <?php $__errorArgs = ['consignee_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="consignee_address_line1" class="form-label">Address Line 1</label>
                            <input type="text" class="form-control" id="consignee_address_line1" 
                                   name="consignee_address_line1" value="<?php echo e(old('consignee_address_line1')); ?>">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="consignee_address_line2" class="form-label">Address Line 2</label>
                            <input type="text" class="form-control" id="consignee_address_line2" 
                                   name="consignee_address_line2" value="<?php echo e(old('consignee_address_line2')); ?>">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="consignee_address_line3" class="form-label">Address Line 3</label>
                            <input type="text" class="form-control" id="consignee_address_line3" 
                                   name="consignee_address_line3" value="<?php echo e(old('consignee_address_line3')); ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="consignee_contact" class="form-label">Contact</label>
                            <input type="text" class="form-control" id="consignee_contact" 
                                   name="consignee_contact" value="<?php echo e(old('consignee_contact')); ?>">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cargo Details -->
            <div class="card mb-3">
                <div class="card-header">
                    <strong>CARGO DETAILS</strong>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label for="pickup_city" class="form-label">Pickup City <span class="text-danger">*</span></label>
                            <select class="form-select <?php $__errorArgs = ['pickup_city'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="pickup_city" name="pickup_city" required>
                                <option value="">Select City</option>
                                <?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($city->name); ?>" <?php echo e(old('pickup_city') == $city->name ? 'selected' : ''); ?>><?php echo e($city->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['pickup_city'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="delivery_city" class="form-label">Delivery City <span class="text-danger">*</span></label>
                            <select class="form-select <?php $__errorArgs = ['delivery_city'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="delivery_city" name="delivery_city" required>
                                <option value="">Select City</option>
                                <?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($city->name); ?>" <?php echo e(old('delivery_city') == $city->name ? 'selected' : ''); ?>><?php echo e($city->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['delivery_city'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="cargo_type" class="form-label">Cargo Type</label>
                            <input type="text" class="form-control" id="cargo_type" name="cargo_type" value="<?php echo e(old('cargo_type')); ?>">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="weight" class="form-label">Weight (kg)</label>
                            <input type="number" step="0.01" class="form-control" id="weight" name="weight" value="<?php echo e(old('weight')); ?>">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" value="<?php echo e(old('quantity', 1)); ?>" min="1">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="estimated_freight" class="form-label">Estimated Freight</label>
                            <input type="number" step="0.01" class="form-control" id="estimated_freight" name="estimated_freight" value="<?php echo e(old('estimated_freight')); ?>">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notes -->
            <div class="mb-3">
                <label for="notes" class="form-label">Notes</label>
                <textarea class="form-control" id="notes" name="notes" rows="3"><?php echo e(old('notes')); ?></textarea>
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Create Booking</button>
                <a href="<?php echo e(route('bookings.index')); ?>" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script>
// Auto-fill shipper details
document.getElementById('shipper_code').addEventListener('change', function() {
    const option = this.options[this.selectedIndex];
    if (option.dataset.name) {
        document.getElementById('shipper_name').value = option.dataset.name || '';
        document.getElementById('shipper_address_line1').value = option.dataset.address || '';
        document.getElementById('shipper_contact').value = option.dataset.contact || '';
    }
});

// Auto-fill consignee details
document.getElementById('consignee_code').addEventListener('change', function() {
    const option = this.options[this.selectedIndex];
    if (option.dataset.name) {
        document.getElementById('consignee_name').value = option.dataset.name || '';
        document.getElementById('consignee_address_line1').value = option.dataset.address || '';
        document.getElementById('consignee_contact').value = option.dataset.contact || '';
    }
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/Logistics-Management-System/resources/views/bookings/create.blade.php ENDPATH**/ ?>