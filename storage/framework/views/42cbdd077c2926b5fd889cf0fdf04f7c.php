<?php $__env->startSection('title', 'Create Invoice'); ?>
<?php $__env->startSection('page-title', 'Create Invoice'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
        <h5 class="mb-0"> Create New Invoice</h5>
    </div>
    <div class="card-body">
        <form action="<?php echo e(route('invoices.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="invoice_type" class="form-label">Invoice Type <span class="text-danger">*</span></label>
                    <select class="form-select" id="invoice_type" name="invoice_type" required>
                        <option value="customer" <?php echo e(old('invoice_type') === 'customer' ? 'selected' : ''); ?>>Customer</option>
                        <option value="vendor" <?php echo e(old('invoice_type') === 'vendor' ? 'selected' : ''); ?>>Vendor</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3" id="customer_field">
                    <label for="customer_id" class="form-label">Customer <span class="text-danger">*</span></label>
                    <select class="form-select" id="customer_id" name="customer_id">
                        <option value="">Select Customer</option>
                        <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($customer->customer_id); ?>" <?php echo e(old('customer_id') == $customer->customer_id ? 'selected' : ''); ?>><?php echo e($customer->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3" id="vendor_field" style="display:none;">
                    <label for="vendor_id" class="form-label">Vendor <span class="text-danger">*</span></label>
                    <select class="form-select" id="vendor_id" name="vendor_id">
                        <option value="">Select Vendor</option>
                        <?php $__currentLoopData = $vendors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vendor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($vendor->vendor_id); ?>" <?php echo e(old('vendor_id') == $vendor->vendor_id ? 'selected' : ''); ?>><?php echo e($vendor->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="invoice_date" class="form-label">Invoice Date <span class="text-danger">*</span></label>
                    <input type="date" class="form-control" id="invoice_date" name="invoice_date" value="<?php echo e(old('invoice_date', date('Y-m-d'))); ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="due_date" class="form-label">Due Date</label>
                    <input type="date" class="form-control" id="due_date" name="due_date" value="<?php echo e(old('due_date')); ?>">
                </div>
                <div class="col-md-12 mb-3">
                    <label for="shipment_ids" class="form-label">Shipments <span class="text-danger">*</span></label>
                    <select class="form-select" id="shipment_ids" name="shipment_ids[]" multiple required size="5">
                        <?php $__currentLoopData = $shipments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shipment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($shipment->shipment_id); ?>"><?php echo e($shipment->shipment_number); ?> - Rs.<?php echo e(number_format($shipment->total_charges, 2)); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <small class="form-text text-muted">Hold Ctrl/Cmd to select multiple shipments</small>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="tax_rate" class="form-label">Tax Rate (%)</label>
                    <input type="number" step="0.01" class="form-control" id="tax_rate" name="tax_rate" value="<?php echo e(old('tax_rate', 0)); ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="discount" class="form-label">Discount</label>
                    <input type="number" step="0.01" class="form-control" id="discount" name="discount" value="<?php echo e(old('discount', 0)); ?>">
                </div>
                <div class="col-md-12 mb-3">
                    <label for="notes" class="form-label">Notes</label>
                    <textarea class="form-control" id="notes" name="notes" rows="2"><?php echo e(old('notes')); ?></textarea>
                </div>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">
                     Create Invoice
                </button>
                <a href="<?php echo e(route('invoices.index')); ?>" class="btn btn-secondary">
                     Cancel
                </a>
            </div>
        </form>
    </div>
</div>
<script>
document.getElementById('invoice_type').addEventListener('change', function() {
    const customerField = document.getElementById('customer_field');
    const vendorField = document.getElementById('vendor_field');
    if (this.value === 'vendor') {
        customerField.style.display = 'none';
        vendorField.style.display = 'block';
        document.getElementById('customer_id').required = false;
        document.getElementById('vendor_id').required = true;
    } else {
        customerField.style.display = 'block';
        vendorField.style.display = 'none';
        document.getElementById('customer_id').required = true;
        document.getElementById('vendor_id').required = false;
    }
});
</script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/Logistics-Management-System/resources/views/invoices/create.blade.php ENDPATH**/ ?>