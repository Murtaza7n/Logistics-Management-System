<?php $__env->startSection('title', 'Un-Post Data'); ?>
<?php $__env->startSection('page-title', 'Un-Post Data with Date Range'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <h1 class="page-title">
        <i class="bi bi-x-circle"></i> Un-Post Data with Date Range
    </h1>
    <p class="page-subtitle">Un-post posted data within a specific date range</p>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Un-Post Data</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="<?php echo e(route('system.process-unpost-data')); ?>" onsubmit="return confirm('Are you sure you want to un-post data? This action cannot be undone.');">
            <?php echo csrf_field(); ?>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="date_from" class="form-label">From Date</label>
                        <input type="date" class="form-control <?php $__errorArgs = ['date_from'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               id="date_from" name="date_from" required>
                        <?php $__errorArgs = ['date_from'];
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
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="date_to" class="form-label">To Date</label>
                        <input type="date" class="form-control <?php $__errorArgs = ['date_to'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               id="date_to" name="date_to" required>
                        <?php $__errorArgs = ['date_to'];
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
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Data Type</label>
                        <select class="form-select" name="data_type" required>
                            <option value="">Select Data Type</option>
                            <option value="shipments">Shipments</option>
                            <option value="invoices">Invoices</option>
                            <option value="payments">Payments</option>
                            <option value="payrolls">Payrolls</option>
                            <option value="all">All Data Types</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="reason" class="form-label">Reason</label>
                        <textarea class="form-control <?php $__errorArgs = ['reason'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                  id="reason" name="reason" rows="3" 
                                  placeholder="Enter reason for un-posting" required></textarea>
                        <?php $__errorArgs = ['reason'];
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
            </div>
            <div class="alert alert-danger">
                <i class="bi bi-exclamation-triangle-fill"></i> <strong>Warning:</strong> Un-posting data will reverse all posted transactions within the selected date range. This is a critical operation and should be performed with caution.
            </div>
            <button type="submit" class="btn btn-danger">
                <i class="bi bi-x-octagon"></i> Un-Post Data
            </button>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/Logistics-Management-System/resources/views/system/unpost-data.blade.php ENDPATH**/ ?>