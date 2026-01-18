<?php $__env->startSection('title', 'CN Entry - Create Shipment'); ?>
<?php $__env->startSection('page-title', 'CN Entry - Create Consignment Note'); ?>

<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">
        <i class="bi bi-file-plus"></i>
        Create New Consignment Note
    </h1>
    <p class="page-subtitle">Enter consignment details to create a new CN entry</p>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="bi bi-box-seam"></i> C/N ENTRY - Consignment Note Details</h5>
    </div>
    <div class="card-body">
        <form action="<?php echo e(route('shipments.store')); ?>" method="POST" id="cnEntryForm">
            <?php echo csrf_field(); ?>
            
            <!-- Top Row: CN Book, City, CN Number, C Type -->
            <div class="row mb-4 g-3">
                <div class="col-12 col-md-6 col-lg-3 mb-3">
                    <label for="cn_book_id" class="form-label">CN Book <span class="text-danger">*</span></label>
                    <select class="form-select <?php $__errorArgs = ['cn_book_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="cn_book_id" name="cn_book_id" required>
                        <option value="">Select CN Book</option>
                        <?php $__currentLoopData = $cnBooks ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($book->id); ?>" 
                                data-city-code="<?php echo e($book->city_code); ?>"
                                data-system-year="<?php echo e($book->system_year); ?>"
                                data-start="<?php echo e($book->start_number); ?>"
                                data-end="<?php echo e($book->end_number); ?>"
                                data-remaining="<?php echo e($book->remaining_count); ?>"
                                <?php echo e(old('cn_book_id') == $book->id ? 'selected' : ''); ?>>
                            <?php echo e($book->book_number); ?> (<?php echo e($book->remaining_count); ?> remaining)
                        </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php $__errorArgs = ['cn_book_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    <small class="form-text text-muted">Select the CN Book to issue number from</small>
                </div>
                <div class="col-12 col-md-6 col-lg-3 mb-3">
                    <label for="entry_city" class="form-label">City <span class="text-danger">*</span></label>
                    <select class="form-select <?php $__errorArgs = ['entry_city'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="entry_city" name="entry_city" required>
                        <option value="">Select User City</option>
                        <?php $__currentLoopData = $cities ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($city->city_id); ?>" <?php echo e(old('entry_city') == $city->city_id ? 'selected' : ''); ?>><?php echo e($city->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php $__errorArgs = ['entry_city'];
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
                <div class="col-12 col-md-6 col-lg-3 mb-3">
                    <label for="shipment_number" class="form-label">
                        C/N No. <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
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
                               value="<?php echo e(old('shipment_number')); ?>" 
                               placeholder="Enter CN Number or Auto-generate"
                               autofocus>
                        <button type="button" 
                                class="btn btn-outline-secondary" 
                                id="autoGenerateBtn"
                                title="Auto-generate CN Number">
                            Auto
                        </button>
                        <input type="hidden" name="auto_generate_cn" id="auto_generate_cn" value="0">
                    </div>
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
                    <small class="form-text text-muted">Leave empty and click Auto to generate automatically</small>
                </div>
                <div class="col-12 col-md-6 col-lg-4 mb-3">
                    <label for="system_year" class="form-label">System Year</label>
                    <select class="form-select" id="system_year" name="system_year">
                        <option value="2526" <?php echo e(old('system_year', session('system_year', '2526')) == '2526' ? 'selected' : ''); ?>>2526</option>
                        <option value="2425" <?php echo e(old('system_year') == '2425' ? 'selected' : ''); ?>>2425</option>
                        <option value="2324" <?php echo e(old('system_year') == '2324' ? 'selected' : ''); ?>>2324</option>
                        <option value="2223" <?php echo e(old('system_year') == '2223' ? 'selected' : ''); ?>>2223</option>
                        <option value="2122" <?php echo e(old('system_year') == '2122' ? 'selected' : ''); ?>>2122</option>
                        <option value="2021" <?php echo e(old('system_year') == '2021' ? 'selected' : ''); ?>>2021</option>
                        <option value="1920" <?php echo e(old('system_year') == '1920' ? 'selected' : ''); ?>>1920</option>
                        <option value="1819" <?php echo e(old('system_year') == '1819' ? 'selected' : ''); ?>>1819</option>
                    </select>
                </div>
                <div class="col-12 col-md-6 col-lg-4 mb-3">
                    <label for="cn_type" class="form-label">C (Type)</label>
                    <input type="text" 
                           class="form-control" 
                           id="cn_type" 
                           name="cn_type" 
                           value="<?php echo e(old('cn_type')); ?>" 
                           placeholder="CN Type">
                </div>
            </div>

            <!-- Shipper Section -->
            <div class="card mb-4" style="border-left: 4px solid var(--success-color);">
                <div class="section-header">
                    <i class="bi bi-person"></i>
                    <span>SHIPPER INFORMATION</span>
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
                        <div class="col-md-9 mb-3">
                            <label for="shipper_name" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control <?php $__errorArgs = ['shipper_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="shipper_name" 
                                   name="shipper_name" 
                                   value="<?php echo e(old('shipper_name')); ?>" 
                                   required>
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
                            <input type="text" 
                                   class="form-control" 
                                   id="shipper_address_line1" 
                                   name="shipper_address_line1" 
                                   value="<?php echo e(old('shipper_address_line1')); ?>">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="shipper_address_line2" class="form-label">Address Line 2</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="shipper_address_line2" 
                                   name="shipper_address_line2" 
                                   value="<?php echo e(old('shipper_address_line2')); ?>">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="shipper_address_line3" class="form-label">Address Line 3</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="shipper_address_line3" 
                                   name="shipper_address_line3" 
                                   value="<?php echo e(old('shipper_address_line3')); ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="shipper_contact" class="form-label">Contact</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="shipper_contact" 
                                   name="shipper_contact" 
                                   value="<?php echo e(old('shipper_contact')); ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="customer_id" class="form-label">Link Customer</label>
                            <select class="form-select" id="customer_id" name="customer_id">
                                <option value="">Select Customer (Optional)</option>
                                <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($customer->customer_id); ?>" <?php echo e(old('customer_id') == $customer->customer_id ? 'selected' : ''); ?>><?php echo e($customer->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Consignee Section -->
            <div class="card mb-4" style="border-left: 4px solid var(--info-color);">
                <div class="section-header info">
                    <i class="bi bi-person-check"></i>
                    <span>CONSIGNEE INFORMATION</span>
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
                        <div class="col-md-9 mb-3">
                            <label for="consignee_name" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control <?php $__errorArgs = ['consignee_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="consignee_name" 
                                   name="consignee_name" 
                                   value="<?php echo e(old('consignee_name')); ?>" 
                                   required>
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
                            <input type="text" 
                                   class="form-control" 
                                   id="consignee_address_line1" 
                                   name="consignee_address_line1" 
                                   value="<?php echo e(old('consignee_address_line1')); ?>">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="consignee_address_line2" class="form-label">Address Line 2</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="consignee_address_line2" 
                                   name="consignee_address_line2" 
                                   value="<?php echo e(old('consignee_address_line2')); ?>">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="consignee_address_line3" class="form-label">Address Line 3</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="consignee_address_line3" 
                                   name="consignee_address_line3" 
                                   value="<?php echo e(old('consignee_address_line3')); ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="consignee_contact" class="form-label">Contact</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="consignee_contact" 
                                   name="consignee_contact" 
                                   value="<?php echo e(old('consignee_contact')); ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="vendor_id" class="form-label">Link Vendor</label>
                            <select class="form-select" id="vendor_id" name="vendor_id">
                                <option value="">Select Vendor (Optional)</option>
                                <?php $__currentLoopData = $vendors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vendor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($vendor->vendor_id); ?>" <?php echo e(old('vendor_id') == $vendor->vendor_id ? 'selected' : ''); ?>><?php echo e($vendor->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cargo Details Section -->
            <div class="card mb-4" style="border-left: 4px solid var(--primary-color);">
                <div class="section-header" style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);">
                    <i class="bi bi-box"></i>
                    <span>CARGO DETAILS</span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="cargo_type" class="form-label">Cargo Type <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control" 
                                   id="cargo_type" 
                                   name="cargo_type" 
                                   value="<?php echo e(old('cargo_type')); ?>" 
                                   required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="pickup_city" class="form-label">Pickup City <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control" 
                                   id="pickup_city" 
                                   name="pickup_city" 
                                   value="<?php echo e(old('pickup_city')); ?>" 
                                   required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="delivery_city" class="form-label">Delivery City <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control" 
                                   id="delivery_city" 
                                   name="delivery_city" 
                                   value="<?php echo e(old('delivery_city')); ?>" 
                                   required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="weight" class="form-label">Weight (kg)</label>
                            <input type="number" 
                                   step="0.01" 
                                   class="form-control" 
                                   id="weight" 
                                   name="weight" 
                                   value="<?php echo e(old('weight')); ?>">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" 
                                   class="form-control" 
                                   id="quantity" 
                                   name="quantity" 
                                   value="<?php echo e(old('quantity', 1)); ?>" 
                                   min="1">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="packages" class="form-label">Packages</label>
                            <input type="number" 
                                   step="0.01" 
                                   class="form-control" 
                                   id="packages" 
                                   name="packages" 
                                   value="<?php echo e(old('packages')); ?>">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="packaging_type" class="form-label">Packaging Type</label>
                            <select class="form-select" id="packaging_type" name="packaging_type">
                                <option value="">Select Type</option>
                                <option value="Box" <?php echo e(old('packaging_type') == 'Box' ? 'selected' : ''); ?>>Box</option>
                                <option value="Carton" <?php echo e(old('packaging_type') == 'Carton' ? 'selected' : ''); ?>>Carton</option>
                                <option value="Bag" <?php echo e(old('packaging_type') == 'Bag' ? 'selected' : ''); ?>>Bag</option>
                                <option value="Pallet" <?php echo e(old('packaging_type') == 'Pallet' ? 'selected' : ''); ?>>Pallet</option>
                                <option value="Other" <?php echo e(old('packaging_type') == 'Other' ? 'selected' : ''); ?>>Other</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="dimension" class="form-label">Dimension</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="dimension" 
                                   name="dimension" 
                                   value="<?php echo e(old('dimension')); ?>" 
                                   placeholder="L x W x H">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="declared_value" class="form-label">Declared Value</label>
                            <input type="number" 
                                   step="0.01" 
                                   class="form-control" 
                                   id="declared_value" 
                                   name="declared_value" 
                                   value="<?php echo e(old('declared_value')); ?>">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charges Section -->
            <div class="card mb-4" style="border-left: 4px solid var(--warning-color);">
                <div class="section-header warning">
                    <i class="bi bi-cash-stack"></i>
                    <span>CHARGES & PAYMENT</span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label for="freight_charges" class="form-label">Freight Charges</label>
                            <input type="number" 
                                   step="0.01" 
                                   class="form-control" 
                                   id="freight_charges" 
                                   name="freight_charges" 
                                   value="<?php echo e(old('freight_charges', 0)); ?>">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="labor_charges" class="form-label">Labor Charges</label>
                            <input type="number" 
                                   step="0.01" 
                                   class="form-control" 
                                   id="labor_charges" 
                                   name="labor_charges" 
                                   value="<?php echo e(old('labor_charges', 0)); ?>">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="other_charges" class="form-label">Other Charges</label>
                            <input type="number" 
                                   step="0.01" 
                                   class="form-control" 
                                   id="other_charges" 
                                   name="other_charges" 
                                   value="<?php echo e(old('other_charges', 0)); ?>">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="payment_mode" class="form-label">Payment Mode</label>
                            <select class="form-select" id="payment_mode" name="payment_mode">
                                <option value="">Select Payment Mode</option>
                                <option value="To Pay" <?php echo e(old('payment_mode') == 'To Pay' ? 'selected' : ''); ?>>To Pay</option>
                                <option value="Paid" <?php echo e(old('payment_mode') == 'Paid' ? 'selected' : ''); ?>>Paid</option>
                                <option value="Credit" <?php echo e(old('payment_mode') == 'Credit' ? 'selected' : ''); ?>>Credit</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="delivery_type" class="form-label">Delivery Type</label>
                            <select class="form-select" id="delivery_type" name="delivery_type">
                                <option value="">Select Delivery Type</option>
                                <option value="Door Delivery" <?php echo e(old('delivery_type') == 'Door Delivery' ? 'selected' : ''); ?>>Door Delivery</option>
                                <option value="Self Pickup" <?php echo e(old('delivery_type') == 'Self Pickup' ? 'selected' : ''); ?>>Self Pickup</option>
                                <option value="Station Pickup" <?php echo e(old('delivery_type') == 'Station Pickup' ? 'selected' : ''); ?>>Station Pickup</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Assignment & Status Section -->
            <div class="card mb-4" style="border-left: 4px solid var(--accent-color);">
                <div class="section-header" style="background: linear-gradient(135deg, var(--accent-color) 0%, #0284c7 100%);">
                    <i class="bi bi-truck"></i>
                    <span>ASSIGNMENT & STATUS</span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="vehicle_id" class="form-label">Vehicle</label>
                            <select class="form-select" id="vehicle_id" name="vehicle_id">
                                <option value="">Select Vehicle</option>
                                <?php $__currentLoopData = $vehicles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vehicle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($vehicle->vehicle_id); ?>" <?php echo e(old('vehicle_id') == $vehicle->vehicle_id ? 'selected' : ''); ?>><?php echo e($vehicle->registration_no); ?> (<?php echo e($vehicle->type); ?>)</option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="driver_id" class="form-label">Driver</label>
                            <select class="form-select" id="driver_id" name="driver_id">
                                <option value="">Select Driver</option>
                                <?php $__currentLoopData = $drivers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $driver): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($driver->driver_id); ?>" <?php echo e(old('driver_id') == $driver->driver_id ? 'selected' : ''); ?>><?php echo e($driver->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="booked" <?php echo e(old('status') === 'booked' ? 'selected' : ''); ?>>Booked</option>
                                <option value="picked-up" <?php echo e(old('status') === 'picked-up' ? 'selected' : ''); ?>>Picked Up</option>
                                <option value="in-transit" <?php echo e(old('status') === 'in-transit' ? 'selected' : ''); ?>>In Transit</option>
                                <option value="out-for-delivery" <?php echo e(old('status') === 'out-for-delivery' ? 'selected' : ''); ?>>Out for Delivery</option>
                                <option value="delivered" <?php echo e(old('status') === 'delivered' ? 'selected' : ''); ?>>Delivered</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="pickup_date" class="form-label">Pickup Date</label>
                            <input type="date" 
                                   class="form-control" 
                                   id="pickup_date" 
                                   name="pickup_date" 
                                   value="<?php echo e(old('pickup_date')); ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="delivery_date" class="form-label">Expected Delivery Date</label>
                            <input type="date" 
                                   class="form-control" 
                                   id="delivery_date" 
                                   name="delivery_date" 
                                   value="<?php echo e(old('delivery_date')); ?>">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notes Section -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea class="form-control" 
                                      id="notes" 
                                      name="notes" 
                                      rows="2"><?php echo e(old('notes')); ?></textarea>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="special_instructions" class="form-label">Special Instructions</label>
                            <textarea class="form-control" 
                                      id="special_instructions" 
                                      name="special_instructions" 
                                      rows="2"><?php echo e(old('special_instructions')); ?></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="mt-3">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="bi bi-check-circle"></i> Create CN Entry
                </button>
                <a href="<?php echo e(route('shipments.index')); ?>" class="btn btn-secondary btn-lg">
                    <i class="bi bi-x-circle"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
// Auto-fill shipper details when code is selected
document.getElementById('shipper_code').addEventListener('change', function() {
    const option = this.options[this.selectedIndex];
    if (option.dataset.name) {
        document.getElementById('shipper_name').value = option.dataset.name || '';
        document.getElementById('shipper_address_line1').value = option.dataset.address || '';
        document.getElementById('shipper_contact').value = option.dataset.contact || '';
    }
});

// Auto-fill consignee details when code is selected
document.getElementById('consignee_code').addEventListener('change', function() {
    const option = this.options[this.selectedIndex];
    if (option.dataset.name) {
        document.getElementById('consignee_name').value = option.dataset.name || '';
        document.getElementById('consignee_address_line1').value = option.dataset.address || '';
        document.getElementById('consignee_contact').value = option.dataset.contact || '';
    }
});

// Auto-generate CN Number
document.getElementById('autoGenerateBtn').addEventListener('click', function() {
    const cnInput = document.getElementById('shipment_number');
    const autoGenerateInput = document.getElementById('auto_generate_cn');
    const systemYear = document.getElementById('system_year').value;
    const entryCity = document.getElementById('entry_city').value;
    
    // Set auto-generate flag
    autoGenerateInput.value = '1';
    
    // Clear the input to trigger auto-generation on server
    cnInput.value = '';
    cnInput.placeholder = 'Will be auto-generated on save';
    cnInput.readOnly = true;
    cnInput.style.backgroundColor = '#e9ecef';
    
    // Show message
    const message = document.createElement('small');
    message.className = 'text-success d-block mt-1';
    message.innerHTML = '<i class="bi bi-check-circle"></i> CN Number will be auto-generated on save';
    if (!cnInput.nextElementSibling || !cnInput.nextElementSibling.classList.contains('text-success')) {
        cnInput.parentElement.parentElement.appendChild(message);
    }
});

// Allow manual entry if user types
document.getElementById('shipment_number').addEventListener('input', function() {
    if (this.value.trim() !== '') {
        document.getElementById('auto_generate_cn').value = '0';
        this.readOnly = false;
        this.style.backgroundColor = '';
        this.placeholder = 'Enter CN Number';
    }
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/Logistics-Management-System/resources/views/shipments/create.blade.php ENDPATH**/ ?>