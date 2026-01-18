<?php $__env->startSection('title', 'Change Year'); ?>
<?php $__env->startSection('page-title', 'Change System Year'); ?>

<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">
        
        Change System Year
    </h1>
    <p class="page-subtitle">Update the current system year for data segregation</p>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"> Current Year: <?php echo e($currentYear); ?></h5>
    </div>
    <div class="card-body">
        <form method="POST" action="<?php echo e(route('system.update-year')); ?>">
            <?php echo csrf_field(); ?>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="year" class="form-label">Select Year</label>
                        <select class="form-select <?php $__errorArgs = ['year'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="year" name="year" required>
                            <option value="2526" <?php echo e($currentYear == '2526' ? 'selected' : ''); ?>>2526</option>
                            <option value="2425" <?php echo e($currentYear == '2425' ? 'selected' : ''); ?>>2425</option>
                            <option value="2324" <?php echo e($currentYear == '2324' ? 'selected' : ''); ?>>2324</option>
                            <option value="2223" <?php echo e($currentYear == '2223' ? 'selected' : ''); ?>>2223</option>
                            <option value="2122" <?php echo e($currentYear == '2122' ? 'selected' : ''); ?>>2122</option>
                            <option value="2021" <?php echo e($currentYear == '2021' ? 'selected' : ''); ?>>2021</option>
                        </select>
                        <?php $__errorArgs = ['year'];
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
                    <button type="submit" class="btn btn-primary">
                         Change Year
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/Logistics-Management-System/resources/views/system/change-year.blade.php ENDPATH**/ ?>