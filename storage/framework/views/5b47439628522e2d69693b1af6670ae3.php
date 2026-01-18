<?php $__env->startSection('title', 'Record Payment'); ?>
<?php $__env->startSection('page-title', 'Record Payment'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
        <h5 class="mb-0"> Record Payment</h5>
    </div>
    <div class="card-body">
        <form action="<?php echo e(route('payments.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="invoice_id" class="form-label">Invoice <span class="text-danger">*</span></label>
                    <select class="form-select" id="invoice_id" name="invoice_id" required>
                        <option value="">Select Invoice</option>
                        <?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($inv->invoice_id); ?>" <?php echo e(old('invoice_id', request('invoice_id')) == $inv->invoice_id ? 'selected' : ''); ?>>
                            <?php echo e($inv->invoice_number); ?> - Balance: Rs.<?php echo e(number_format($inv->balance, 2)); ?>

                        </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="amount_paid" class="form-label">Amount Paid <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" class="form-control" id="amount_paid" name="amount_paid" value="<?php echo e(old('amount_paid')); ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="payment_date" class="form-label">Payment Date <span class="text-danger">*</span></label>
                    <input type="date" class="form-control" id="payment_date" name="payment_date" value="<?php echo e(old('payment_date', date('Y-m-d'))); ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="method" class="form-label">Payment Method <span class="text-danger">*</span></label>
                    <select class="form-select" id="method" name="method" required>
                        <option value="cash" <?php echo e(old('method') === 'cash' ? 'selected' : ''); ?>>Cash</option>
                        <option value="bank_transfer" <?php echo e(old('method') === 'bank_transfer' ? 'selected' : ''); ?>>Bank Transfer</option>
                        <option value="cheque" <?php echo e(old('method') === 'cheque' ? 'selected' : ''); ?>>Cheque</option>
                        <option value="credit_card" <?php echo e(old('method') === 'credit_card' ? 'selected' : ''); ?>>Credit Card</option>
                        <option value="other" <?php echo e(old('method') === 'other' ? 'selected' : ''); ?>>Other</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="reference_number" class="form-label">Reference Number</label>
                    <input type="text" class="form-control" id="reference_number" name="reference_number" value="<?php echo e(old('reference_number')); ?>">
                </div>
                <div class="col-md-12 mb-3">
                    <label for="notes" class="form-label">Notes</label>
                    <textarea class="form-control" id="notes" name="notes" rows="2"><?php echo e(old('notes')); ?></textarea>
                </div>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">
                     Record Payment
                </button>
                <a href="<?php echo e(route('payments.index')); ?>" class="btn btn-secondary">
                     Cancel
                </a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/Logistics-Management-System/resources/views/payments/create.blade.php ENDPATH**/ ?>