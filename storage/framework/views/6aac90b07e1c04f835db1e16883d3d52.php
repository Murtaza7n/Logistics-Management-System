<?php $__env->startSection('title', 'Create CN Book'); ?>
<?php $__env->startSection('page-title', 'Create CN Book'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Create New CN Book</h5>
    </div>
    <div class="card-body">
        <form action="<?php echo e(route('cn-books.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="book_number" class="form-label">Book Number <span class="text-danger">*</span></label>
                    <input type="text" class="form-control <?php $__errorArgs = ['book_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                           id="book_number" name="book_number" value="<?php echo e(old('book_number')); ?>" required>
                    <small class="form-text text-muted">Unique identifier (e.g., BOOK-001)</small>
                    <?php $__errorArgs = ['book_number'];
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

                <div class="col-md-6 mb-3">
                    <label for="book_name" class="form-label">Book Name</label>
                    <input type="text" class="form-control" id="book_name" name="book_name" 
                           value="<?php echo e(old('book_name')); ?>" placeholder="Optional descriptive name">
                </div>

                <div class="col-md-4 mb-3">
                    <label for="city_code" class="form-label">City Code</label>
                    <select class="form-select" id="city_code" name="city_code">
                        <option value="">Select City (Optional)</option>
                        <?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($city->code); ?>" <?php echo e(old('city_code') == $city->code ? 'selected' : ''); ?>>
                                <?php echo e($city->code); ?> - <?php echo e($city->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label for="system_year" class="form-label">System Year</label>
                    <input type="text" class="form-control" id="system_year" name="system_year" 
                           value="<?php echo e(old('system_year', session('system_year', '2526'))); ?>" 
                           placeholder="e.g., 2526">
                </div>

                <div class="col-md-4 mb-3">
                    <label for="issue_date" class="form-label">Issue Date</label>
                    <input type="date" class="form-control" id="issue_date" name="issue_date" 
                           value="<?php echo e(old('issue_date', date('Y-m-d'))); ?>">
                </div>

                <div class="col-md-6 mb-3">
                    <label for="start_number" class="form-label">Start Number <span class="text-danger">*</span></label>
                    <input type="number" class="form-control <?php $__errorArgs = ['start_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                           id="start_number" name="start_number" value="<?php echo e(old('start_number')); ?>" 
                           min="1" required>
                    <?php $__errorArgs = ['start_number'];
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

                <div class="col-md-6 mb-3">
                    <label for="end_number" class="form-label">End Number <span class="text-danger">*</span></label>
                    <input type="number" class="form-control <?php $__errorArgs = ['end_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                           id="end_number" name="end_number" value="<?php echo e(old('end_number')); ?>" 
                           min="1" required>
                    <small class="form-text text-muted">Must be greater than start number</small>
                    <?php $__errorArgs = ['end_number'];
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

                <div class="col-md-6 mb-3">
                    <label for="expiry_date" class="form-label">Expiry Date (Optional)</label>
                    <input type="date" class="form-control" id="expiry_date" name="expiry_date" 
                           value="<?php echo e(old('expiry_date')); ?>">
                </div>

                <div class="col-md-12 mb-3">
                    <label for="notes" class="form-label">Notes</label>
                    <textarea class="form-control" id="notes" name="notes" rows="3"><?php echo e(old('notes')); ?></textarea>
                </div>
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Create CN Book</button>
                <a href="<?php echo e(route('cn-books.index')); ?>" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const startNumber = document.getElementById('start_number');
        const endNumber = document.getElementById('end_number');
        
        // Update end number min when start number changes
        startNumber.addEventListener('change', function() {
            endNumber.min = parseInt(this.value) + 1;
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/Logistics-Management-System/resources/views/cn-books/create.blade.php ENDPATH**/ ?>